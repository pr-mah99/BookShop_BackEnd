<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// ------
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// -------

Route::post('/login', [UserController::class, 'login']);
Route::post('/signup', [UserController::class, 'signup']);

// Order
Route::post('/order', [OrderController::class, 'store']);


// for Public --
// Books
Route::get('/books', [BookController::class, 'index']);
Route::get('/authors-with-book-count', [BookController::class, 'getAuthorsWithBookCount']);


// ------------
// for Admin --

Route::group(['middleware' => ['auth:sanctum', 'admin']], function () {
   
    // Books
    Route::post('/books', [BookController::class, 'store']);
    Route::put('/books/{book}', [BookController::class, 'update']);
    Route::delete('/books/{id}', [BookController::class, 'destroy']);


    // Order
    Route::get('/order', [OrderController::class, 'index']);

});

