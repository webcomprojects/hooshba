<?php

namespace App\Models;

use App\Traits\Taggable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory, HasUuids,Taggable;

    protected $fillable = [
        'title',
        'content',
        'slug',
        'user_id',
        'province_id',
        'featured_image',
        'meta_title',
        'meta_description',
        'video',
        'is_published',
        'published_at',
    ];

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }


    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }


    public function scopeDraft($query)
    {
        return $query->where('is_published', false);
    }


    public function scopeSinglePostPublished($query, $slug)
    {
        return $query
            ->where('slug', $slug)
            ->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }
}
