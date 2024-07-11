<?php

namespace App\Actions\Export;

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
        return [
            'service',
            'average_request_time',
            'average_proxy_time',
            'average_gateway_time'
        ];
    }
}