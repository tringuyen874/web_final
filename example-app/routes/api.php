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

Route::middleware('auth:api')->delete('/admin/{user}', [UserController::class, 'destroy']);
Route::middleware('auth:api')->put('/user/{user}/update', [UserController::class, 'update']);
Route::middleware('auth:api')->post('/admin/{user}', [AuthController::class, 'createAdmin']);


//auth:api yeu cau Authorization header khi gui request
Route::middleware('auth:api')->post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:api')->get('/home', [UserController::class, 'show']);






Route::get('/reply', [ReplyController::class, 'getAllReplies']);
Route::post('/reply', [ReplyController::class, 'createReply']);
Route::get('/reply/{reply}', [ReplyController::class, 'getAllRepliesForBookReviewID']);
Route::put('/reply/{reply}/update', [ReplyController::class, 'updateReply']);
Route::delete('/reply/{reply}/destroy', [ReplyController::class, 'deleteReply']);

// Route::middleware('auth:sanctum')->get('/reply/{reply}', [ReplyController::class, 'getAllRepliesForReview']);
// Route::middleware('auth:sanctum')->put('/reply/{reply}/update', [ReplyController::class, 'updateReply']);
// Route::middleware('auth:sanctum')->delete('/reply/{reply}/destroy', [ReplyController::class, 'deleteReply']);

