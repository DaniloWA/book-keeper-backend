<?php 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Author\AuthorController;

Route::post('/authors', [AuthorController::class, 'store'])->name('author.store');
Route::get('/authors/{id}', [AuthorController::class, 'show'])->name('author.show');
Route::put('/authors/{id}', [AuthorController::class, 'update'])->name('author.update');
Route::delete('/authors/{id}', [AuthorController::class, 'destroy'])->name('author.destroy');