<?php

namespace App\Policies;

use App\Models\User;
use App\Models\University;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class UniversityPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->user_role === 1) {
            return true;
        }
        if ($user->user_role > 1 && $user->user_role <= 2) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, University $universities): bool
    {
        if ($user->user_role === 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if ($user->user_role === 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, University $universities): bool
    {
        if ($user->user_role === 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, University $universities): bool
    {
        if ($user->user_role === 1) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, University $universities): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, University $universities): bool
    {
        return false;
    }

    public function edit(User $user, University $universities): bool
    {
        if ($user->user_role === 1) {
            return true;
        } else {
            return false;
        }
    }
}
