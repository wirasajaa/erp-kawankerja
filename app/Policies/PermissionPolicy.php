<?php

namespace App\Policies;

use App\Models\User;
use Spatie\Permission\Models\Permission;

class PermissionPolicy
{
    public function view(User $user)
    {
        return $user->hasAnyPermission('view-permission', 'super-admin');
    }
    public function create(User $user)
    {
        return $user->hasAnyPermission('create-permission', 'super-admin');
    }
    public function update(User $user)
    {
        return $user->hasAnyPermission('update-permission', 'super-admin');
    }
    public function delete(User $user)
    {
        return $user->hasAnyPermission('delete-permission', 'super-admin');
    }
}
