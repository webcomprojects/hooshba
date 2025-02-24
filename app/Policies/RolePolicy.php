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
        return $user->hasPermissionTo('roles.view');
    }

    public function create(User $user)
    {
        return $user->hasPermissionTo('roles.create');
    }

    public function update(User $user, Role $role)
    {
        return $user->hasPermissionTo('roles.update');
    }

    public function delete(User $user, Role $role)
    {
        return $user->hasPermissionTo('roles.delete');
    }
}
