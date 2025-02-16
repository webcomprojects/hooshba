<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class JobHistory extends Model
{
    use HasUuids;

    protected $fillable = ['id', 'membership_id', 'company', 'position', 'start_year', 'end_year'];

    public $incrementing = false;
    protected $keyType = 'string';

    public function membership()
    {
        return $this->belongsTo(Membership::class, 'membership_id', 'id');
    }
}
