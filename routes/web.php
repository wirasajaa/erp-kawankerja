<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PermissionController;
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
});

require __DIR__ . '/auth.php';
