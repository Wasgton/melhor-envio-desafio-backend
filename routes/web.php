<?php

use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

Route::view('/','home');

Route::group(['prefix' => '/report', 'controller' => ReportController::class], static function () {
    Route::get('/consumer', 'exportConsumerRequests')->name('report.consumer');
    Route::get('/service', 'exportServiceRequests')->name('report.service');
    Route::get('/latency', 'exportAverageTimePerService')->name('report.latency');
});
