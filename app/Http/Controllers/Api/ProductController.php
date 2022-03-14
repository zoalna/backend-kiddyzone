<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AgeResource;
use App\Http\Resources\BrandResource;
use App\Http\Resources\PartnerResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\ProductResource;
use App\Http\ResourcesResource;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Ages;
use App\Models\Brands;
use App\Models\Partner;

class ProductController extends Controller
{
    public $successStatus = 200;
    public $failureStatus = 404;

    public function showAll(){

        $shopByAge = Ages::all();
        $shopByBrands = Brands::all();
        $shopByPartners = Partner::all();

        $categories = Category::
            active()
            ->whereParentId(null)
            ->limit(5)
            ->get();
        $hot_products = Product::
             with('firstMedia')
            ->inRandomOrder()
            ->featured()
            ->active()
            ->hasQuantity()
            ->activeCategory()
            ->take(4)
            ->get();

        $latest_products = Product::
             with('firstMedia')
             ->latest()
            ->active()
            ->hasQuantity()
            ->activeCategory()
            ->take(4)
            ->get();

        $recent_products =Product::
        with('firstMedia')
        ->latest()
       ->active()
       ->hasQuantity()
       ->activeCategory()
       ->take(4)
       ->get();

        $deal_products = Product::
           with('firstMedia')
          ->inRandomOrder()
          ->featured()
          ->active()
          ->hasQuantity()
          ->activeCategory()
          ->take(1)
          ->get();   

        $data['shop_by_age'] =   AgeResource::collection($shopByAge);
        $data['shop_by_brands'] =   BrandResource::collection($shopByBrands);     
        $data['shop_by_partners'] =   PartnerResource::collection($shopByPartners);    
        $data['shop_by_categories'] = CategoryResource::collection($categories); 
        $data['hot_products'] = ProductResource::collection($hot_products);
        $data['latest_products'] = ProductResource::collection($latest_products);
        $data['recent_products'] = ProductResource::collection($recent_products);
        $data['deal_products'] = ProductResource::collection($deal_products);
        
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
