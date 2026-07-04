<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostCommentRating extends Model
{
    protected $fillable = [
        'post_comment_id',
        'rating_category_id',
        'score',
    ];

    public function comment()
    {
        return $this->belongsTo(PostComment::class, 'post_comment_id');
    }

    public function category()
    {
        return $this->belongsTo(RatingCategory::class, 'rating_category_id');
    }
}
