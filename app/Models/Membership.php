<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasUuids;
    protected $guarded = ['id'];

    public function educationHistories()
    {
        return $this->hasMany(EducationHistory::class);
    }

    public function jobHistories()
    {
        return $this->hasMany(JobHistory::class);
    }

}
