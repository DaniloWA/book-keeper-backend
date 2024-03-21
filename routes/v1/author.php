<?php 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Author\AuthorController;

Route::post('/author', [AuthorController::class, 'store'])->name('author.store');
Route::get('/author/{id}', [AuthorController::class, 'show'])->name('author.show');
Route::put('/author/{id}', [AuthorController::class, 'update'])->name('author.update');
Route::delete('/author/{id}', [AuthorController::class, 'destroy'])->name('author.destroy');