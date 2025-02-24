<?php

namespace App\Policies;

use App\Models\Committee;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CommitteePolicy
{
    public function viewAny(User $user)
    {
        return $user->hascommitteeTo('committees');
    }

    public function view(User $user, Committee $committee)
    {
        return $user->hascommitteeTo('committees.view');
    }

    public function create(User $user)
    {
        return $user->hascommitteeTo('committees.create');
    }

    public function update(User $user, Committee $committee)
    {
        return $user->hascommitteeTo('committees.update');
    }

    public function delete(User $user, Committee $committee)
    {
        return $user->hascommitteeTo('committees.delete');
    }
}
