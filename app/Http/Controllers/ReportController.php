<?php

namespace App\Http\Controllers;

use App\Actions\Export\GenerateConsumerRequestReport;
use App\Actions\Export\GenerateLatenciesRequestReport;
use App\Actions\Export\GenerateServiceRequestReport;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    public function exportConsumerRequests(GenerateConsumerRequestReport $generateConsumerRequestReport)
    {
        try {
            $consumerRequestsPath = $generateConsumerRequestReport->execute();
            return response()->download(Storage::disk('public')->path($consumerRequestsPath));
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to export consumer requests.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function exportServiceRequests(GenerateServiceRequestReport $generateServiceRequestReport)
    {
        try {
            $serviceRequestsPath = $generateServiceRequestReport->execute();
            return response()->download(Storage::disk('public')->path($serviceRequestsPath));
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to export service requests.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function exportAverageTimePerService(GenerateLatenciesRequestReport $generateLatenciesRequestReport)
    {
        try {
            $averageTimePerServicePath = $generateLatenciesRequestReport->execute();
            return response()->download(Storage::disk('public')->path($averageTimePerServicePath));
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to export average time per service.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
}
