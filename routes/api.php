<?php

use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\LendController;
use App\Http\Controllers\Api\UserController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('users', UserController::class);
Route::get('users/lends/{id}', [UserController::class, 'user_lends']);
Route::get('users/books/{id}', [UserController::class, 'user_books']);

Route::resource('books', BookController::class);
Route::resource('lends', LendController::class);
