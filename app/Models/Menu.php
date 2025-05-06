<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory, HasUuids;
    protected $fillable = [
        'name',
        'parent_id',
        'link',
        'class_name',
        'ordering'
    ];

    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id');
    }
}
