<?php

namespace App\Actions;

use App\Repositories\LogRepository;
use Illuminate\Support\Facades\Storage;

class GenerateConsumerRequestReport extends AbstractReportExtractor
{
    public function execute(): string
    {
        $consumerReports = $this->logRepository->getConsumerRequests();
        return $this->generateCsv($consumerReports)
            ->storeCsv('consumer_requests');
    }    
    
    protected function headers()
    {
        return ['consumer_id', 'total_request'];
    }
}