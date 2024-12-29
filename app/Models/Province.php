<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $fillable = [
        'slug',
        'name',
        'ordering',
        'region_id',
        'is_published',
        'published_at',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function committees()
    {
        return $this->hasMany(Committee::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function members()
    {
        return $this->hasMany(User::class);
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


    public function scopeSingleProvincePublished($query, $slug)
    {
        return $query
            ->where('slug', $slug)
            ->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }
}
