<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Validator;

class AuthController extends Controller
{   
    public $successStatus = 200;
    public $unAuthorizedStatus = 401;

    public function login(Request $request){

        if (Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
            $user = Auth::user();
            if(isset($user)){
                $access_token =  $user->createToken('MyApp')->accessToken;
                $id = auth()->user()->id;

                $response_data = [
                    'success' => true,
                    'message' => 'Successfully Login!',
                    'auth_token' => $access_token,
                    'user' => new UserResource($user)
                ];
                return response()->json($response_data, $this->successStatus);
            }else {
                $response_data = [
                    'success' => true,
                    'message' => 'Your account is inactive please contact to site administrator!'
                ];
                return response()->json($response_data,  $this->successStatus);
            }

        } else {
            $response_data = [
                'success' => false,
                'message' => 'Invalid Email or Password, please try again.'
            ];
            return response()->json($response_data,  $this->unAuthorizedStatus);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name'         => 'required',
            'last_name'         => 'required',
            'email'         => 'required|email',
            'password'      => 'required',
            'confirm_password'    => 'required',
        ]);

        $userexist = User::where("email",$request->email)->exists();
        if($userexist == true ){
            $response_data = [
                'success' => 0,
                'message' => 'User Email Already exist!',
                'email' => '',
                'user' => null,
            ];
            return response()->json($response_data);
        }
        if( $request->password != $request->confirm_password )
        {
            $response_data = [
                'success' => 0,
                'message' => 'password and confirm password mismatched.',
                'email' => '',
                'user' => null,
            ];
            return response()->json($response_data);
        }

        $email = '';
        if ($validator->fails()) {
            foreach ($validator->messages()->getMessages() as $field_name => $messages) {
                foreach ($messages as $message) {
                    if ($field_name == 'email') {
                        $email = $message;
                    }

                }
            }
            $response_data = [
                'success' => 0,
                'message' => 'Validation error.',
                'email' => ($email != '') ? $email : 'incorrect data provided',
                'user' => null,

            ];
            return response()->json($response_data);
        }
    
        // $input['role_id'] = '2';
        $user = User::create(
            [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                "email" => $request->email,
                'username' => $request->first_name . $request->last_name,
                'password' => bcrypt($request->password),
                'status' => true
            ]
        );
        $user->assignRole('user');
        
        $data = User::find($user->id);
        // $data->fname = $input['fname'];
        // $code = rand(999, 99999);
        // $data->verify_code = $code;
        // $data->verify = 0;
        // $data->save();
        
        // email for verification
        //Helper::sendCustomEmail($data,'verify_account',$code);

        $success['token'] =  $user->createToken('MyApp')->accessToken;

        $response_data = [
            'success' => 1,
            'message' => 'User Registered Successfully!',
            'email' => '',
            'user' => new UserResource($data),
        ];
        return response()->json($response_data, $this->successStatus);
    }
}
