<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
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
        $fileFromDisk = Storage::disk()->get('json_file.txt');
        $file = UploadedFile::fake()->create('file.txt', 100, 'text/plain', $fileFromDisk);
        Storage::fake('json_file');
        $response = $this->json('POST', 'api/import-file', [
            'file' => $file 
        ]);
        $response->assertStatus(Response::HTTP_OK);
    }

}
