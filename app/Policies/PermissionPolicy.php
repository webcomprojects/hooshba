<?php

namespace App\Policies;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PermissionPolicy
{
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('permissions');
    }

    public function view(User $user, Permission $permission)
    {
        return $user->hasPermissionTo('permissions.view');
    }

    public function create(User $user)
    {
        return $user->hasPermissionTo('permissions.create');
    }

    public function update(User $user, Permission $permission)
    {
        return $user->hasPermissionTo('permissions.update');
    }

    public function delete(User $user, Permission $permission)
    {
        return $user->hasPermissionTo('permissions.delete');
    }
}
