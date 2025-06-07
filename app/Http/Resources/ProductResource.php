<?php

namespace App\Http\Resources;

use App\Models\Extra;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use TCG\Voyager\Facades\Voyager;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'event_thumbnail' => Voyager::image($this->event->thumbnail),
            'thumbnail' => 'https://events.essenciacompany.com/storage/',
            Voyager::image($this->thumbnail),
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'sale_price' => $this->sale_price,
            'status' => $this->status,
            'quantity' => $this->quantity,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'limit_per_order' => $this->limit_per_order,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'tax' => $this->tax,
            'secondary_tax' => $this->secondary_tax,
            'secondary_tax_percentage' => $this->secondary_tax_percentage,
            'website' => $this->website,
            'sequence' => $this->sequence,
            'check_in' => $this->check_in,
            'check_out' => $this->check_out,
            'zones' => $this->zones,
            'extras' => $this->transformExtras(),
            'invite_only' => $this->invite_only,
            'event' => $this->event,
            'thumbnail' => Voyager::image($this->thumbnail)
        ];
    }

    private function transformExtras(): array
    {
        return collect($this->extras)->mapWithKeys(function ($quantity, $id) {
            $extra = Extra::find($id);
            $extra['quantity'] = (int)$quantity;
            return [$id => $extra];
        })->filter()->values()->toArray();
    }
}
