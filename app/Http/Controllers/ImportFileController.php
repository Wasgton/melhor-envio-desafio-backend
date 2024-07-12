<?php

namespace App\Http\Controllers;

use App\Actions\Import\SendToQueueChunked;
use App\Http\Requests\LogImportRequest;
use App\Services\FileStorageService;
use Illuminate\Http\Response;
use OpenApi\Annotations as OA;

class ImportFileController extends Controller
{
    public function __construct(
        private readonly FileStorageService $fileStorageService,
        private readonly SendToQueueChunked $sendToQueueChunked
    )
    {}

    /**
     *  @OA\Post(
     *      path="/api/v1/import-file",
     *      summary="Importa um arquivo de log",
     *      description="Importa um arquivo de log, e registra na fila de processamento",
     *      tags={"import"},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  @OA\Property(
     *                      property="file",
     *                      description="Arquivo de log a ser importado",
     *                      type="string",
     *                      format="binary"
     *                  )
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Import queued successfully."
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *           response=500,
     *           description="Erro",
     *           @OA\JsonContent(
     *               @OA\Property(
     *                   property="error",
     *                   type="string",
     *                   example="Failed to import JSON logs."
     *               )
     *           )
     *       ),
     *  )
     */
    public function __invoke(LogImportRequest $request)
    {
        $file = $request->file('file');
        try {
            $filePath = $this->fileStorageService->storeTempFile($file);
            $this->sendToQueueChunked->execute($filePath);
            return response()->json(['message' => 'Import queued successfully.']);
        } catch (\Exception $e) {
            return response()->json(
                ['error' => 'Failed to import JSON logs.'], 
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
