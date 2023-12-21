<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CategoryController;

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
// Route::get('bookReviews', [BookReviewController::class, 'getAllReviews']);
// Route::post('bookReviews', [BookReviewController::class, 'createReview']);

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [UserController::class, 'create']);
Route::put('/user/updatePassword', [UserController::class, 'updatePassword']);

Route::middleware('auth:api')->delete('/admin/{user}', [UserController::class, 'destroy']);
Route::middleware('auth:api')->put('/user/{user}/update', [UserController::class, 'update']);
Route::middleware('auth:api')->post('/admin/{user}', [AuthController::class, 'createAdmin']);


//auth:api yeu cau Authorization header khi gui request
Route::middleware('auth:api')->post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:api')->get('/home', [UserController::class, 'show']);






Route::get('/comment', [CommentController::class, 'getAllComment']);
Route::post('/comment', [CommentController::class, 'createComment']);

Route::post('/comment/user', [CommentController::class, 'createcommentFromUser']);
Route::put('/comment/user/{id}', [CommentController::class, 'updateCommentFromUser']);
Route::get('/comments/book_review/{id}', [CommentController::class, 'getAllCommentsForBookReviewID']);
Route::put('/comment/{comment}/update', [CommentController::class, 'updateComment']);
Route::delete('/comment/{comment}/destroy', [CommentController::class, 'deleteComment']);

Route::get('/posts', [PostController::class, 'getAllPosts']);
Route::middleware('auth:api')->post('/post', [PostController::class, 'createPost']);
Route::get('/post/{post}', [PostController::class, 'getPost']);
Route::middleware('auth:api')->put('/post/{post}/update', [PostController::class, 'updatePost']);
Route::middleware('auth:api')->delete('/post/{post}/destroy', [PostController::class, 'deletePost']);

Route::post('/category', [CategoryController::class, 'createCategory']);

// Route::middleware('auth:sanctum')->get('/reply/{reply}', [ReplyController::class, 'getAllRepliesForReview']);
// Route::middleware('auth:sanctum')->put('/reply/{reply}/update', [ReplyController::class, 'updateReply']);
// Route::middleware('auth:sanctum')->delete('/reply/{reply}/destroy', [ReplyController::class, 'deleteReply']);

