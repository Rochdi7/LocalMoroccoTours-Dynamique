<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;  // Corrected import

class Post extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'quote',
        'content',
        'status',
        'author_id',
        'category_id',
        'published_at',
    ];

     protected $casts = [
        'published_at' => 'datetime', 
    ];
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    // Define the media conversion for 'thumb'
    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(150)  // Adjust width as needed
            ->height(150)
            ->sharpen(10);  // Optional: sharpen the image
    }

    // Accessor for featured image URL
    public function getFeaturedImageUrlAttribute()
    {
        $media = $this->getFirstMedia('featured_image');
        return $media
            ? $media->getUrl()  // Get the original image URL instead of 'thumb'
            : asset('img/blogCards/placeholder.jpg');  // Fallback to placeholder image
    }
}
