<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Post;

class Comment extends Model
{
    use HasFactory;

    protected $table = 'comments';
    protected $fillable = [
        'content',
        
        'post_id',
        'user_id',
    ];

    /**
     * Get the book review that owns the reply.
     */
    public function posts() {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }

    /**
     * Get the user that owns the reply.
     */
    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
