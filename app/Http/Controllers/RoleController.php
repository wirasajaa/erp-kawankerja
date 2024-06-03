<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public $role;
    public function __construct(Role $role)
    {
        $this->role = $role;
    }
    public function index()
    {
        $roles = $this->role->with('permissions')->get();
        return view('roles.index', compact('roles'));
    }
    public function create()
    {
        $permissions = config('authorization.permissions');
        return view('roles.create', compact('permissions'));
    }
    public function store(RoleRequest $req)
    {
        try {
            $role_data = [
                'name' => $req->name
            ];
            $role = Role::create($role_data);
            $role->givePermissionTo($req->permissions);
            return redirect()->route('roles')->with('system_success', 'New role has added');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->withErrors(['system_error' => systemMessage('Create new role is failed', $th->getMessage())]);
        }
    }
    public function edit($role)
    {
        $role = $this->role->findByName($role)->load('permissions');
        $role->permissions = collect($role->permissions)->pluck('name');
        $permissions = config('authorization.permissions');
        return view('roles.edit', compact('permissions', 'role'));
    }
    public function update(RoleRequest $req, $role)
    {
        try {
            $role = $this->role->findById($role)->load('permissions');
            $permission = collect($role->permissions)->pluck('name')->values()->all();

            $role_data = [
                'name' => $req->name
            ];
            $role->revokePermissionTo($permission);
            $role->update($role_data);
            $role->givePermissionTo($req->permissions);
            return redirect()->route('roles')->with('system_success', 'Role data has updated');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->withErrors(['system_error' => systemMessage('Update role data is failed', $th->getMessage())]);
        }
    }
    public function destroy($role)
    {
        try {
            $role = $this->role->findById($role)->load('permissions');
            $permission = collect($role->permissions)->pluck('name')->values()->all();

            $role->revokePermissionTo($permission);
            $role->delete();
            return redirect()->route('roles')->with('system_success', 'Role data has deleted');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->withErrors(['system_error' => systemMessage('Delete role data is failed', $th->getMessage())]);
        }
    }
}
