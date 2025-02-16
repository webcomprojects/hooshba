<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'parent_id',
        'type',
        'slug',
    ];

    public function posts()
    {
        return $this->belongsToMany(Post::class);
    }
    public function members()
    {
        return $this->belongsToMany(Member::class);
    }

}
