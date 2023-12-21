<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

class CommentController extends Controller
{
    
    public function getAllComment()
    {
        $Comment = Comment::all();
        // return view('Comment.index', ['Comment' => $Comment]);
        if ($Comment->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No Comment found',
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $Comment,
        ], 200);
    }
    
    public function getAllCommentForBookReviewID($id)
    {
        $Comment = Comment::where('book_review_id', $id)->get();
        if ($Comment->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No Comment found',
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $Comment,
        ], 200);
    }

    public function createCommentFromUser(Request $request)
    {
        $data = $request->validate([
            'content' => 'required',
            'book_review_id' => 'required|numeric',
            // 'user_id' => 'required|numeric',
        ]);
        // lay user_id tu token
        $data['user_id'] = auth()->user()->id;
        // Kiểm tra xem user_id và book_review_id có tồn tại không
        // $user = User::find($data['user_id']);
        // kiểm tra xem book_review_id có tồn tại không
        $bookReview = Post::find($data['book_review_id']);

        // if ($user === null || $bookReview === null) {
        if ($bookReview === null) {
            return response()->json([
                'success' => false,
                'message' => 'Book Review not found',
            ], 404);
        }

        $existingComment = Comment::where('user_id', $data['user_id'])->where('book_review_id', $data['book_review_id'])->first();
        if ($existingComment) {
            return response()->json([
                'success' => false,
                'message' => 'You have already replied to this book review',
            ], 400);
        }

        // Nếu book review đều tồn tại, tạo một Comment mới
        $newComment = Comment::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Comment created successfully',
            'Comment' => $newComment,
        ], 200);
    }

    public function updateCommentFromUser(Request $request, $id)
    {
        $data = $request->validate([
            'content' => 'required',
        ]);

        // Find the Comment
        $Comment = Comment::find($id);

        if ($Comment === null) {
            return response()->json([
                'success' => false,
                'message' => 'Comment not found',
            ], 404);
        }

        // Check if the current user is the one who created the Comment
        if ($Comment->user_id !== auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'You are not authorized to update this Comment',
            ], 403);
        }

        // Update the Comment
        $Comment->content = $data['content'];
        $Comment->save();

        return response()->json([
            'success' => true,
            'message' => 'Comment updated successfully',
            'Comment' => $Comment,
        ], 200);
    }

    public function createComment(Request $request)
    {
        $data = $request->validate([
            'content' => 'required',
            'book_review_id' => 'required|numeric',
            'user_id' => 'required|numeric',
        ]);

        // Kiểm tra xem user_id và book_review_id có tồn tại không
        $user = User::find($data['user_id']);
        $bookReview = Post::find($data['book_review_id']);

        if ($user === null || $bookReview === null) {
            return response()->json([
                'success' => false,
                'message' => 'User or Book Review not found',
            ], 404);
        }

        // Nếu cả user và book review đều tồn tại, tạo một Comment mới
        $newComment = Comment::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Comment created successfully',
            'Comment' => $newComment,
        ], 201);
    }

    public function updateComment(Request $request, $id)
    {
        $data = $request->validate([
            'content' => 'required',
            'book_review_id' => 'required|numeric',
            'user_id' => 'required|numeric',
        ]);

        // Kiểm tra xem user_id và book_review_id có tồn tại không
        $user = User::find($data['user_id']);
        $bookReview = Post::find($data['book_review_id']);

        if ($user === null || $bookReview === null) {
            return response()->json([
                'success' => false,
                'message' => 'User or Book Review not found',
            ], 404);
        }

        $existingComment = Comment::where('user_id', $data['user_id'])->where('book_review_id', $data['book_review_id'])->first();
        if ($existingComment) {
            return response()->json([
                'success' => false,
                'message' => 'You have already replied to this book review',
            ], 400);
        }

        // Nếu cả user và book review đều tồn tại, cập nhật Comment
        $Comment = Comment::find($id);
        if ($Comment) {
            $Comment->update($data);
            return response()->json([
                'success' => true,
                'message' => 'Comment updated successfully',
                'Comment' => $Comment,
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Comment not found',
            ], 404);
        }
    }

    public function deleteComment(Comment $Comment)
    {
        $Comment->delete();
        return response()->json([
            'success' => true,
            'message' => 'Comment deleted successfully',
        ], 200);
        // return redirect(route('Comment.index'))->with('success', 'Comment deleted successfully');
    }
}
