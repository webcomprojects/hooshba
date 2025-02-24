<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $User)
    {
        return $User->can('users.index');
    }

    public function view(User $User, User $model)
    {
        return $User->can('users.view');
    }

    public function create(User $User)
    {
        return $User->can('users.create');
    }

    public function update(User $User, User $model)
    {
        return $User->can('users.update') && ($model->level != 'creator');
    }

    public function delete(User $User, User $model)
    {
        return $User->can('users.delete') && ($model->level != 'creator');
    }
}
