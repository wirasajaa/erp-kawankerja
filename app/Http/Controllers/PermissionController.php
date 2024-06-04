<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function index()
    {
        $this->authorize('view', Permission::class);
        $permissions = Permission::get()->load('roles');
        return view('permissions.index', compact('permissions'));
    }
    public function create()
    {
        $this->authorize('create', Permission::class);
        return view('permissions.create');
    }
    public function store(PermissionRequest $req)
    {
        $this->authorize('create', Permission::class);
        try {
            Permission::create($req->validated());
            return redirect()->route('permissions')->with('system_success', 'New permission has added');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->withErrors(['system_error' => systemMessage('Create new permission is failed', $th->getMessage())]);
        }
    }
    public function edit(Permission $permission)
    {
        $this->authorize('update', Permission::class);

        return view('permissions.edit', compact('permission'));
    }
    public function update(PermissionRequest $req, Permission $permission)
    {
        $this->authorize('update', Permission::class);
        try {
            $permission->update($req->validated());
            return redirect()->route('permissions')->with('system_success', 'Permission has updated');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->withErrors(['system_error' => systemMessage('Update permission is failed', $th->getMessage())]);
        }
    }
    public function destroy(Permission $permission)
    {
        $this->authorize('delete', Permission::class);
        try {
            DB::table('role_has_permissions')->where('permission_id', $permission->id)->delete();
            $permission->delete();
            return redirect()->route('permissions')->with('system_success', 'Permission data has deleted');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->withErrors(['system_error' => systemMessage('Delete permission data is failed', $th->getMessage())]);
        }
    }
}
