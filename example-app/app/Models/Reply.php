<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\BookReview;

class Reply extends Model
{
    use HasFactory;

    protected $table = 'replies';
    protected $fillable = [
        'content',
        
        'book_review_id',
        'user_id',
    ];

    /**
     * Get the book review that owns the reply.
     */
    public function bookReview() {
        return $this->belongsTo(BookReview::class, 'book_review_id', 'id');
    }

    /**
     * Get the user that owns the reply.
     */
    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
