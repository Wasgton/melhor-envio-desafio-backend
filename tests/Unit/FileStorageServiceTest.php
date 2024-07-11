<?php

namespace Tests\Unit;

use App\Services\FileStorageService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FileStorageServiceTest extends TestCase
{
    public function test_should_store_the_uploaded_file_to_the_temp_directory()
    {
        $file = UploadedFile::fake()->create('testfile.txt', 1024);
        $service = new FileStorageService();
        $filePath = $service->storeTempFile($file);
        Storage::disk('public')->assertExists('temp/json_file.txt');
        $this->assertEquals('temp/json_file.txt', $filePath);
    }

    public function test_should_handle_large_file_uploads()
    {
        $file = UploadedFile::fake()->create('largefile.txt', 10240);
        $service = new FileStorageService();
        $filePath = $service->storeTempFile($file);
        Storage::disk('public')->assertExists('temp/json_file.txt');
        $this->assertEquals('temp/json_file.txt', $filePath);
    }
}