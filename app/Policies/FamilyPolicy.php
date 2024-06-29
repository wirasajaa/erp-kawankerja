<?php

namespace App\Policies;

use App\Models\Family;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Gate;

class FamilyPolicy
{

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Family $family): bool
    {
        return $user->hasAnyPermission('view-family') || Gate::any(['is-admin', 'is-hr']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, $employee_id): bool
    {
        // return Gate::any(['is-admin', 'is-hr']) || $user->hasAnyPermission('create-family') && $user->employee_id == $employee_id;
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Family $family): bool
    {
        return $user->hasAnyPermission('update-family') && $user->employee_id == $family->employee_id || Gate::any(['is-admin', 'is-hr']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Family $family): bool
    {
        return $user->hasAnyPermission('delete-family') && $user->employee_id == $family->employee_id || Gate::any(['is-admin', 'is-hr']);
    }
}
