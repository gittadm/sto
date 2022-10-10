<?php

namespace App\Services\Products;

use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Exceptions\UsedInOtherTableException;
use App\Models\Product;
use Throwable;
use DB;

class ProductService
{
    /**
     * @param  array  $filter
     * @return LengthAwarePaginator
     */
    public function getPaginatedProducts(array $filter): LengthAwarePaginator
    {
        $products = Product::with('producer');

        if (!empty($filter['name'])) {
            $products->where('name', 'like', '%'.$filter['name'].'%');
        }

        if (!empty($filter['sku'])) {
            $products->where('sku', 'like', '%'.$filter['sku'].'%');
        }

        if (!empty($filter['producer_id'])) {
            $products->where('producer_id', $filter['producer_id']);
        }

        if (!empty($filter['order'])) {
            if ($filter['order'] === 'name') {
                $products->orderBy('name');
            } else { // id or other
                $products->orderBy('id', 'desc');
            }
        } else {
            $products->orderBy('name');
        }

        return $products->paginate(30);
    }

    /**
     * @param  array  $data
     * @return Product
     * @throws Throwable
     */
    public function store(array $data): Product
    {
        return DB::transaction(
            function () use ($data) {
                $product = Product::create($data);
                if (request()->hasFile('photo')) {
                    $product->addMediaFromRequest('photo')
                        ->usingFileName(gen_file_name('photo'))
                        ->toMediaCollection('photo', Product::PHOTO_DISK);
                }
                return $product;
            }
        );
    }

    /**
     * @param  int  $productId
     * @return Product
     */
    public function getProductById(int $productId): Product
    {
        return Product::findOrFail($productId);
    }

    /**
     * @param  int  $productId
     * @param  array  $data
     * @return Product
     */
    public function update(int $productId, array $data): Product
    {
        $product = $this->getProductById($productId);
        $product->update($data);

        return $product;
    }

    /**
     * @param  int  $productId
     * @throws UsedInOtherTableException
     */
    public function delete(int $productId): void
    {
        try {
            Product::where('id', $productId)->delete();
        } catch (Throwable) {
            throw new UsedInOtherTableException(
                'Товар нельзя удалить, так как он уже используется в других таблицах'
            );
        }
    }

    /**
     * @param  Product  $product
     * @return string
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function updatePhoto(Product $product): string
    {
        $product->addMediaFromRequest('photo')
            ->sanitizingFileName(function ($fileName) {
                return sanitize_file_name($fileName);
            })->usingFileName(gen_file_name('photo'))
            ->toMediaCollection('photo', Product::PHOTO_DISK);

        return $product->photo_url;
    }
}
