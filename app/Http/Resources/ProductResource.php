<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use URL;
use Storage;


class ProductResource extends JsonResource
{
     /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {       
           
            $image_url = null;
            if(isset($this->firstMedia)){
                if ($this->firstMedia->file_name == 'placeholder.png' || $this->firstMedia->file_name == null) {
                    $image_url = URL::to('/') . Storage::disk('local')->url('images/products/productplaceholder.png');
                    }else{
                        $image_url = URL::to('/') . Storage::disk('local')->url('images/products/'. $this->firstMedia->file_name);
                    }
            }else{
                $image_url = url('img/product_placeholder.jpeg');
            }
            
            $image_url = $image_url;
            return [
                'id' => $this->id,
                'name' => $this->name,
                'description' => $this->description,
                'slug' => $this->slug,
                'details' => $this->details,
                'price' => $this->price,
                'quantity' => $this->quantity,
                'image_url'  => $image_url 
            ];
    }
}
