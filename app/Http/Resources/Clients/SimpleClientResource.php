<?php

namespace App\Http\Resources\Clients;

use Illuminate\Http\Resources\Json\JsonResource;

class SimpleClientResource extends JsonResource
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
            'surname' => $this->surname,
            'middle_name' => $this->middle_name,
            'born_at' => db_to_date($this->born_at),
            'notes' => $this->notes,
            'address' => $this->address,
            'passport' => $this->passport,
            'phones' => $this->phones,
            'gender' => $this->gender,
            'emails' => $this->emails,
            'created_at' => db_to_date($this->created_at, 'd.m.Y H:i'),
            'updated_at' => db_to_date($this->updated_at, 'd.m.Y H:i'),
            'department_id' => $this->department_id,
            'city_id' => $this->city_id
        ];
    }
}
