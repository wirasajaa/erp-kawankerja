<?php

namespace App\Policies;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Gate;

class EmployeePolicy
{

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        return $user->hasAnyPermission('view-employee') || Gate::any(['is-admin', 'is-hr']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Employee $employee): bool
    {
        return $user->hasAnyPermission('create-employee') || Gate::any(['is-admin', 'is-hr']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Employee $employee): bool
    {
        return $user->hasAnyPermission('update-employee') || Gate::any(['is-admin', 'is-hr']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Employee $employee): bool
    {
        return $user->hasAnyPermission('delete-employee') || Gate::any(['is-admin', 'is-hr']);
    }
}
