<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Reply;
use App\Models\Category;
use function now;

class BookReview extends Model
{
    use HasFactory;

    protected $table = 'posts';
    
    protected $fillable = [
        'title',
        'image',
        'date',
        'review',
        'approved',
        'prevPost',
        'nextPost',
        'category_id',
        'user_id',
    ];

    protected static function boot() {
        parent::boot();

        static::creating(function ($model) {
            $model->date = $model->date ?? now();
        });
    }

    /**
     * Get the replies for the book review.
     */
    public function replies() {
        return $this->hasMany(Reply::class, 'book_review_id', 'id');
    }

    /**
     * Get the category that owns the book review.
     */
    public function category() {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    /**
     * Get the user that owns the book review.
     */
    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
