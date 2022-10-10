<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MapQuestion extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /* relations */

    public function mapAnswers()
    {
        return $this->hasMany(MapAnswer::class);
    }
}
