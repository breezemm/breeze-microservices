<?php

namespace App\Http\Resources;

use App\Enums\StorageMediaCollectionName;
use App\Enums\UserSettings;
use App\Models\Interest;
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
            'profile_image' => $this->getFirstMediaUrl(StorageMediaCollectionName::PROFILE_IMAGES->value),
            'email' => $this->email,
            'date_of_birth' => $this->date_of_birth,
            'city' => $this->city->name,
            UserSettings::MOST_FAVORITES->value => collect($this->settings()->get(UserSettings::MOST_FAVORITES))->map(function ($interest) {
                return Interest::find($interest)->name;
            }),
            UserSettings::LEAST_FAVORITE->value => Interest::find($this->settings()->get(UserSettings::LEAST_FAVORITE))->name,
        ];
    }
}
