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
        return $user->hasPermissionTo('view-provinces');
    }

    public function create(User $user)
    {
        return $user->hasPermissionTo('create-provinces');
    }

    public function update(User $user, Province $province)
    {
        return $user->hasPermissionTo('update-provinces');
    }

    public function delete(User $user, Province $province)
    {
        return $user->hasPermissionTo('delete-provinces');
    }
}
