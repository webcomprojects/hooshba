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
        return $user->hasPermissionTo('posts.view');
    }

    public function create(User $user)
    {
        return $user->hasPermissionTo('posts.create');
    }

    public function update(User $user, Post $post)
    {
        return $user->hasPermissionTo('posts.update');
    }

    public function delete(User $user, Post $post)
    {
        return $user->hasPermissionTo('posts.delete');
    }
}
