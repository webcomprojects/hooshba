<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CategoryPolicy
{
    public function viewAny(User $user)
    {
        return $user->hascategoryTo('categories');
    }

    public function view(User $user, Category $category)
    {
        return $user->hascategoryTo('view-categories');
    }

    public function create(User $user)
    {
        return $user->hascategoryTo('create-categories');
    }

    public function update(User $user, Category $category)
    {
        return $user->hascategoryTo('update-categories');
    }

    public function delete(User $user, Category $category)
    {
        return $user->hascategoryTo('delete-categories');
    }
}
