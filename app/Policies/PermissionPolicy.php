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
        return $user->hasPermissionTo('view-permissions');
    }

    public function create(User $user)
    {
        return $user->hasPermissionTo('create-permissions');
    }

    public function update(User $user, Permission $permission)
    {
        return $user->hasPermissionTo('update-permissions');
    }

    public function delete(User $user, Permission $permission)
    {
        return $user->hasPermissionTo('delete-permissions');
    }
}
