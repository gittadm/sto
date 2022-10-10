<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CarModel
 *
 * @property int $id
 * @property string $name
 * @property int|null $car_mark_id
 * @property-read \App\Models\CarMark|null $carMark
 * @method static \Illuminate\Database\Eloquent\Builder|CarModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CarModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CarModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|CarModel whereCarMarkId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarModel whereName($value)
 * @mixin \Eloquent
 * @method static \Database\Factories\CarModelFactory factory(...$parameters)
 */
class CarModel extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name', 'car_mark_id'];

    /* relations */

    public function carMark()
    {
        return $this->belongsTo(CarMark::class);
    }
}
