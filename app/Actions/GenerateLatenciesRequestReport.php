<?php

namespace App\Actions;

use App\Repositories\LogRepository;
use Illuminate\Support\Facades\Storage;

class GenerateLatenciesRequestReport extends AbstractReportExtractor
{
    public function execute(): string
    {
        $averageTimeReports = $this->logRepository->getAverageTimePerService();
        return $this->generateCsv($averageTimeReports)
            ->storeCsv('average_time_per_service');
    }
    
    protected function headers()
    {
        return ['consumer_id', 'total_request'];
    }
}