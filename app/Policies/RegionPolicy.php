<?php

namespace App\Policies;

use App\Models\Region;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RegionPolicy
{
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('regions');
    }

    public function view(User $user, Region $region)
    {
        return $user->hasPermissionTo('view-regions');
    }

    public function create(User $user)
    {
        return $user->hasPermissionTo('create-regions');
    }

    public function update(User $user, Region $region)
    {
        return $user->hasPermissionTo('update-regions');
    }

    public function delete(User $user, Region $region)
    {
        return $user->hasPermissionTo('delete-regions');
    }
}
