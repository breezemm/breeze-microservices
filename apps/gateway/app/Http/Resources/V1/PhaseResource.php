<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PhaseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'tickets' => TicketResource::collection($this->whenLoaded('tickets'))
        ];
    }
}
