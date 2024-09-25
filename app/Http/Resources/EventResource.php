<?php

namespace App\Http\Resources;

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
            "id" => $this->id,
            "thumbnail" => $this->thumbnail,
            "name" => $this->name,
            "slug" => $this->slug,
            "organizer" => $this->organizer,
            "country" => $this->country,
            "city" => $this->city,
            "dates" => $this->dates(),
            "location" => $this->location,
            "description" => $this->description,
            "start_at" => $this->start_at,
            "end_at" => $this->end_at,
            "status" => $this->status,
            "featured" => $this->featured,
            "terms" => $this->terms,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}
