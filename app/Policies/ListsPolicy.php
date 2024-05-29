<?php

namespace App\Policies;

use App\Models\Lists;
use App\Models\User;

class ListsPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Lists $lists): bool
    {
        return $user->id === $lists->author->id &&
            $user->tokenCan('read');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->tokenCan('create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Lists $lists): bool
    {
        return $user->id === $lists->author->id &&
            $user->tokenCan('update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Lists $lists): bool
    {
        return $user->id === $lists->author->id &&
            $user->tokenCan('delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Lists $lists): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Lists $lists): bool
    {
        return false;
    }
}
