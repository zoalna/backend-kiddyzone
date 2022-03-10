<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public $successStatus = 200;
    public $failureStatus = 404;

    public function show($slug){

        $product = Product::with('media', 'category', 'tags', 'approvedReviews')
        ->withCount('media')
        ->withAvg('approvedReviews', 'rating')
        ->withCount('approvedReviews')
        ->active()
        ->whereSlug($slug)
        ->hasQuantity()
        ->activeCategory()
        ->firstOrFail();

        $relatedProducts = Product::with('firstMedia')->whereHas('category', function ($query) use ($product) {
            $query->whereId($product->category_id);
            $query->whereStatus(1);
        })
            ->where('id', '<>', $product->id)
            ->inRandomOrder()
            ->active()
            ->hasQuantity()
            ->take(4)
            ->get(['id', 'slug', 'name', 'price']);

        $response_data = [
          'success' => 1,
          'message' => 'Products data!',
          'data' => $product
        ];
        return response()->json($response_data, $this->successStatus);  
    }

    public function showAllProducts(){
        
        $response_data = [
            'success' => 1,
            'message' => 'Products data!',
            'data' => $product
          ];
          return response()->json($response_data, $this->successStatus);
    }
}
