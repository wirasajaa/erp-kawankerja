<?php

use App\Http\Controllers\Auth\RegistrationEmployeeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FamilyController;
use App\Http\Controllers\MeetingAbsenceController;
use App\Http\Controllers\MeetingScheduleController;
use App\Http\Controllers\MyAccountController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectEmployeeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [DashboardController::class, 'returnToDashboard']);
Route::prefix('registration')->middleware('guest')->group(function () {
    Route::get('/', [RegistrationEmployeeController::class, 'validateCodeForm'])->name('registration');
    Route::post('/code', [RegistrationEmployeeController::class, 'validateCode'])->name('register.code');
    Route::get('/employee', [RegistrationEmployeeController::class, 'registerEmployee'])->name('register.employee');
    Route::post('/employee/register', [EmployeeController::class, 'store'])->name('register.store');
});

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'login'])->name('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users');
        Route::get('/add-new-user-account', [UserController::class, 'create'])->name('users.create');
        Route::post('/store-account', [UserController::class, 'store'])->name('users.store');
        Route::get('/edit-user-account/{username}', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/update-user-account/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/delete-user-account/{user}', [UserController::class, 'destroy'])->name('users.delete');
        Route::delete('/delete-permanent-account/{user}', [UserController::class, 'destroyPermanent'])->name('users.delete.permanent');
        Route::put('/restore-account/{user}', [UserController::class, 'restore'])->name('users.restore');
    });
    Route::prefix('roles')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('roles');
        Route::get('/add-new-role', [RoleController::class, 'create'])->name('roles.create');
        Route::post('/store-role', [RoleController::class, 'store'])->name('roles.store');
        Route::get('/edit-role/{role}', [RoleController::class, 'edit'])->name('roles.edit');
        Route::put('/update-role/{role}', [RoleController::class, 'update'])->name('roles.update');
        Route::delete('/delete-role/{role}', [RoleController::class, 'destroy'])->name('roles.delete');
    });
    Route::prefix('permissions')->group(function () {
        Route::get('/', [PermissionController::class, 'index'])->name('permissions');
        Route::get('/add-new-permission', [PermissionController::class, 'create'])->name('permissions.create');
        Route::post('/store-permission', [PermissionController::class, 'store'])->name('permissions.store');
        Route::get('/edit-permission/{permission:name}', [PermissionController::class, 'edit'])->name('permissions.edit');
        Route::put('/update-permission/{permission}', [PermissionController::class, 'update'])->name('permissions.update');
        Route::delete('/delete-permission/{permission}', [PermissionController::class, 'destroy'])->name('permissions.delete');
    });

    Route::prefix('/account')->group(function () {
        Route::get('/{user:username}', [MyAccountController::class, 'index'])->name('accounts');
        Route::put('/{user}/profile', [MyAccountController::class, 'changeProfile'])->name('accounts.change-profile');
        Route::put('/{user}/password', [MyAccountController::class, 'changePassword'])->name('accounts.change-password');
    });
    Route::prefix('/employees')->group(function () {
        Route::get('/', [EmployeeController::class, 'index'])->name('employees');
        Route::get('/create', [EmployeeController::class, 'create'])->name('employees.create');
        Route::post('/store', [EmployeeController::class, 'store'])->name('employees.store');
        Route::get('/edit/{employee}', [EmployeeController::class, 'edit'])->name('employees.edit');
        Route::put('/update/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
        Route::delete('/delete/{employee}', [EmployeeController::class, 'destroy'])->name('employees.delete');

        Route::prefix('family')->group(function () {
            Route::get('/add-new', [FamilyController::class, 'create'])->name('family.create');
            Route::post('/store', [FamilyController::class, 'store'])->name('family.store');
            Route::get('/edit/{family}', [FamilyController::class, 'edit'])->name('family.edit');
            Route::put('/update/{family}', [FamilyController::class, 'update'])->name('family.update');
            Route::delete('/delete/{family}', [FamilyController::class, 'destroy'])->name('family.delete');
        });

        Route::prefix('educations')->group(function () {
            Route::get('/add-new', [EducationController::class, 'create'])->name('educations.create');
            Route::post('/store', [EducationController::class, 'store'])->name('educations.store');
            Route::get('/edit/{education}', [EducationController::class, 'edit'])->name('educations.edit');
            Route::put('/update/{education}', [EducationController::class, 'update'])->name('educations.update');
            Route::delete('/delete/{education}', [EducationController::class, 'destroy'])->name('educations.delete');
        });

        Route::prefix('certificates')->group(function () {
            Route::get('/add-new', [CertificateController::class, 'create'])->name('certificates.create');
            Route::post('/store', [CertificateController::class, 'store'])->name('certificates.store');
            Route::get('/edit/{certificate}', [CertificateController::class, 'edit'])->name('certificates.edit');
            Route::put('/update/{certificate}', [CertificateController::class, 'update'])->name('certificates.update');
            Route::delete('/delete/{certificate}', [CertificateController::class, 'destroy'])->name('certificates.delete');
        });
    });

    Route::prefix('/projects')->group(function () {
        Route::get('/', [ProjectController::class, 'index'])->name('projects');
        Route::get('/create', [ProjectController::class, 'create'])->name('projects.create');
        Route::post('/store', [ProjectController::class, 'store'])->name('projects.store');
        Route::get('/edit/{project}', [ProjectController::class, 'edit'])->name('projects.edit');
        Route::get('/preview/{project}', [ProjectController::class, 'preview'])->name('projects.preview');
        Route::get('/report/{project}', [ProjectController::class, 'report'])->name('projects.report');
        Route::put('/update/{project}', [ProjectController::class, 'update'])->name('projects.update');
        Route::delete('/delete/{project}', [ProjectController::class, 'destroy'])->name('projects.delete');

        Route::prefix('member')->group(function () {
            Route::get('/add-new', [ProjectEmployeeController::class, 'create'])->name('projects.employee.create');
            Route::post('/store', [ProjectEmployeeController::class, 'store'])->name('projects.employee.store');
            Route::get('/edit/{employee}', [ProjectEmployeeController::class, 'edit'])->name('projects.employee.edit');
            Route::put('/update/{employee}', [ProjectEmployeeController::class, 'update'])->name('projects.employee.update');
            Route::delete('/delete/{employee}', [ProjectEmployeeController::class, 'destroy'])->name('projects.employee.delete');
        });
    });

    Route::prefix('/meetings')->group(function () {
        Route::get('/', [MeetingScheduleController::class, 'index'])->name('meetings');
        Route::get('/set-schedule', [MeetingScheduleController::class, 'create'])->name('meetings.create');
        Route::post('/store/meeting', [MeetingScheduleController::class, 'store'])->name('meetings.store');
        Route::get('/preview/{meeting}', [MeetingScheduleController::class, 'preview'])->name('meetings.preview');
        Route::get('/previewonly/{meeting}', [MeetingScheduleController::class, 'previewOnly'])->name('meetings.preview-only');
        Route::get('/edit/{meeting}', [MeetingScheduleController::class, 'edit'])->name('meetings.edit');
        Route::put('/update/{meeting}', [MeetingScheduleController::class, 'update'])->name('meetings.update');
        Route::delete('/delete/{meeting}', [MeetingScheduleController::class, 'destroy'])->name('meetings.delete');
        Route::post('/absence', [MeetingAbsenceController::class, 'absence'])->name('meetings.absence');
    });
});

require __DIR__ . '/auth.php';
