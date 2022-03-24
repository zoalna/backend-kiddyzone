<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\CartResource;
use App\Models\Product;
use App\Models\OrderProduct;
use App\Models\OrderTransaction;
use App\Models\Cart;
use App\Models\Order;
use Illuminate\Support\Str;
use Auth;

class CheckoutController extends Controller
{
    public function cartCheckout(Request $request){

            $user = Auth::user();
            $userAddressId = 1;
            $paymentRefId = $request->payment_reference_id;
            $total = 0;
            $subTotal = 0;
            $discountCode = "ABC123";
            $discount = 0;
            $shipping = 0;
            $shipingCompanyId = 1;
            $tax = 0;

            if(!empty($user)){
                $cartItems = Cart::where('user_id',$user->id)->where('status','active')->get();
                if(count($cartItems) > 0){
                    foreach($cartItems as $item){
                        $product = Product::where('id',$item->product_id)->first();
                        if(!empty($product->price)){
                            $total = $total + ($product->price * $item->quantity);
                        }else{
                            $total = $total;
                        }
                        
                    }
                    $subTotal = $total;
                }
                
                
                if(!empty($cartItems)){
                        $order = Order::create([
                            'ref_id' => 'ORD-' . Str::random(15),
                            'user_id' => $user->id,
                            'user_address_id' => $userAddressId,
                            'shipping_company_id' => $shipingCompanyId,
                            'payment_method_id' => $paymentRefId,
                            'subtotal' => $subTotal,
                            'discount_code' => $discountCode,
                            'discount' => $discount,
                            'shipping' => $shipping,
                            'tax' => $tax,
                            'total' => $total,
                            'currency' => 'USD',
                            'order_status' => 0,
                        ]);
                        foreach ($cartItems as $item) {
                            OrderProduct::create([
                                'order_id' => $order->id,
                                'product_id' => $item->product_id,
                                'quantity' => $item->quantity
                            ]);
                            $product = Product::find($item->product_id);
                            $product->update(['quantity' => $product->quantity - $item->quantity]);
                        }
                        $order->transactions()->create([
                            'transaction_status' => OrderTransaction::NEW_ORDER
                        ]);
                }

                $cartUpdate = Cart::where('user_id',$user->id)->where('status','active')->update(['status' => 'checkout']);
                $cart = Cart::where('status','active')->get();
                $response_data = [
                    'success' => 0,
                    'message' => 'Your order has been placed successfully!',
                    'data' => CartResource::collection($cart)
                ];
                return response()->json($response_data);
            }else{
                $response_data = [
                    'success' => 0,
                    'message' => 'Unauthorized Access!',
                    'data' => null
                ];
                return response()->json($response_data);
            }

            
    }
}
