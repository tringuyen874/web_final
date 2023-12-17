<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BookReview;

class Category extends Model
{
    use HasFactory;

    protected $table='categories';

    protected $fillable=[
        'name',
        
    ];
    /**
     * Get the book reviews for the category.
     */
    public function bookReviews() {
        return $this->hasMany(BookReview::class, 'category_id', 'id');
    }
}
