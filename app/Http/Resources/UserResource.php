<?php

namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;
use URL;
use Storage;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        if ($this->user_image == 'placeholder.png') {
                    $user_image = URL::to('/') . Storage::disk('local')->url('images/users/' . $this->user_image);
        }else{
                    $user_image = URL::to('/') . Storage::disk('local')->url('images/users/'. $this->user_image);
        }
        $user_image = $user_image;

        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'status' => $this->status,
            'phone' => $this->phone,
            'avatar_url'  => $user_image 
        ];
    }
}
