<?php

namespace App\Http\Resources\Comments;

use App\Http\Resources\Users\SimpleUserResource;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Comment;

class CommentResource extends JsonResource
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
            'user' => SimpleUserResource::make($this->user),
            'model_id' => $this->commentable_id,
            'model' => Comment::getModelAlias($this->commentable_type),
            'created_at' => db_to_date($this->created_at, 'd.m.Y H:i'),
            'updated_at' => db_to_date($this->updated_at, 'd.m.Y H:i'),
        ];
    }
}
