<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserMeta extends Model
{
    public function getValueAttribute($value)
    {
        return unserialize($value);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
