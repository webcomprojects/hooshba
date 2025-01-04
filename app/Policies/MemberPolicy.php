<?php

namespace App\Policies;

use App\Models\Member;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MemberPolicy
{
    public function viewAny(User $user)
    {
        return $user->hasmemberTo('members');
    }

    public function view(User $user, Member $member)
    {
        return $user->hasmemberTo('view-members');
    }

    public function create(User $user)
    {
        return $user->hasmemberTo('create-members');
    }

    public function update(User $user, Member $member)
    {
        return $user->hasmemberTo('update-members');
    }

    public function delete(User $user, Member $member)
    {
        return $user->hasmemberTo('delete-members');
    }
}
