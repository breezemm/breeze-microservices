<?php

namespace App\Http\Resources\V1;

use App\Http\Resources\CommentResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
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
            'is_my_event' => $this->whenLoaded('user', fn() => $this->user->id === auth()->id()),
            'name' => $this->name,
            'start_date' => $this->start_date,
            'start_time' => $this->start_time,
            'place' => $this->place,
            'description' => $this->description,
            'is_has_phases' => $this->is_has_phases,
            'image' => $this->getFirstMediaUrl('event-images'),
            'user' => new UserResource($this->whenLoaded('user')),
            //            'repost' => new RepostEventResource($this->whenLoaded('repost')),
            'phases' => PhaseResource::collection($this->whenLoaded('phases')),
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
            'likers_count' => $this->whenCounted('likers'),
            'comments_count' => $this->whenCounted('comments'),
        ];
    }
}
