<?php

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Gate;

class ProjectPolicy
{

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        return $user->hasAnyPermission('view-project') || Gate::any(['is-admin', 'is-hr', 'is-pm']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyPermission('create-project') || Gate::any(['is-admin', 'is-hr']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        return $user->hasAnyPermission('update-project') || Gate::any(['is-admin', 'is-hr']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
        return $user->hasAnyPermission('delete-project') || Gate::any(['is-admin', 'is-hr']);
    }
}
