<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PostPolicy
{
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('posts');
    }

    public function view(User $user, Post $post)
    {
        return $user->hasPermissionTo('view-posts');
    }

    public function create(User $user)
    {
        return $user->hasPermissionTo('create-posts');
    }

    public function update(User $user, Post $post)
    {
        return $user->hasPermissionTo('update-posts');
    }

    public function delete(User $user, Post $post)
    {
        return $user->hasPermissionTo('delete-posts');
    }
}
