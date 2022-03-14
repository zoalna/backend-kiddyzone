<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use URL;
use Storage;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {       
            if ($this->cover == 'placeholder.png' || $this->cover == null) {
            $image_url = URL::to('/') . Storage::disk('local')->url('images/' . $this->cover);
            }else{
                        $image_url = URL::to('/') . Storage::disk('local')->url('images/categories/'. $this->cover);
            }
            $image_url = $image_url;

            return [
                'id' => $this->id,
                'name' => $this->name,
                'image_url'  => $image_url 
            ];
    }
}
