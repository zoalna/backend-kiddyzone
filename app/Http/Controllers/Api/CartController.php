<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Services\CartService;
use App\Models\Product;

class CartController extends Controller
{
    public function cartList(){
        $cart = Cart::count();
        
        $response_data = [
            'success' => 0,
            'message' => 'Cart items Found',
            'data' => $cart
        ];
        return response()->json($response_data);
    }

    public function addToCart(Request $request)
    {
        $product = Product::whereId($request->id)->Active()->HasQuantity()->ActiveCategory()->firstOrFail();
        try {
            Cart::add('1', 'Product 1', 1, 9.99);
            $response_data = [
                'success' => 0,
                'message' => 'Add to cart successfully!'
            ];
            return response()->json($response_data);
        } catch(\Exception $exception) {
            $response_data = [
                'success' => 0,
                'message' => $exception->getMessage()
            ];
            return response()->json($response_data);
        }
    }
}
