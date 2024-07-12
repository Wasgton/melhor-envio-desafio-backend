<?php

use App\Http\Controllers\ImportFileController;
use Illuminate\Support\Facades\Route;

Route::post('/import-file', ImportFileController::class)->name('import-file');
