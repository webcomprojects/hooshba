<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $guarded = ['id'];
    public $timestamps = false;

    public function permissionItems()
    {
        return $this->hasMany(Permission::class, 'permission_id', 'id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function permissions()
    {
        return $this->hasMany(Permission::class);
    }
    public static function findByName($name)
    {
        return static::where('name', $name)->firstOrFail();
    }

}
