<?php

use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::get('/teste', function () {
    return view('welcome');
});

Route::group(['prefix' => '/report', 'controller' => ReportController::class], static function () {
    Route::get('/consumer', 'exportConsumerRequests');
    Route::get('/service', 'exportServiceRequests');
    Route::get('/latency', 'exportAverageTimePerService');
});
