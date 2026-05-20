<?php

namespace App\Policies;

use App\Models\Owner;
use App\Models\User;

class OwnerPolicy
{
    public function view(User $user, Owner $owner): bool
    {
        return $user->role === 'admin'
            || $owner->user_id === $user->id;
    }

    public function update(User $user, Owner $owner): bool
    {
        return $user->role === 'admin'
            || $owner->user_id === $user->id;
    }

    public function delete(User $user, Owner $owner): bool
    {
        return $user->role === 'admin'
            || $owner->user_id === $user->id;
    }
}
