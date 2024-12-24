<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasUuids;
    protected $fillable = [
        'slug',
        'name',
        'type',
        'job_position',
        'email',
        'mobile',
        'image',
        'links',
        'description',
        'educational_background',
        'executive_background',
        'user_id',
        'ordering',
        'is_published',
        'published_at',
    ];



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




    public function scopeSingleMemberPublished($query, $slug)
    {
        return $query
            ->where('slug', $slug)
            ->where('is_published', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }
}
