<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reply;

class ReplyController extends Controller
{
    // public function index()
    // {
    //     $replies = Reply::all();
    //     return view('replies.index', ['replies' => $replies]);
    // }

    // public function createR(Request $request)
    // {
    //     $data = $request->validate([
    //         'content' => 'required',
            
    //         'book_review_id' => 'required|numeric',
    //         'user_id' => 'required|numeric',
    //     ]);
    //     $newReply = Reply::create($data);
    //     $bookReview = $newReply->bookReview;
    //     $user = $newReply->user;

    //     if ($user === null) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'No user found',
    //         ], 404);
    //     }

    //     if ($bookReview === null) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'No book review found',
    //         ], 404);
    //     }

    //     return response()->json([
    //         'success' => true,
    //         'data' => $newReply,
    //     ], 200);

    //     // return view('replies.create');
    // }

    // public function 

    // public function update(Request $request, Reply $reply)
    // {
    //     $data = $request->validate([
    //         'content' => 'required',
            
    //         'book_review_id' => 'required|numeric',
    //         'user_id' => 'required|numeric',
    //     ]);
    //     $reply->update($data);
    //     // return redirect(route('reply.index'))->with('success', 'Reply updated successfully');
    // }

    // public function destroy(Reply $reply)
    // {
    //     $reply->delete();
    //     // return redirect(route('reply.index'))->with('success', 'Reply deleted successfully');
    // }

    public function getAllReplies()
    {
        $replies = Reply::all();
        // return view('replies.index', ['replies' => $replies]);
        if ($replies->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No replies found',
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $replies,
        ], 200);
    }
    
    public function getAllRepliesForReview($id)
    {
        $replies = Reply::where('book_review_id', $id)->get();
        if ($replies->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No replies found',
            ], 404);
        }
        return response()->json([
            'success' => true,
            'data' => $replies,
        ], 200);
    }

    public function createReply(Request $request)
    {
        $data = $request->validate([
            'content' => 'required',
            
            'book_review_id' => 'required|numeric',
            'user_id' => 'required|numeric',
        ]);
        $newReply = Reply::create($data);
        $bookReview = $newReply->bookReview;
        $user = $newReply->user;

        if ($user === null) {
            return response()->json([
                'success' => false,
                'message' => 'No user found',
            ], 404);
        }

        if ($bookReview === null) {
            return response()->json([
                'success' => false,
                'message' => 'No book review found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $newReply,
        ], 200);

        // return view('replies.create');
    }

    public function updateReply(Request $request, Reply $reply)
    {
        $data = $request->validate([
            'content' => 'required',
            
            'book_review_id' => 'required|numeric',
            'user_id' => 'required|numeric',
        ]);
        $reply->update($data);
        // return redirect(route('reply.index'))->with('success', 'Reply updated successfully');
    }

    public function deleteReply(Reply $reply)
    {
        $reply->delete();
        // return redirect(route('reply.index'))->with('success', 'Reply deleted successfully');
    }
}
