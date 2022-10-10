<?php

namespace App\Http\Resources\Cars;

use Illuminate\Http\Resources\Json\JsonResource;

class SimpleCarResource extends JsonResource
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
            'number' => $this->number,
            'vin' => $this->vin,
            'year' => $this->year,
            'body' => $this->body,
            'color' => $this->color,
            'notes' => $this->notes,
            'created_at' => db_to_date($this->created_at, 'd.m.Y H:i'),
            'updated_at' => db_to_date($this->updated_at, 'd.m.Y H:i'),
            'fuel' => FuelResource::make($this->fuel),
            'engine_volume' => EngineVolumeResource::make($this->engineVolume),
            'car_model' => CarModelResource::make($this->carModel),
        ];
    }
}
