<?php

use App\Http\Controllers\Api\Rating\RatingController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/rating/book/{uuid}/rate/{rating?}', [RatingController::class, 'rate'])->name('rate');
});
