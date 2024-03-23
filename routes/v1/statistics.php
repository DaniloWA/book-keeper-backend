<?php

use App\Http\Controllers\Api\Statistics\StatisticsController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/statistics/book/{uuid}', [StatisticsController::class, 'show'])->name('show');
    Route::post('/statistics/like/book/{uuid}', [StatisticsController::class, 'like'])->name('like');
    Route::post('/statistics/status/book/{uuid}', [StatisticsController::class, 'changeStatus'])->name('changeStatus');
});
