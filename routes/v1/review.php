<?php 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Book\BookController;

Route::post('/reviews', [BookController::class, 'store'])->name('review.store');
Route::get('/reviews/{id}', [BookController::class, 'show'])->name('review.show');
Route::put('/reviews/{id}', [BookController::class, 'update'])->name('review.update');
Route::delete('/reviews/{id}', [BookController::class, 'destroy'])->name('review.destroy');