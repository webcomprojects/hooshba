<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Member extends Model
{
    use HasFactory, HasUuids;
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

    protected $casts = [
        'educational_background' => 'array',  // تبدیل خودکار به آرایه
        'executive_background' => 'array',    // تبدیل خودکار به آرایه
        'links' => 'array',    // تبدیل خودکار به آرایه
        'job_position' => 'array',    // تبدیل خودکار به آرایه
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
