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
        return $user->hasPermissionTo('regions.view');
    }

    public function create(User $user)
    {
        return $user->hasPermissionTo('regions.create');
    }

    public function update(User $user, Region $region)
    {
        return $user->hasPermissionTo('regions.update');
    }

    public function delete(User $user, Region $region)
    {
        return $user->hasPermissionTo('regions.delete');
    }
}
