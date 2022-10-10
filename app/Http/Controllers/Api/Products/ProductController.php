<?php

namespace App\Http\Controllers\Api\Products;

use App\Exceptions\UsedInOtherTableException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Products\StoreRequest;
use App\Http\Requests\Products\UpdatePhotoRequest;
use App\Http\Requests\Products\UpdateRequest;
use App\Http\Resources\Products\ProductCollection;
use App\Http\Resources\Products\ProductResource;
use App\Models\Product;
use App\Services\Products\ProductService;
use Illuminate\Http\JsonResponse;
use App\Models\RoleConst;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class ProductController extends Controller
{
    /**
     * ProductController constructor.
     * @param  ProductService  $productService
     */
    public function __construct(private ProductService $productService)
    {
        $this->middleware(['permission:' . RoleConst::PERMISSION_STORAGES_CRUD]);
    }

    /**
     * Список товаров
     *
     * Получение списка товаров с производителями с пагинацией.
     * С помощью дополнительных параметров в url можно указать фрагмент для поиска по названию, по артикулу,
     * по производителю. Сортировка возможна по дате создания или названию
     *
     * Права: `crud storages`
     *
     * @urlParam order string Значения: id, name. Если параметр не указан, то по id desc.
     * @urlParam name string Поиск по фрагменту названия
     * @urlParam sku string Поиск по фрагменту артикула
     * @urlParam producer_id integer Поиск по id производителя
     *
     * @group Склады
     *
     * @param  Request  $request
     * @return ProductCollection
     */
    public function index(Request $request): ProductCollection
    {
        $products = $this->productService->getPaginatedProducts($request->all());

        return new ProductCollection($products);
    }

    /**
     * Получение товара
     *
     * Права: `crud storages`
     *
     * @group Склады
     *
     * @urlParam product integer required
     *
     * @param  Product  $product
     * @return JsonResponse
     */
    public function show(Product $product): JsonResponse
    {
        return response_json(['product' => ProductResource::make($product)]);
    }

    /**
     * Добавление товара
     *
     * Название должно быть уникально
     *
     * Права: `crud storages`
     *
     * @bodyParam name string required
     *
     * @group Склады
     *
     * @param  StoreRequest  $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $product = $this->productService->store($request->validated());

        return response_json(['product' => ProductResource::make($product)]);
    }

    /**
     * Обновление товара
     *
     * Права: `crud storages`
     *
     * @group Склады
     *
     * @urlParam product integer required
     * @bodyParam name string required
     *
     * @param  UpdateRequest  $request
     * @param  int  $productId
     * @return JsonResponse
     */
    public function update(UpdateRequest $request, int $productId): JsonResponse
    {
        $product = $this->productService->update($productId, $request->validated());

        return response_json(['product' => ProductResource::make($product)]);
    }

    /**
     * Удаление товара
     *
     * Права: `crud storages`
     *
     * @group Склады
     *
     * @urlParam product integer required
     *
     * @param  int  $productId
     * @return JsonResponse
     * @throws UsedInOtherTableException
     */
    public function destroy(int $productId): JsonResponse
    {
        $this->productService->delete($productId);

        return response_success();
    }

    /**
     * Обновление фото товара
     *
     * Права: `crud storages`
     *
     * @group Склады
     *
     * @bodyParam photo file required Изображение, размер не более 10000 Кб
     *
     * @param  UpdatePhotoRequest  $request
     * @param  Product  $product
     * @return JsonResponse
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function updatePhoto(UpdatePhotoRequest $request, Product $product): JsonResponse
    {
        $photo = $this->productService->updatePhoto($product);

        return response_json(['photo' => $photo]);
    }
}
