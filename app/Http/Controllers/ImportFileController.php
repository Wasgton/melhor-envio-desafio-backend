<?php

namespace App\Http\Controllers;

use App\Http\Requests\LogImportRequest;
use App\Services\FileStorageService;
use App\Services\ImportLogService;
use Illuminate\Http\Response;

class 
ImportFileController extends Controller
{
    public function __construct(
        private readonly FileStorageService $fileStorageService,
        private readonly ImportLogService $importLogService
    )
    {}

    public function __invoke(LogImportRequest $request)
    {
        $file = $request->file('file');
        try {
            $filePath = $this->fileStorageService->storeTempFile($file);
            $this->importLogService->sendToQueueChunked($filePath);
            return response()->json(['message' => 'Import queued successfully.']);
        } catch (\Exception $e) {
            return response()->json(
                ['error' => 'Failed to import JSON logs.'], 
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
