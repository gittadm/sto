<?php

namespace App\Http\Controllers\Api\TempFiles;

use App\Http\Requests\TempFiles\DeleteRequest;
use App\Http\Requests\TempFiles\StoreRequest;
use App\Http\Resources\TempFiles\TempFileResource;
use App\Services\TempFiles\TempFileService;
use Illuminate\Auth\Access\AuthorizationException;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Throwable;

class TempFileController extends Controller
{
    /**
     * TempFileController constructor.
     * @param  TempFileService  $tempFileService
     */
    public function __construct(private TempFileService $tempFileService) {}

    /**
     * Добавление временных файлов
     *
     * @group Файлы
     *
     * @param  StoreRequest  $request
     * @return JsonResponse
     * @throws AuthorizationException
     * @throws Throwable
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $tempFiles = $this->tempFileService->store(id());

        return response_json(['files' => TempFileResource::collection($tempFiles)]);
    }

    /**
     * Удаление временных файлов
     *
     * @group Файлы
     *
     * @urlParam ids array required
     *
     * @param  DeleteRequest  $request
     * @return JsonResponse
     */
    public function destroy(DeleteRequest $request): JsonResponse
    {
        $this->tempFileService->delete(id(), $request->validated());

        return response_success();
    }
}
