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
        return $user->hascategoryTo('categories.view');
    }

    public function create(User $user)
    {
        return $user->hascategoryTo('categories.create');
    }

    public function update(User $user, Category $category)
    {
        return $user->hascategoryTo('categories.update');
    }

    public function delete(User $user, Category $category)
    {
        return $user->hascategoryTo('categories.delete');
    }
}
