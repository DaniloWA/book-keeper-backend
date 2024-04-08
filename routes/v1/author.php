<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Author\AuthorController;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/authors', [AuthorController::class, 'store'])->name('store');
    Route::get('/authors', [AuthorController::class, 'index'])->name('index');
    Route::get('/authors/{id}', [AuthorController::class, 'show'])->name('show');
    Route::put('/authors/{id}', [AuthorController::class, 'update'])->name('update');
    Route::delete('/authors/{id}', [AuthorController::class, 'destroy'])->name('destroy');
});