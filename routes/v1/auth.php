<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\ApiAuthController;

/*
|--------------------------------------------------------------------------
| API Auth Routes
|--------------------------------------------------------------------------
|
|
*/

Route::post('/auth/register', [ApiAuthController::class, 'register']);
Route::post('/auth/login', [ApiAuthController::class, 'login']);

Route::group(
    ['middleware' => ['auth:sanctum']],
    function () {
        Route::post('/auth/logout', [ApiAuthController::class, 'logout']);
        Route::get('/auth/user', [ApiAuthController::class, 'currentUser']);
    }
);
