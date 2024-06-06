<?php

namespace App\Providers;

use App\Models\Certificate;
use App\Models\Education;
use App\Models\Employee;
use App\Models\Family;
use App\Models\MeetingSchedule;
use App\Models\Project;
use App\Models\User;
use App\Policies\CertificatePolicy;
use App\Policies\EducationPolicy;
use App\Policies\EmployeePolicy;
use App\Policies\FamilyPolicy;
use App\Policies\MeetingPolicy;
use App\Policies\PermissionPolicy;
use App\Policies\ProjectPolicy;
use App\Policies\RolePolicy;
use App\Policies\UserPolicy;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Role::class => RolePolicy::class,
        Permission::class => PermissionPolicy::class,
        Employee::class => EmployeePolicy::class,
        MeetingSchedule::class => MeetingPolicy::class,
        Family::class => FamilyPolicy::class,
        Certificate::class => CertificatePolicy::class,
        Education::class => EducationPolicy::class,
        Project::class => ProjectPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return config('app.frontend_url') . "/password-reset/$token?email={$notifiable->getEmailForPasswordReset()}";
        });

        Gate::define('is-admin', function (User $user) {
            return $user->hasAnyRole('admin');
        });
        Gate::define('is-hr', function (User $user) {
            return $user->hasAnyRole('human-resources');
        });
        Gate::define('is-pm', function (User $user, $pic = "") {
            return count($user->employee->pic) > 0 || $user->employee->id = $pic;
        });
    }
}
