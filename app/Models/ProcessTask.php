<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProcessTask extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    public const FILES_DISK = 'process_tasks';

    public const PIPELINE_STATUS_MOVED = 'moved';
    public const PIPELINE_STATUS_CLOSED = 'closed';

    protected $guarded = ['id'];

    protected $casts = [
        'process_category_id' => 'integer',
        'user_id' => 'integer',
        'time' => 'integer',
        'position' => 'integer'
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('files');
    }

    /* relations */

    public function processCheckboxes()
    {
        return $this->hasMany(ProcessCheckbox::class)->orderBy('id');
    }

    public function processCategory()
    {
        return $this->belongsTo(ProcessCategory::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function files()
    {
        return $this->morphMany(Media::class, 'model');
    }

    public function pipelines()
    {
        return $this->belongsToMany(Pipeline::class, 'pipeline_process_task')
            ->withPivot('stage_id', 'status', 'created_at', 'updated_at');
    }

    public function pipelineProcessTasks()
    {
        return $this->hasMany(PipelineProcessTask::class);
    }
}
