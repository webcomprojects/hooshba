<?php

namespace App\Models;

use App\Traits\Taggable;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory, HasUuids,Taggable,Sluggable;

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

    public function sluggable() : array
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

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

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    protected $appends = ['post_tags'];
      protected $hidden = ['tags'];

    public function getPostTagsAttribute()
    {
        return $this->tags->pluck('name');
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
