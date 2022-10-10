<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;

class TempFile extends Model implements HasMedia
{
    use InteractsWithMedia;

    public const DEPRECATED_PERIOD_IN_HOURS = 48;
    public const DISK = 'temp';

    protected $guarded = ['id'];

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('temp')
            ->singleFile();
    }

    public function getUrlAttribute(): ?string
    {
        return optional($this->getFirstMedia('temp'))->getFullUrl();
    }

    public function getOriginalNameAttribute(): ?string
    {
        return $this->getFirstMedia('temp')->name;
    }
}
