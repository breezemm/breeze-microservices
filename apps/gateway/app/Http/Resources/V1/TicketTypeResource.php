<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketTypeResource extends JsonResource
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
            'benefits' => $this->benefits,
            'price' => $this->price,
            'is_has_seating_plan' => $this->is_has_seating_plan,
            'total_seats' => $this->total_seats,
            'tickets' => TicketResource::collection($this->whenLoaded('tickets')),
        ];
    }
}
