<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class FileStorageService 
{
    private string $tempFilePath = 'temp/json_file.txt';

    public function storeTempFile(UploadedFile $file): string
    {
        return $file->storeAs('temp', 'json_file.txt', 'public');
    }
    
}