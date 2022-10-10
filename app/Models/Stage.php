<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Stage
 *
 * @property int $id
 * @property string $name
 * @property string $color
 * @property int $pipeline_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Pipeline $pipeline
 * @method static \Illuminate\Database\Eloquent\Builder|Stage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Stage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Stage query()
 * @method static \Illuminate\Database\Eloquent\Builder|Stage whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stage whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stage wherePipelineId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stage whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Database\Factories\StageFactory factory(...$parameters)
 */
class Stage extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = ['pipeline_id' => 'integer'];

    /* relations */

    public function pipeline()
    {
        return $this->belongsTo(Pipeline::class);
    }
}
