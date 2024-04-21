<?php

use App\Http\Controllers\Api\Genre\GenreController;
use Illuminate\Support\Facades\Route;

Route::group(
    ['middleware' => ['auth:sanctum']],
    function () {
        Route::get('/genres', [GenreController::class, 'index'])->name('index');
        Route::post('/genres', [GenreController::class, 'store'])->name('store');
        Route::get('/genres/{id}', [GenreController::class, 'show'])->name('show');
        Route::put('/genres/{id}', [GenreController::class, 'update'])->name('update');
        Route::delete('/genres/{id}', [GenreController::class, 'destroy'])->name('destroy');
    }
);
