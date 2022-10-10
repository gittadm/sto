<?php

namespace App\Http\Resources\Processes;

use Illuminate\Http\Resources\Json\JsonResource;

class ProcessCheckboxResource extends JsonResource
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
            'description' => $this->description,
            'is_checked' => $this->is_checked,
            'proccess_task_id' => $this->process_task_id,
        ];
    }
}
