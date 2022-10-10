<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CarMark
 *
 * @property int $id
 * @property string $name
 * @method static \Database\Factories\CarMarkFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|CarMark newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CarMark newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CarMark query()
 * @method static \Illuminate\Database\Eloquent\Builder|CarMark whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CarMark whereName($value)
 * @mixin \Eloquent
 */
class CarMark extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name'];
}
