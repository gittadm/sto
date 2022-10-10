<?php

namespace App\Models;

use App\Traits\ModelTypeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Pipeline
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Stage[] $stages
 * @property-read int|null $stages_count
 * @method static \Illuminate\Database\Eloquent\Builder|Pipeline newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pipeline newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Pipeline query()
 * @method static \Illuminate\Database\Eloquent\Builder|Pipeline whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pipeline whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pipeline whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pipeline whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Pipeline whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Database\Factories\PipelineFactory factory(...$parameters)
 */
class Pipeline extends Model
{
    use HasFactory, ModelTypeTrait;

    protected $guarded = ['id'];

    public static function getModelMap(): array
    {
        return [
            'task' => 'App\Models\Task',
        ];
    }

    /* relations */

    public function stages()
    {
        return $this->hasMany(Stage::class)->orderBy('id');
    }
}
