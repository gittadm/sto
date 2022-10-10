<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Checkbox
 *
 * @property int $id
 * @property string $description
 * @property bool $is_checked
 * @property int $task_id
 * @method static \Database\Factories\CheckboxFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Checkbox newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Checkbox newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Checkbox query()
 * @method static \Illuminate\Database\Eloquent\Builder|Checkbox whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Checkbox whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Checkbox whereIsChecked($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Checkbox whereTaskId($value)
 * @mixin \Eloquent
 * @property-read \App\Models\Task $task
 */
class Checkbox extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = ['id'];

    protected $casts = [
        'is_checked' => 'boolean',
        'task_id' => 'integer'
    ];

    /* relations */

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
