<?php

namespace App\Policies;


use App\Models\User;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if ($user->user_role === 1) {
            return true;
        }
        if ($user->user_role > 1 && $user->user_role <= 3) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        return false;
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
    public function update(User $user, User $model): bool
    {
        if ($user->user_role === 1) {
            return true; // Allow update if the user is an admin
        } else {
            return false; // Deny update for non-admin users
        };
    }


    public function roleUpdate(User $user, User $model): bool
    {
        if ($user->user_role === 1) {
            return true; // Allow update if the user is an admin
        } else if ($user->user_role === 2) {
            return true; // Allow update if the user is an ambassador
        } else {
            return false; // Deny update for non-admin and non-ambassador users
        };
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        // epxplain to whole thing ...
        //First parameter $user → Laravel automatically injects the currently logged-in user.
        //Second parameter $model → Laravel expects an instance of the model you want to act on (in this case, a User object).
        //So Laravel is saying:
        //“Tell me which User record you want to delete, so I can check if the logged-in user has permission over it.”

        if ($user->user_role === 1) {
            return true; // Allow deletion if the user is an admin
        } else {
            return false; // Deny deletion for non-admin users
        };
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, User $model): bool
    {
        return false;
    }
}
