<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\FinanceGroup
 *
 * @property int $id
 * @property string $name
 * @method static \Database\Factories\FinanceGroupFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|FinanceGroup newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FinanceGroup newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|FinanceGroup query()
 * @method static \Illuminate\Database\Eloquent\Builder|FinanceGroup whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|FinanceGroup whereName($value)
 * @mixin \Eloquent
 */
class FinanceGroup extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = ['id'];
}
