<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PipelineTask extends Model
{
    use HasFactory;

    protected $table = 'pipeline_task';

    protected $guarded = ['id'];

    protected $casts = [
        'pipeline_id' => 'integer',
        'stage_id' => 'integer',
        'task_id' => 'integer'
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

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}
