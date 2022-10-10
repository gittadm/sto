<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * App\Models\Product
 *
 * @property int $id
 * @property string $name
 * @property string|null $place
 * @property int $count
 * @property int|null $input_sum
 * @property int|null $output_sum
 * @property string|null $description
 * @property string|null $photo
 * @property string|null $sku артикул
 * @property int|null $producer_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Producer|null $producer
 * @method static \Database\Factories\ProductFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereInputSum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereOutputSum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePlace($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereProducerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read mixed $photo_url
 * @property-read \Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection|\Spatie\MediaLibrary\MediaCollections\Models\Media[] $media
 * @property-read int|null $media_count
 */
class Product extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    public const PHOTO_DISK = 'products';

    protected $guarded = ['id'];

    protected $casts = [
        'count' => 'integer',
        'input_sum' => 'integer',
        'output_sum' => 'integer',
        'producer_id' => 'integer'
    ];

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('photo')
            ->singleFile();
    }

    public function getPhotoUrlAttribute()
    {
        return optional($this->getFirstMedia('photo'))->getFullUrl();
    }

    /* relations */

    public function producer()
    {
        return $this->belongsTo(Producer::class);
    }
}
