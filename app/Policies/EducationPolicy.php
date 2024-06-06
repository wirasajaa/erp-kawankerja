<?php

namespace App\Policies;

use App\Models\Education;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Gate;

class EducationPolicy
{

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Education $education): bool
    {
        return $user->hasAnyPermission('view-education') || Gate::any(['is-admin', 'is-hr']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, $employee_id): bool
    {
        return $user->hasAnyPermission('create-education') && $user->employee_id == $employee_id || Gate::any(['is-admin', 'is-hr']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Education $education): bool
    {
        return $user->hasAnyPermission('update-education') && $user->employee_id == $education->employee_id || Gate::any(['is-admin', 'is-hr']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Education $education): bool
    {
        return $user->hasAnyPermission('delete-education') && $user->employee_id == $education->employee_id || Gate::any(['is-admin', 'is-hr']);
    }
}
