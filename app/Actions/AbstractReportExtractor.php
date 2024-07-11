<?php

namespace App\Actions;

use App\Repositories\LogRepository;
use Illuminate\Support\Facades\Storage;
use Nette\NotImplementedException;

abstract class AbstractReportExtractor
{
    protected string $data;

    public function __construct(protected readonly LogRepository $logRepository){}

    protected function generateCsv(array $data): AbstractReportExtractor
    {
        $csv[] = implode(',', $this->headers()) . PHP_EOL;
        foreach ($data as $row) {
            $csv[] = implode(',', $row);
        }
        $this->data = implode(PHP_EOL, $csv);
        return $this;
    }

    protected function headers()
    {
        return [];
    }

    protected function storeCsv(string $fileName): string
    {
        $filePath = "report/{$fileName}_".now()->format('Ymd_His').".csv";
        Storage::disk('public')->put($filePath, $this->data);
        return "/storage/{$filePath}";
    }
}