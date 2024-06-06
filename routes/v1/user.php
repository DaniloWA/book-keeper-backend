<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\User\UserController;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/users-registered', [UserController::class, 'getUsersRegistered'])
        ->name('getUsersRegistered');
});
