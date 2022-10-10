<?php

namespace App\Http\Resources\Processes;

use App\Http\Resources\Media\SimpleMediaResource;
use App\Http\Resources\Users\SimpleUserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ProcessTaskWithFilesResource extends JsonResource
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
            'description' => $this->description,
            'time' => $this->time,
            'position' => $this->position,
            'created_at' => db_to_date($this->created_at, 'd.m.Y H:i'),
            'updated_at' => db_to_date($this->updated_at, 'd.m.Y H:i'),
            'process_checkboxes' => ProcessCheckboxResource::collection($this->processCheckboxes),
            'process_category' => ProcessCategoryResource::make($this->processCategory),
            'user' => SimpleUserResource::make($this->user),
            'files' => SimpleMediaResource::collection($this->files)
        ];
    }
}
