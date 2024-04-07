<?php

use App\Http\Controllers\Api\Profile\ProfileController;
use Illuminate\Support\Facades\Route;

Route::group(
    ['middleware' => ['auth:sanctum']],
    function () {
        Route::post('/profile', [ProfileController::class, 'store'])->name('store');
        Route::get('/profile/{slug}', [ProfileController::class, 'show'])->name('show');
        Route::get('/profiles', [ProfileController::class, 'index'])->name('index');
        Route::put('/profile/{slug}', [ProfileController::class, 'update'])->name('update');
        Route::delete('/profile/{slug}', [ProfileController::class, 'destroy'])->name('destroy');
    }
);
