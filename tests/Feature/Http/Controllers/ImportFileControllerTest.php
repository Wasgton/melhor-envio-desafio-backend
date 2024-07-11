<?php

namespace Tests\Feature\Http\Controllers;

use App\Jobs\ImportLogJob;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImportFileControllerTest extends TestCase
{
    public function test_should_return_error_if_no_file_is_provided()
    {        
        $response = $this->json('POST', 'api/import-file', []);
        $response->assertJsonValidationErrorFor('file');
    }

    public function test_should_upload_file_and_return_ok(): void
    {
        Queue::fake();
        $file = UploadedFile::fake()->create('test.txt', 5 * 1024);
        $response = $this->json('POST', '/api/import-file', [
            'file' => $file,
        ]);
        $response->assertStatus(200)
            ->assertJson(['message' => 'Import queued successfully.']);
        Queue::assertPushed(ImportLogJob::class);
    }

    public function test_should_return_exception()
    {
        Queue::fake();
        $file = UploadedFile::fake()->create('test.txt', 5 * 1024);
        $response = $this->json('POST', '/api/import-file', [
            'file' => $file,
        ]);
        $response->assertStatus(200)
            ->assertJson(['message' => 'Import queued successfully.']);
        Queue::assertPushed(ImportLogJob::class);
    }
    
}
