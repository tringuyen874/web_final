<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;

class PostController extends Controller
{
    //
    public function getAllReviews()
    {
        $posts = Post::all();
        // return view('bookReviews.index', ['bookReviews' => $bookReviews]);
        if ($posts->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No book reviews found',
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $posts,
        ], 200);
    }

    public function createReview(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'review' => 'required',
            'category_id' => 'required|numeric',
            'user_id' => 'required|numeric',
        ]);
        $newBookReview = Post::create($data);
        $category = $newBookReview->category;
        $user = $newBookReview->user;

        if ($user === null) {
            return response()->json([
                'success' => false,
                'message' => 'No user found',
            ], 404);
        }

        if ($category === null) {
            return response()->json([
                'success' => false,
                'message' => 'No category found',
            ], 404);
        }
        // return view('bookReviews.create');
        return response()->json([
            'success' => true,
            'data' => $newBookReview,
        ], 200);
    }
}
