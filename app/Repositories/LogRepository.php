<?php

namespace App\Repositories;

use App\Models\Latency;
use App\Models\Log;
use App\Models\Request;
use App\Models\Response;
use App\Models\Route;
use App\Models\Service;
use Illuminate\Support\Facades\DB;

class LogRepository
{

    public function saveBatch(mixed $batch)
    {
        Log::insert($batch['logs']);
        Request::insert($batch['requests']);
        Response::insert($batch['responses']);
        Route::insert($batch['routes']);
        Service::insert($batch['services']);
        Latency::insert($batch['latencies']);
    }

    public function getConsumerRequests(): array
    {
        return Log::Join('requests', 'logs.id', '=', 'requests.log_id')
            ->select('consumer_id', DB::raw('count(*) as total_request'))
            ->groupBy('consumer_id')
            ->get()
            ->toArray();
    }

    public function getServiceRequests(): array
    {
        return Log::Join('requests', 'logs.id', '=', 'requests.log_id')
            ->join('services', 'logs.id', '=', 'services.log_id')
            ->select('name', DB::raw('count(*) as total_request'))
            ->groupBy('name')
            ->get()
            ->toArray();
    }

    public function getAverageTimePerService(): array
    {
        return Log::Join('requests', 'logs.id', '=', 'requests.log_id')
                ->join('services', 'logs.id', '=', 'services.log_id')
                ->join('latencies', 'logs.id', '=', 'latencies.log_id')
                ->select(
                    'name', 
                    DB::raw('avg(request) as average_request_time'),
                    DB::raw('avg(proxy) as average_proxy_time'),
                    DB::raw('avg(gateway) as average_gateway_time')
                )
                ->groupBy('name')
                ->get()
                ->toArray();
    }
    
}