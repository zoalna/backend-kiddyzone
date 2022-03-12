<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AgeResource;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Ages;

class ProductController extends Controller
{
    public $successStatus = 200;
    public $failureStatus = 404;

    public function showAll(){

        $shopByAge = Ages::all();

        $categories = Category::select('slug', 'cover', 'name')
            ->active()
            ->whereParentId(null)
            ->limit(5)
            ->get();
        $products = Product::select('id', 'slug', 'name', 'price')
            ->with('firstMedia')
            ->inRandomOrder()
            ->featured()
            ->active()
            ->hasQuantity()
            ->activeCategory()
            ->take(8)
            ->get();

        $data['shop_by_age'] =   AgeResource::collection($shopByAge);;      
        $data['shop_by_categories'] = $categories;
        $data['products'] = $products;

        
        if(!empty($data)){
            $response_data = [
                'success' => 1,
                'message' => 'Data found!',
                'data' => $data
              ];
            return response()->json($response_data, $this->successStatus);
        }else{
            $response_data = [
                'success' => 1,
                'message' => 'No Data found!',
                'data' => null
              ];
            return response()->json($response_data, $this->failureStatus);
        }
        
    }

    public function productDetails($slug){

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

   
}
