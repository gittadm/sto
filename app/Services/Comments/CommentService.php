<?php

namespace App\Services\Comments;

use App\Exceptions\CustomValidationException;
use Illuminate\Support\Collection;
use App\Models\Comment;

class CommentService
{
    /**
     * @param  string  $modelAlias
     * @param  int  $modelId
     * @return Collection
     * @throws CustomValidationException
     */
    public function getAll(string $modelAlias, int $modelId): Collection
    {
        $modelClass = Comment::getModelClass($modelAlias);

        return Comment::with('user')->where('commentable_type', $modelClass)
            ->where('commentable_id', $modelId)->orderBy('id')->get();
    }

    /**
     * @param  int  $userId
     * @param  string  $modelAlias
     * @param  int  $modelId
     * @param  array  $data
     * @return Comment
     * @throws CustomValidationException
     */
    public function store(int $userId, string $modelAlias, int $modelId, array $data): Comment
    {
        Comment::getModel($modelAlias, $modelId);
        $modelClass = Comment::getModelClass($modelAlias);

        $data['commentable_type'] = $modelClass;
        $data['commentable_id'] = $modelId;
        $data['user_id'] = $userId;

        return Comment::create($data);
    }
}
