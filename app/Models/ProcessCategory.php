<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessCategory extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = ['appeal_reason_id' => 'integer'];

    /* relations */

    public function appealReason()
    {
        return $this->belongsTo(AppealReason::class);
    }
}
