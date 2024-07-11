<?php

namespace App\Jobs;

use App\Repositories\LogImportRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class ImportLogJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $timeout = 900;
    public int $tries = 5;
    public int $maxExceptions = 3;
    private LogImportRepository|null $logRepository;
    private array $batch = [
        'logs' => [],
        'requests' => [],
        'responses' => [],
        'routes' => [],
        'services' => [],
        'latencies' => [],
    ];
    /**
     * Create a new job instance.
     */
    public function __construct(
        public readonly string $file, 
        $logRepository = null,
        private readonly int $batchSize = 1000
    )
    {
        $this->logRepository = $logRepository??app(LogImportRepository::class);        
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        DB::beginTransaction();
        try {
            foreach ($this->getLine($this->file) as $index => $line)
            {
                $logData = json_decode($line, true);
                if(!$logData){
                    break;
                }
                $this->prepareLogData($logData);
                if (count($this->batch['logs']) >= $this->batchSize) {
                    $this->logRepository->saveBatch($this->batch);
                    $this->resetBatch();                    
                }
            }
            if (!empty($this->batch)) {
                $this->logRepository->saveBatch($this->batch);
            }
            Storage::disk('public')->delete($this->file);
            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack();
            Storage::disk('public')->delete($this->file);
            throw $e;
        }        
    }

    public function failed(Throwable $exception): void
    {
        Log::error('ImportLogJob failed', ['filePath' => $this->file, 'exception' => $exception->getMessage()]);     
    }
    
    public function backoff(): array
    {
        return [10, 30, 60];
    }
    
    private function getLine($filePath)
    {
        $handle = Storage::disk('public')->readStream($filePath);
        if (!$handle) {
            throw new \Exception('Unable to open file: ' . $filePath);
        }
        try {
            while ($line = fgets($handle)) {
                yield $line;
            }
        } finally {
            fclose($handle);
        }
    }

    private function prepareLogData(mixed $data) : void
    {
        $logId = Str::orderedUuid()->toString();
        $this->batch['logs'][] = [
            'id' => $logId,
            'upstream_uri' => $data['upstream_uri'],
            'client_ip' => $data['client_ip'],
            'consumer_id' => $data['authenticated_entity']['consumer_id']['uuid'],
            'started_at' => $data['started_at'],
        ];
        $this->batch['requests'][] = [
            'id' => Str::orderedUuid()->toString(),
            'method' => $data['request']['method'],
            'uri' => $data['request']['uri'],
            'url' => $data['request']['url'],
            'size' => $data['request']['size'],
            'querystring' => json_encode($data['request']['querystring']),
            'headers' => json_encode($data['request']['headers']),
            'log_id' => $logId,
        ];
        $this->batch['responses'][] = [
            'id' => Str::orderedUuid()->toString(),
            'status' => $data['response']['status'],
            'size' => $data['response']['size'],
            'headers' => json_encode($data['response']['headers']),
            'log_id' => $logId,
        ];
        $this->batch['routes'][] = [
            'id' => Str::orderedUuid()->toString(),
            'route_original_id' => $data['route']['id'],
            'hosts' => json_encode($data['route']['hosts']),
            'methods' => json_encode($data['route']['methods']),
            'paths' => json_encode($data['route']['paths']),
            'preserve_host' => $data['route']['preserve_host'],
            'protocols' => json_encode($data['route']['protocols']),
            'regex_priority' => $data['route']['regex_priority'],
            'service_original_id' => $data['route']['service']['id'],
            'strip_path' => $data['route']['strip_path'],
            'log_id' => $logId,
        ];
        $this->batch['services'][] = [
            'id' => Str::orderedUuid()->toString(),
            'service_original_id' => $data['service']['id'],
            'name' => $data['service']['name'],
            'host' => $data['service']['host'],
            'port' => $data['service']['port'],
            'protocol' => $data['service']['protocol'],
            'connect_timeout' => $data['service']['connect_timeout'],
            'read_timeout' => $data['service']['read_timeout'],
            'write_timeout' => $data['service']['write_timeout'],
            'retries' => $data['service']['retries'],
            'log_id' => $logId,
        ];
        $this->batch['latencies'][] = [
            'id' => Str::orderedUuid()->toString(),
            'proxy' => $data['latencies']['proxy'],
            'gateway' => $data['latencies']['gateway'],
            'request' => $data['latencies']['request'],
            'log_id' => $logId,
        ];
    }

    private function resetBatch(): void
    {
        $this->batch = [
            'logs' => [],
            'requests' => [],
            'responses' => [],
            'routes' => [],
            'services' => [],
            'latencies' => [],
        ];
    }

}
