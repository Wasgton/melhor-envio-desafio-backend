<?php

namespace Tests\Feature\Services;

use App\Jobs\ImportLogJob;
use App\Models\Log;
use App\Models\Request;
use App\Repositories\LogRepository;
use App\Services\FileStorageService;
use App\Services\ImportLogService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImportLogServiceTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_send_to_queue_chunked()
    {
        Queue::fake();
        $filePath = 'temp/test_file.txt';
        Storage::disk('public')->copy('json_file.txt', $filePath);
        $service = new ImportLogService();
        $service->sendToQueueChunked($filePath);
        Queue::assertPushed(ImportLogJob::class);
    }

    public function test_send_to_queue_chunked_with_large_file()
    {
        Queue::fake();
        $filePath = 'public/temp/test_large_file.txt';
        $fileContent = Storage::disk('public')->get('json_file.txt');
        $fileContent = str_repeat($fileContent, 2000);
        Storage::disk('public')->put($filePath, $fileContent);
        $service = new ImportLogService();
        $service->sendToQueueChunked($filePath);
        Queue::assertPushed(ImportLogJob::class, function ($job) {
            return Storage::disk('public')->exists($job->file);
        });
    }
}
