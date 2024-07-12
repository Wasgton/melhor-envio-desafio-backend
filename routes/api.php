<?php

use App\Http\Controllers\ImportFileController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::post('/v1/import-file', ImportFileController::class)->name('import-file');

Route::group(['prefix' => '/v1/report', 'controller' => ReportController::class], static function () {
    Route::get('/consumer', 'exportConsumerRequests')->name('report.consumer');
    Route::get('/service', 'exportServiceRequests')->name('report.service');
    Route::get('/latency', 'exportAverageTimePerService')->name('report.latency');
});
