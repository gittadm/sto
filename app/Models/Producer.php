<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Producer
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\ProducerFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Producer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Producer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Producer query()
 * @method static \Illuminate\Database\Eloquent\Builder|Producer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Producer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Producer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Producer whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Producer extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
}
