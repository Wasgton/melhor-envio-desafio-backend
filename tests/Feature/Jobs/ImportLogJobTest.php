<?php

namespace Tests\Feature\Jobs;

use App\Jobs\ImportLogJob;
use App\Repositories\LogRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImportLogJobTest extends TestCase
{
    use RefreshDatabase;

    public function test_handle_should_process_queue()
    {
        $filePath = 'temp/chunk_0.txt';
        Storage::disk('public')->copy('json_file.txt', $filePath);
        Storage::disk('public')->assertExists($filePath);
        $repository = app(LogRepository::class);
        $job = new ImportLogJob($filePath, $repository);
        $job->handle();
        Storage::disk('public')->assertMissing($filePath);
        $this->assertDatabaseCount('logs', 7);
        $this->assertDatabaseCount('requests', 7);
        $this->assertDatabaseCount('responses', 7);
        $this->assertDatabaseCount('routes', 7);
        $this->assertDatabaseCount('services', 7);
        $this->assertDatabaseCount('latencies', 7);
    }
    
}
