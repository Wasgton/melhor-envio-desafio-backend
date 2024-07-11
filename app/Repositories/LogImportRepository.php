<?php

namespace App\Repositories;

use App\Models\Latency;
use App\Models\Log;
use App\Models\Request;
use App\Models\Response;
use App\Models\Route;
use App\Models\Service;

class LogImportRepository
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

}