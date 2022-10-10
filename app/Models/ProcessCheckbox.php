<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessCheckbox extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = ['id'];

    protected $casts = [
        'is_checked' => 'boolean',
        'process_task_id' => 'integer'
    ];

    /* relations */

    public function processTask()
    {
        return $this->belongsTo(ProcessTask::class);
    }
}
