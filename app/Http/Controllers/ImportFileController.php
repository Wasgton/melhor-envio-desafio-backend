<?php

namespace App\Http\Controllers;

use App\Http\Requests\LogImportRequest;
use App\Jobs\ImportLogJob;
use App\Repositories\LogImportRepository;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class 
ImportFileController extends Controller
{
    public function __invoke(LogImportRequest $request)
    {
        $file = $request->file('file');
        try {
            Storage::disk('public')->put('temp/json_file.txt', file_get_contents($file->getRealPath()));            
            ImportLogJob::dispatch('temp/json_file.txt', new LogImportRepository());
            return response()->json(['message' => 'Import queued successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to import JSON logs.'], 500);
        }
    }
}
