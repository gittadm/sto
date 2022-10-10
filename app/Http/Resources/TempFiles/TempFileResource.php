<?php

namespace App\Http\Resources\TempFiles;

use Illuminate\Http\Resources\Json\JsonResource;

class TempFileResource extends JsonResource
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
            'original_name' => $this->original_name,
            'url' => $this->url,
            'user_id' => $this->user_id
        ];
    }
}
