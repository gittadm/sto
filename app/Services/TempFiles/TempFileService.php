<?php

namespace App\Services\TempFiles;

use App\Models\TempFile;

class TempFileService
{
    public function store(int $userId)
    {
        $tempFiles = [];
        foreach (request()->file('files') as $file) {
            $tempFile = TempFile::create(['user_id' => $userId]);
            $tempFile->addMedia($file->getPathName())
                ->sanitizingFileName(function ($fileName) {
                    return sanitize_file_name($fileName);
                })
                ->usingName($file->getClientOriginalName())
                ->usingFileName(gen_file_name($file))
                ->toMediaCollection('temp', TempFile::DISK);
            $tempFiles[] = $tempFile;
        }

        return collect($tempFiles);
    }

    public function delete(int $userId, array $data): void
    {
        $tempFiles = TempFile::where('user_id', $userId)
            ->whereIn('id', $data['ids'])->get();

        foreach ($tempFiles as $tempFile) {
            $tempFile->delete();
        }
    }
}
