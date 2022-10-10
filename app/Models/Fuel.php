<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Fuel
 *
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder|Fuel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Fuel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Fuel query()
 * @method static \Illuminate\Database\Eloquent\Builder|Fuel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Fuel whereName($value)
 * @mixin \Eloquent
 */
class Fuel extends Model
{
    public $timestamps = false;

    protected $fillable = ['name'];
}
