<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;

class PostController extends Controller
{
    //
    public function getAllPosts()
    {
        $posts = Post::all();
        // return view('bookReviews.index', ['bookReviews' => $bookReviews]);
        if ($posts->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No posts found',
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $posts,
        ], 200);
    }

    public function createPost(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'image' => 'nullable'|'string',
            // 'date' => 'nullable'|'date',
            'review' => 'required',
            'category' => 'required|string',
            
        ]);
        $data['approve'] = false;
        $data['prevPost'] = null;
        $data['nextPost'] = null;
        $data['date'] = now();
        $data['user_id'] = auth()->user()->id;
        // $user = User::find($data['user_id']);
        $user = auth()->user();
        $category = Category::where('name', $data['category'])->first();
        $data['category_id'] = $category->id;
        // $category = Category::find($data['category_id']);
        
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

        $newPost = Post::create($data);
        // return view('bookReviews.create');
        return response()->json([
            'success' => true,
            'data' => $newPost,
        ], 200);
    }

    public function updatePost (Request $request, Post $post)
    {
        $data = $request->validate([
            'title' => 'required',
            'image' => 'nullable'|'string',
            // 'date' => 'nullable'|'date',
            'review' => 'required',
            'category' => 'required|string',
        ]);
        $user = auth()->user();

        $data['approve'] = false;
        $data['prevPost'] = null;
        $data['nextPost'] = null;
        $data['date'] = now();
        $data['user_id'] = auth()->user()->id;
        if ($post->user_id !== $data['user_id'] && $user->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'You are not the owner of this post',
            ], 404);
        }
        $category = Category::where('name', $data['category'])->first();
        $data['category_id'] = $category->id;
        // $category = Category::find($data['category_id']);
        
        
        
        if ($category === null) {
            return response()->json([
                'success' => false,
                'message' => 'No category found',
            ], 404);
        }

        $post->update($data);
        // return view('bookReviews.create');
        return response()->json([
            'success' => true,
            'data' => $post,
        ], 200);
    }

    public function getPost(Post $post)
    {
        
        if ($post === null) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found',
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $post,
        ], 200);
    }

    public function deletePost(Post $post)
    {
        $user = auth()->user();
        if ($post->user_id !== $user->id && $user->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'You are not the owner of this post',
            ], 404);
        }
        $post->delete();
        return response()->json([
            'success' => true,
            'message' => 'Post deleted successfully',
        ], 200);
    }

    public function approvePost(Post $post)
    {
        $user = auth()->user();
        if ($user->role !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => 'You are not the admin',
            ], 404);
        }
        $post->approve = true;
        $post->save();
        return response()->json([
            'success' => true,
            'message' => 'Post approved successfully',
        ], 200);
    }

    public function getPostsFromUser() {
        $user = auth()->user();
        $posts = Post::where('user_id', $user->id)->get();
        if ($posts->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No posts found',
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $posts,
        ], 200);
    }

    public function getPostsFromCategory($category) {
        $posts = Post::where('category_id', $category->id)->get();
        if ($posts->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No posts found',
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $posts,
        ], 200);
    }
}
