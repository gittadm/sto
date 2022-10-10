<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PipelineProcessTask extends Model
{
    use HasFactory;

    protected $table = 'pipeline_process_task';

    protected $guarded = ['id'];

    protected $casts = [
        'pipeline_id' => 'integer',
        'stage_id' => 'integer',
        'process_task_id' => 'integer'
    ];

    /* relations */

    public function stage()
    {
        return $this->belongsTo(Stage::class);
    }

    public function pipeline()
    {
        return $this->belongsTo(Pipeline::class);
    }

    public function processTask()
    {
        return $this->belongsTo(ProcessTask::class);
    }
}
