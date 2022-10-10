<?php

namespace App\Services\TempFiles;

use App\Models\TempFile;
use Throwable;

class TempFileClearService
{
    public function deleteDeprecatedFiles(): void
    {
        $date = now()->subHours(TempFile::DEPRECATED_PERIOD_IN_HOURS)->toDateTimeString();
        $tempFiles = TempFile::where('created_at', '<=', $date)->get();

        foreach ($tempFiles as $tempFile) {
            try {
                $tempFile->delete();
            } catch (Throwable $e) {
                info('Не удалось удалить устаревший временный файл', [$e->getTraceAsString()]);
            }
        }
    }
}
