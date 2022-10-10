<?php

namespace App\Http\Resources\Processes;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProcessTaskCollection extends ResourceCollection
{
    public $collects = ProcessTaskResource::class;

    public static $wrap = 'process_tasks';

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
