<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use TCG\Voyager\Facades\Voyager;

class ExtraResoure extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // dd(Voyager::image($this->thumbnail));
        return  [
            "id" => $this->id,
            "name" => $this->name,
            "display_name" => $this->display_name,
            "event_id" => $this->event_id,
            "zone_id" => $this->zone_id,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
            "price" => $this->price,
            "tax" => $this->tax,
            "tax_type" => $this->tax_type,
            "thumbnail" => Voyager::image($this->thumbnail),
            "event" => new EventResource($this->event)
        ];
        
     
    }
}
