<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;

/**
 * App\Models\Client
 *
 * @property int $id
 * @property string $surname
 * @property string $name
 * @property string|null $middle_name
 * @property string|null $gender
 * @property string|null $address
 * @property string|null $passport
 * @property string|null $born_at
 * @property array|null $phones
 * @property array|null $emails
 * @property string|null $notes
 * @property int|null $city_id
 * @property int|null $department_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Car[] $cars
 * @property-read int|null $cars_count
 * @property-read \App\Models\City|null $city
 * @property-read \App\Models\Department|null $department
 * @method static \Illuminate\Database\Eloquent\Builder|Client newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Client newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Client query()
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereBornAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereEmails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereMiddleName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client wherePassport($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client wherePhones($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereSurname($value)
 * @mixin \Eloquent
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\ClientFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Client whereUpdatedAt($value)
 */
class Client extends Model
{
    use HasFactory;

    public const GENDER_MALE = 'male';
    public const GENDER_FEMALE = 'female';

    protected $guarded = ['id'];

    protected $casts = [
        'born_at' => 'date',
        'phones' => 'array',
        'emails' => 'array',
        'city_id' => 'integer',
        'department_id' => 'integer'
    ];

    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d');
    }

    /* relations */

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function cars()
    {
        return $this->hasMany(Car::class);
    }
}
