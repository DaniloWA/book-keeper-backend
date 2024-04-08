<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Review\ReviewController;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/reviews', [ReviewController::class, 'store'])->name('store');
    Route::get('/reviews/{id}', [ReviewController::class, 'show'])->name('show');
    Route::put('/reviews/{id}', [ReviewController::class, 'update'])->name('update');
    Route::delete('/reviews/{id}', [ReviewController::class, 'destroy'])->name('destroy');
});

