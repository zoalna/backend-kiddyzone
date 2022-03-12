<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use App\models\Users;
use Auth;

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
}
