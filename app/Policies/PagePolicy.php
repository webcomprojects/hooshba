<?php

namespace App\Policies;

use App\Models\Page;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PagePolicy
{
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('pages');
    }

    public function view(User $user, Page $page)
    {
        return $user->hasPermissionTo('pages.view');
    }

    public function create(User $user)
    {
        return $user->hasPermissionTo('pages.create');
    }

    public function update(User $user, Page $page)
    {
        return $user->hasPermissionTo('pages.update');
    }

    public function delete(User $user, Page $page)
    {
        return $user->hasPermissionTo('pages.delete');
    }
}