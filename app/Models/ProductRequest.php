<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ProductRequest
 *
 * @property int $id
 * @property int $sum
 * @property int $user_id
 * @property int $product_id
 * @property int|null $order_id
 * @property string $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Checkbox[] $checkboxes
 * @property-read int|null $checkboxes_count
 * @method static \Illuminate\Database\Eloquent\Builder|ProductRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductRequest whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductRequest whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductRequest whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductRequest whereSum($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductRequest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductRequest whereUserId($value)
 * @mixin \Eloquent
 */
class ProductRequest extends Model
{
    use HasFactory;

    public const STATUS_WAIT = 'wait';
    public const STATUS_PROCESS = 'process';
    public const STATUS_PAUSE = 'pause';

    protected $guarded = ['id'];

    protected $casts = [
        'user_id' => 'integer',
        'product_id' => 'integer',
        'order_id' => 'integer',
    ];

    /**
     * @return string[]
     */
    public static function getStatuses(): array
    {
        return [
            self::STATUS_WAIT,
            self::STATUS_PROCESS,
            self::STATUS_PAUSE,
            self::STATUS_DONE
        ];
    }

    /* relations */

    public function checkboxes()
    {
        return $this->hasMany(Checkbox::class);
    }
}
