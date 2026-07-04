<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Location extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'seo_alt',
        'seo_caption',
        'seo_description',
    ];

    public function tours()
    {
        return $this->hasMany(Tour::class);
    }

    /**
     * Register the media collections.
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('locations')
            ->singleFile(); // Only one image per location
    }

    /**
     * Register media conversions (e.g. thumb).
     */
    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(300)
            ->height(300)
            ->sharpen(10)
            ->nonQueued();
    }

    /**
     * Helper accessor for image URL with fallback.
     */
    public function getImageUrlAttribute(): string
    {
        return $this->getFirstMediaUrl('locations') ?: asset('img/locations/default.jpg');
    }
}
