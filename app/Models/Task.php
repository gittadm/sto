<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;

/**
 * App\Models\Task
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $status
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\TaskFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Task newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Task newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Task query()
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereUserId($value)
 * @mixin \Eloquent
 * @property int|null $author_id
 * @property int|null $department_id
 * @property string|null $start_at
 * @property string|null $end_at
 * @property string|null $deadline_at
 * @property int|null $order_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Checkbox[] $checkboxes
 * @property-read int|null $checkboxes_count
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereAuthorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereDeadlineAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereEndAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Task whereStartAt($value)
 * @property-read \App\Models\User|null $author
 * @property-read \App\Models\Department|null $department
 * @property-read \App\Models\Order|null $order
 * @property-read \App\Models\User|null $user
 */
class Task extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    public const FILES_DISK = 'tasks';

    public const STATUS_WAIT = 'wait';
    public const STATUS_PROCESS = 'process';
    public const STATUS_PAUSE = 'pause';
    public const STATUS_DONE = 'done';

    protected $guarded = ['id'];

    protected $casts = [
        'department_id' => 'integer',
        'author_id' => 'integer',
        'user_id' => 'integer',
        'order_id' => 'integer',
        'start_at' => 'datetime:Y-m-d',
        'end_at' => 'datetime:Y-m-d',
        'deadline_at' => 'datetime:Y-m-d',
        'position' => 'integer'
    ];

    /**
     * @return string[]
     */
    public static function getStatuses(): array
    {
        return [
            self::STATUS_WAIT,
            self::STATUS_PROCESS,
            self::STATUS_PAUSE,
            self::STATUS_DONE
        ];
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('files');
    }

    /* relations */

    public function checkboxes()
    {
        return $this->hasMany(Checkbox::class)->orderBy('id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function files()
    {
        return $this->morphMany(Media::class, 'model');
    }

    public function pipelines()
    {
        return $this->belongsToMany(Pipeline::class)
            ->withPivot('stage_id', 'created_at', 'updated_at');
    }

    public function pipelineTasks()
    {
        return $this->hasMany(PipelineTask::class);
    }
}
