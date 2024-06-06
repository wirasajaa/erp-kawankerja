<?php

namespace App\Policies;

use App\Models\MeetingSchedule;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class MeetingPolicy
{

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        return $user->hasAnyPermission('view-meeting') || Gate::any(['is-admin', 'is-hr', 'is-pm']);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyPermission('create-meeting') || Gate::any(['is-admin', 'is-hr', 'is-pm']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, MeetingSchedule $meeting): bool
    {
        return $user->hasAnyPermission('update-meeting') && $user->employee->id == $meeting->project->pic || Gate::any(['is-admin', 'is-hr', 'is-pm'], $meeting->project->pic);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, MeetingSchedule $meeting): bool
    {
        return $user->hasAnyPermission('delete-meeting') && $user->employee->id == $meeting->project->id || Gate::any(['is-admin', 'is-hr', 'is-pm'], $meeting->project->pic);
    }
    public function preview(User $user, MeetingSchedule $meeting): bool
    {
        return $user->hasAnyPermission('preview-meeting') && $user->employee->id == $meeting->project->id || Gate::any(['is-admin', 'is-hr', 'is-pm'], $meeting->project->pic);
    }
}
