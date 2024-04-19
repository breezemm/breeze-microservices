<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'profile_image' => $this->getFirstMediaUrl('profile_images'),
            'email' => $this->email,
            'date_of_birth' => $this->date_of_birth,
            'interests' => InterestResource::collection($this->interests),
            'city' => $this->city->name,
//            'settings' => $this->settings()->all(),
        ];
    }
}
