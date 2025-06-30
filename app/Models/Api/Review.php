<?php

namespace App\Models\Api;

use App\Models\Review as BaseReview;

class Review extends BaseReview
{
    protected $appends = ['book_title', 'cover_image_url'];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    // accessor virtual title
    public function getBookTitleAttribute()
    {
        return $this->book?->title ?? '';
    }

    // accessor virtual cover image
    public function getCoverImageUrlAttribute()
    {
        return $this->book?->cover_image_url ?? null;
    }
}
