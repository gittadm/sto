<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\EngineVolume
 *
 * @property int $id
 * @property float $value
 * @method static \Illuminate\Database\Eloquent\Builder|EngineVolume newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EngineVolume newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EngineVolume query()
 * @method static \Illuminate\Database\Eloquent\Builder|EngineVolume whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EngineVolume whereValue($value)
 * @mixin \Eloquent
 */
class EngineVolume extends Model
{
    public $timestamps = false;

    protected $fillable = ['value'];
}
