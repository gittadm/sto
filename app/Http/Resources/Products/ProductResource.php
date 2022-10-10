<?php

namespace App\Http\Resources\Products;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'place' => $this->place,
            'count' => $this->count,
            'input_sum' => $this->input_sum,
            'output_sum' => $this->output_sum,
            'description' => $this->description,
            'photo' => $this->photo_url,
            'sku' => $this->sku,
            'created_at' => db_to_date($this->created_at, 'd.m.Y H:i'),
            'updated_at' => db_to_date($this->updated_at, 'd.m.Y H:i'),
            'producer' => ProducerResource::make($this->producer)
        ];
    }
}
