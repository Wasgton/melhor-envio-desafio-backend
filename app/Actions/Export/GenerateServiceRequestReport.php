<?php

namespace App\Actions\Export;

class GenerateServiceRequestReport extends AbstractReportExtractor
{
    public function execute(): string
    {
        $serviceReports = $this->logRepository->getServiceRequests();
        return $this->generateCsv($serviceReports)
            ->storeCsv('service_requests');
    } 
    
    protected function headers()
    {
        return ['service_name', 'total_request'];
    }
}