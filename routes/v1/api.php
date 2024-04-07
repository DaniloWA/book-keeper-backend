<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::get('/', function (Request $request) {
    return "Hello World!";
});

Route::name('auth.')
    ->group(base_path('routes/v1/auth.php'));

Route::name('statistics.')
    ->group(base_path('routes/v1/statistics.php'));

Route::name('book.')
    ->group(base_path('routes/v1/book.php'));

Route::name('author.')
    ->group(base_path('routes/v1/author.php'));

Route::name('profile.')
    ->group(base_path('routes/v1/profile.php'));
