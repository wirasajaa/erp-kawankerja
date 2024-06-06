<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Certificate;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Gate;

class CertificatePolicy
{

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Certificate $certificate): bool
    {
        return $user->hasAnyPermission('view-certificate') || Gate::any(['is-admin', 'is-hr']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyPermission('create-certificate') || Gate::any(['is-admin', 'is-hr']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Certificate $certificate): bool
    {
        return $user->hasAnyPermission('update-certificate') && $user->employee_id == $certificate->employee_id || Gate::any(['is-admin', 'is-hr']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Certificate $certificate): bool
    {
        return $user->hasAnyPermission('delete-certificate') && $user->employee_id == $certificate->employee_id || Gate::any(['is-admin', 'is-hr']);
    }
}
