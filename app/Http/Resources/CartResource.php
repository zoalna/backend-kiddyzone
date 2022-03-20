<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Product;
use URL;
use Storage;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $product = '';
        $product_subTotal = '';
        $product_unitPrice = '';
        if(!empty($this->product_id)){
            $product = Product::where('id',$this->product_id)->first();
        }
        if(!empty($product)){
            $product_subTotal = $product->price * $this->quantity;
        }
        
        $image_url = null;
            if(isset($product->firstMedia)){
                if ($product->firstMedia->file_name == 'placeholder.png' || $product->firstMedia->file_name == null) {
                    $image_url = URL::to('/') . Storage::disk('local')->url('images/' . $product->firstMedia->file_name);
                    }else{
                        $image_url = URL::to('/') . Storage::disk('local')->url('images/products/'. $product->firstMedia->file_name);
                    }
            }

         $extras = [
             'color' => 'green',
             'size' => 'small'
         ];   
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'product_id' => $this->product_id,
            'quantity' => $this->quantity,
            'status' => $this->status,
            'product_name' => $product->name,
            'product_subTotal' => $product_subTotal,
            'unit_price' => $product->price,
            'product_image_url' => $image_url,
            'extras' => $extras
        ]; 
    }
}
