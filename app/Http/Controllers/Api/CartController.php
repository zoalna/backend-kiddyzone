<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\CartResource;
use App\Services\CartService;
use App\Models\Product;
use App\Models\Cart;

class CartController extends Controller
{
    public function cartList(){
        $cart = Cart::where('status','active')->get();
        
        $response_data = [
            'success' => 0,
            'message' => 'Cart items Found',
            'data' => CartResource::collection($cart)
        ];
        return response()->json($response_data);
    }

    public function addToCart(Request $request)
    {
        $user = auth()->user()->id;
        if(isset($request->product_id)){
            $exisit = Cart::where('user_id',$user)->where('product_id',$request->product_id)->where('status','active')->first();
            if($exisit){
                Cart::where('id',$exisit->id)->update([
                    'quantity' => $request->quantity
                ]);

                $cart = Cart::where('status','active')->get();
                $response_data = [
                    'success' => 0,
                    'message' => 'Cart Updated successfully!',
                    'data' => CartResource::collection($cart)
                ];
                return response()->json($response_data);
            }else{

                $data = Cart::create([
                    'user_id' => auth()->user()->id, 
                    'product_id' => $request->product_id,
                    'quantity' =>   $request->quantity,
                    'status' => 'active'
                ]);
                $cart = Cart::where('status','active')->get();
                $response_data = [
                    'success' => 0,
                    'message' => 'Add to cart successfully!',
                    'data' => CartResource::collection($cart)
                ];
                return response()->json($response_data);
            }
        }
      
    }

    public function removeCart(Request $request){

        $user = auth()->user()->id;
        $exisit = Cart::where('user_id',$user)->where('product_id',$request->product_id)->where('status','active')->first();
            if($exisit){
                Cart::where('id',$exisit->id)->delete();

                $cart = Cart::where('status','active')->get();
                $response_data = [
                    'success' => 0,
                    'message' => 'Cart deleted successfully!',
                    'data' => CartResource::collection($cart)
                ];
                return response()->json($response_data);
            }
        }
        
}
