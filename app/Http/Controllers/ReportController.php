<?php

namespace App\Http\Controllers;

use App\Actions\Export\GenerateConsumerRequestReport;
use App\Actions\Export\GenerateLatenciesRequestReport;
use App\Actions\Export\GenerateServiceRequestReport;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use OpenApi\Annotations as OA;

class ReportController extends Controller
{
    /**
     * @OA\Get(
     *      path="/report/consumer",
     *      summary="Exporta relatório de requisições de consumidores",
     *      description="Exporta um relatório CSV contendo as requisições de consumidores",
     *      tags={"export"},
     *      @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\MediaType(
     *              mediaType="application/octet-stream"
     *          )
     *      ),
     *      @OA\Response(
     *           response=500,
     *           description="Erro",
     *           @OA\JsonContent(
     *               @OA\Property(
     *                   property="error",
     *                   type="string",
     *                   example="Failed to export consumer requests."
     *               )
     *           )
     *       ),
     *  )
     */
    public function exportConsumerRequests(GenerateConsumerRequestReport $generateConsumerRequestReport)
    {
        try {
            $consumerRequestsPath = $generateConsumerRequestReport->execute();
            return response()->download(Storage::disk('public')->path($consumerRequestsPath));
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to export consumer requests.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Get(
     *      path="/report/service",
     *      summary="Exporta relatório de requisições de serviços",
     *      description="Exporta um relatório CSV contendo as requisições de serviços",
     *      tags={"export"},
     *      @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\MediaType(
     *              mediaType="application/octet-stream"
     *          )
     *      ),
     *      @OA\Response(
     *           response=500,
     *           description="Erro",
     *           @OA\JsonContent(
     *               @OA\Property(
     *                   property="error",
     *                   type="string",
     *                   example="Failed to export service requests."
     *               )
     *           )
     *       ),
     *  )
     */
    public function exportServiceRequests(GenerateServiceRequestReport $generateServiceRequestReport)
    {
        try {
            $serviceRequestsPath = $generateServiceRequestReport->execute();
            return response()->download(Storage::disk('public')->path($serviceRequestsPath));
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to export service requests.'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * @OA\Get(
     *      path="/report/latency",
     *      summary="Exporta relatório de tempo médio por serviço",
     *      description="Exporta um relatório CSV contendo o tempo médio de latência por serviço",
     *      tags={"export"},
     *      @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\MediaType(
     *              mediaType="application/octet-stream"
     *          )
     *      ),
     *      @OA\Response(
     *           response=500,
     *           description="Erro",
     *           @OA\JsonContent(
     *               @OA\Property(
     *                   property="error",
     *                   type="string",
     *                   example="Failed to export average time per service."
     *               )
     *           )
     *       ),
     *  )
     */
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
