<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class OrganizationChart extends Model
{
    use HasUuids;
    protected $fillable = [
        'name',
        'parent_id',
        'slug',
        'description',
        'ordering'
    ];

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }
}
