<?php 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Book\BookController;

Route::post('/books', [BookController::class, 'store'])->name('book.store');
Route::get('/books', [BookController::class, 'index'])->name('book.show');
Route::get('/books/{uuid}', [BookController::class, 'show'])->name('book.show');
Route::put('/books/{uuid}', [BookController::class, 'update'])->name('book.update');
Route::delete('/books/{uuid}', [BookController::class, 'destroy'])->name('book.destroy');