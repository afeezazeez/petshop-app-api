<?php

use Afeezazeez\Converter\Http\Controllers\ConverterController;
use Illuminate\Support\Facades\Route;

Route::prefix('api/v1')->group(function () {
    Route::get('exchange', [ConverterController::class, 'convert']);
});
