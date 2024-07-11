<?php

namespace App\Actions\Import;

use App\Jobs\ImportLogJob;
use Illuminate\Support\Facades\Storage;

class SendToQueueChunked
{
    private int $chunkSize = 10 * 1024 * 1024;
    /**
     * @param string $filePath
     * @param int $chunkSize
     * @return void
     */
    public function execute($filePath, $chunkSize = 0)
    {
        $this->chunkSize = $chunkSize>0 ? $chunkSize : $this->chunkSize;
        foreach ($this->splitFile($filePath) as $chunkFilePath) {
            ImportLogJob::dispatch($chunkFilePath);
        }
    }

    private function splitFile(string $filePath)
    {        
        $handle = Storage::disk('public')->readStream($filePath);
        $chunkNumber = 0;
        $buffer = '';
        while (!feof($handle)) {
            $chunkfilePath = "temp/json_file_chunk_{$chunkNumber}.txt";
            $chunkFileFullPath = storage_path("app/public/{$chunkfilePath}");
            $chunkFileOpenHandle = fopen($chunkFileFullPath, 'w');
            $currentChunkSize = 0;
            while ($currentChunkSize < $this->chunkSize && !feof($handle)) {
                $buffer .= fgets($handle);
                $currentChunkSize = strlen($buffer);
            }
            if (feof($handle)) {
                $chunkData = $buffer;
                $buffer = '';
            } elseif ($lastBreakLine = strrpos($buffer, "\n")) {                
                $chunkData = substr($buffer, 0, $lastBreakLine + 1);
                $buffer = substr($buffer, $lastBreakLine + 1);
            } else {
                $chunkData = $buffer;
                $buffer = '';
            }
            fwrite($chunkFileOpenHandle, $chunkData);
            fclose($chunkFileOpenHandle);
            yield $chunkfilePath;
            $chunkNumber++;
        }
        fclose($handle);
        Storage::disk('public')->delete($filePath);
    }
    
}