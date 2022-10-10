<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Car
 *
 * @property int $id
 * @property string|null $vin
 * @property string $number
 * @property int|null $year
 * @property string|null $body кузов
 * @property string|null $engine
 * @property string|null $color
 * @property string|null $fuel
 * @property string|null $notes
 * @property int|null $client_id
 * @property int|null $car_model_id
 * @property-read \App\Models\Client|null $client
 * @method static \Illuminate\Database\Eloquent\Builder|Car newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Car newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Car query()
 * @method static \Illuminate\Database\Eloquent\Builder|Car whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Car whereCarModelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Car whereClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Car whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Car whereEngine($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Car whereFuel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Car whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Car whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Car whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Car whereVin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Car whereYear($value)
 * @mixin \Eloquent
 * @property int|null $fuel_id
 * @property int|null $engine_volume_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\CarModel|null $carModel
 * @property-read \App\Models\EngineVolume|null $engineVolume
 * @method static \Database\Factories\CarFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Car whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Car whereEngineVolumeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Car whereFuelId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Car whereUpdatedAt($value)
 */
class Car extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'year' => 'integer',
        'fuel_id' => 'integer',
        'engine_volume_id' => 'integer',
        'client_id' => 'integer',
        'car_model_id' => 'integer'
    ];

    /* relations */

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function fuel()
    {
        return $this->belongsTo(Fuel::class);
    }

    public function engineVolume()
    {
        return $this->belongsTo(EngineVolume::class);
    }

    public function carModel()
    {
        return $this->belongsTo(CarModel::class);
    }
}
