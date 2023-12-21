<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookReviewController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReplyController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('bookReviews', [BookReviewController::class, 'getAllReviews']);
Route::post('bookReviews', [BookReviewController::class, 'createReview']);

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [UserController::class, 'create']);
Route::put('/user/update', [UserController::class, 'update']);

//auth:sanctum yeu cau Authorization header khi gui request
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->get('/home', [UserController::class, 'show']);

Route::get('/reply', [ReplyController::class, 'getAllReplies']);
Route::post('/reply', [ReplyController::class, 'createReply']);

Route::post('/reply/user', [ReplyController::class, 'createReplyFromUser']);
Route::put('/reply/user/{id}', [ReplyController::class, 'updateReplyFromUser']);
Route::get('/replies/book_review/{id}', [ReplyController::class, 'getAllRepliesForBookReviewID']);
Route::put('/reply/{reply}/update', [ReplyController::class, 'updateReply']);
Route::delete('/reply/{reply}/destroy', [ReplyController::class, 'deleteReply']);

// Route::middleware('auth:sanctum')->get('/reply/{reply}', [ReplyController::class, 'getAllRepliesForReview']);
// Route::middleware('auth:sanctum')->put('/reply/{reply}/update', [ReplyController::class, 'updateReply']);
// Route::middleware('auth:sanctum')->delete('/reply/{reply}/destroy', [ReplyController::class, 'deleteReply']);

