<?php

namespace App\Http\Controllers\Api\Comments;

use App\Exceptions\CustomValidationException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Comments\StoreRequest;
use App\Http\Resources\Comments\CommentResource;
use App\Services\Comments\CommentService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use App\Models\Comment;

class CommentController extends Controller
{
    public function __construct(private CommentService $commentService) {}

    /**
     * Список комментариев
     *
     * Права: доступ к чтению сущности комментариев
     *
     * @group Комментарии
     *
     * @urlParam model string required Название сущности, к которой комментарии. Например, task
     * @urlParam id integer required ID сущности, к которой комментарии
     *
     * @param  string  $model
     * @param  int  $id
     * @return JsonResponse
     * @throws CustomValidationException
     * @throws AuthorizationException
     */
    public function index(string $model, int $id): JsonResponse
    {
        $this->authorize('read-comments', [$model, Comment::getModel($model, $id)]);

        $comments = $this->commentService->getAll($model, $id);

        return response_json(['comments' => CommentResource::collection($comments)]);
    }

    /**
     * Добавление комментария
     *
     * Права: доступ к чтению сущности комментария
     *
     * @group Комментарии
     *
     * @urlParam model string required Название сущности, к которой комментарии. Например, task
     * @urlParam id integer required ID сущности, к которой комментарии
     *
     * @param  string  $model
     * @param  int  $id
     * @param  StoreRequest  $request
     * @return JsonResponse
     * @throws CustomValidationException
     * @throws AuthorizationException
     */
    public function store(string $model, int $id, StoreRequest $request): JsonResponse
    {
        $this->authorize('store-comments', [$model, Comment::getModel($model, $id)]);

        $comment = $this->commentService->store(id(), $model, $id, $request->validated());

        return response_json(['comment' => CommentResource::make($comment)]);
    }
}
