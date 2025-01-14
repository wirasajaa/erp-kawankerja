<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Gate;

class UserPolicy
{

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        return $user->hasAnyPermission('view-user', 'super-admin');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyPermission('create-user', 'super-admin');
    }

    public function edit(User $user): bool
    {
        return $user->hasAnyPermission('super-admin', 'update-user');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        return $user->hasAnyPermission('update-user', 'super-admin') || $user->id == $model->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
        return $user->hasAnyPermission('delete-user', 'super-admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user): bool
    {
        return $user->hasAnyPermission('restore-user', 'super-admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user): bool
    {
        return $user->hasAnyPermission('delete-permanent-user', 'super-admin');
    }

    public function myAccount(User $user, $account)
    {
        return $user->id == $account->id;
    }
}
