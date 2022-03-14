<?php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use URL;
use Storage;

class PartnerResource extends JsonResource
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
            $image_url = URL::to('/') . Storage::disk('local')->url('images/' . $this->image_url);
            }else{
                        $image_url = URL::to('/') . Storage::disk('local')->url('images/partners/'. $this->image_url);
            }
            $image_url = $image_url;

            return [
                'id' => $this->id,
                'name' => $this->name,
                'description' => $this->description,
                'image_url'  => $image_url 
            ];
    }
}
