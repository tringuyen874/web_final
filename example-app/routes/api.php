<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookReviewController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::get('bookReviews', [BookReviewController::class, 'getAllReviews']);
Route::post('bookReviews', [BookReviewController::class, 'createReview']);

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [UserController::class, 'create']);
Route::put('/user/updatePassword', [UserController::class, 'updatePassword']);

//auth:sanctum yeu cau Authorization header khi gui request
Route::middleware('auth:api')->post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:api')->get('/home', [UserController::class, 'show']);
Route::middleware('auth:api')->get('/user', [UserController::class, 'show']);