<?php

namespace App\Http\Resources\MapQuestions;

use Illuminate\Http\Resources\Json\JsonResource;

class MapAnswerResource extends JsonResource
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
            'answer' => $this->answer,
            'recommendations' => $this->recommendations,
            'map_question_id' => $this->map_question_id,
            'created_at' => db_to_date($this->created_at, 'd.m.Y H:i'),
            'updated_at' => db_to_date($this->updated_at, 'd.m.Y H:i'),
        ];
    }
}
