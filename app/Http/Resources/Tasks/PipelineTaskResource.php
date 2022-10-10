<?php

namespace App\Http\Resources\Tasks;

use App\Http\Resources\Pipelines\SimplePipelineResource;
use App\Http\Resources\Pipelines\StageResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PipelineTaskResource extends JsonResource
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
            'pipeline' => SimplePipelineResource::make($this->pipeline),
            'stage' => StageResource::make($this->stage),
            'task_id' => $this->task_id,
            'created_at' => db_to_date($this->created_at, 'd.m.Y H:i'),
            'updated_at' => db_to_date($this->updated_at, 'd.m.Y H:i'),
        ];
    }
}
