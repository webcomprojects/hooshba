<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RolePolicy
{
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('roles');
    }

    public function view(User $user, Role $role)
    {
        return $user->hasPermissionTo('view-roles');
    }

    public function create(User $user)
    {
        return $user->hasPermissionTo('create-roles');
    }

    public function update(User $user, Role $role)
    {
        return $user->hasPermissionTo('update-roles');
    }

    public function delete(User $user, Role $role)
    {
        return $user->hasPermissionTo('delete-roles');
    }
}
