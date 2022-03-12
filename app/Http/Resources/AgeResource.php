<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use URL;
use Storage;

class AgeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {       
            if ($this->image_url == 'placeholder.png' || $this->image_url == null) {
            $image_url = URL::to('/') . Storage::disk('local')->url('images/ages/' . $this->image_url);
            }else{
                        $image_url = URL::to('/') . Storage::disk('local')->url('images/ages/'. $this->image_url);
            }
            $image_url = $image_url;

            return [
                'id' => $this->id,
                'from_age' => $this->from_age,
                'to_age' => $this->to_age,
                'image_url'  => $image_url 
            ];
    }
}
