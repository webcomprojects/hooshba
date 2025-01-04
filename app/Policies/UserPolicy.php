<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('users');
    }

    public function view(User $user, User $model)
    {
        return $user->hasPermissionTo('view-users');
    }

    public function create(User $user)
    {
        return $user->hasPermissionTo('create-users');
    }

    public function update(User $user, User $model)
    {
        return $user->hasPermissionTo('update-users');
    }

    public function delete(User $user, User $model)
    {
        return $user->hasPermissionTo('delete-users');
    }
}
