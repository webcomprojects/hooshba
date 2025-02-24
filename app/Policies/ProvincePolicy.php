<?php

namespace App\Policies;

use App\Models\Province;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProvincePolicy
{
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('provinces');
    }

    public function view(User $user, Province $province)
    {
        return $user->hasPermissionTo('provinces.view');
    }

    public function create(User $user)
    {
        return $user->hasPermissionTo('provinces.create');
    }

    public function update(User $user, Province $province)
    {
        return $user->hasPermissionTo('provinces.update');
    }

    public function delete(User $user, Province $province)
    {
        return $user->hasPermissionTo('provinces.delete');
    }
}
