<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Book\BookController;

Route::group(
    ['middleware' => ['auth:sanctum']],
    function () {
        Route::post('/books', [BookController::class, 'store'])->name('store');
        Route::get('/books', [BookController::class, 'index'])->name('index');
        Route::get('/books/{uuid}', [BookController::class, 'show'])->name('show');
        Route::put('/books/{uuid}', [BookController::class, 'update'])->name('update');
        Route::delete('/books/{uuid}', [BookController::class, 'destroy'])->name('destroy');
    }
);
