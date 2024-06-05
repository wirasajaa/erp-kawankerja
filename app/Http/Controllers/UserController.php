<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public $role, $employee;
    public function __construct(Role $role, Employee $employee)
    {
        $this->role = $role;
        $this->employee = $employee;
    }
    private function deleteRole($user_id)
    {
        DB::table('model_has_roles')->where('model_ulid', $user_id)->delete();
    }
    public function index()
    {
        $this->authorize('view', User::class);
        if (Gate::any(['super-admin', 'manage-trash-user'])) {
            $users = User::with('roles')->withTrashed()->get();
        } else {
            $users = User::with('roles')->get();
        }
        return view('users.index', compact('users'));
    }
    public function create()
    {
        $this->authorize('create', User::class);
        $employee_options = $this->employee->getEmployeeOptions();
        $role_options = $this->role->all()->pluck('name');
        return view('users.create', compact('role_options', 'employee_options'));
    }
    public function store(UserRequest $req)
    {
        $this->authorize('create', User::class);
        $validated = $req->validated();
        DB::beginTransaction();
        try {
            $validated['created_by'] = auth()->user()->id;
            if ($req->password == null) {
                $validated['password'] = config('app.default_password');
            }
            $user = User::create($validated);
            $user->assignRole($req->role_name);
            Employee::find($req->employee_id)->update([
                'nip' => getNip()
            ]);
            DB::commit();
            return redirect()->route('users')->with('system_success', 'Account has created');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['system_error' => systemMessage('Create new account is failed', $th->getMessage())]);
        }
    }
    public function edit($username)
    {
        $this->authorize('edit', User::class);
        $role_options = $this->role->all()->pluck('name');
        $employee_options = $this->employee->getEmployeeOptions();
        $user = User::with('roles')->where('username', $username)->firstOrFail();
        return view('users.edit', compact('user', 'role_options', 'employee_options'));
    }
    public function update(UserRequest $req, User $user)
    {
        $this->authorize('update', [$user]);
        $validated = $req->validated();
        DB::beginTransaction();
        try {
            $validated['updated_by'] = auth()->user()->id;
            if ($req->password == null) {
                unset($validated['password']);
            }
            $user->update($validated);
            $this->deleteRole($user->id);
            $user->assignRole($req->role_name);
            DB::commit();
            return redirect()->route('users')->with('system_success', 'Account has updated');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['system_error' => systemMessage('Update account is failed', $th->getMessage())]);
        }
    }
    public function destroy(User $user)
    {
        $this->authorize('delete', User::class);
        try {
            $validated['deleted_by'] = auth()->user()->id;
            $user->update($validated);
            $user->delete();
            return redirect()->route('users')->with('system_success', 'Account has deleted');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->withErrors(['system_error' => systemMessage('Delete account is failed', $th->getMessage())]);
        }
    }
    public function destroyPermanent($user)
    {
        $this->authorize('forceDelete', User::class);
        $user = User::withTrashed()->findOrFail($user);
        DB::beginTransaction();
        try {
            $user->forceDelete();
            $this->deleteRole($user->id);
            DB::commit();
            return redirect()->route('users')->with('system_success', 'Account has deleted permanently');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors(['system_error' => systemMessage('Delete account is failed', $th->getMessage())]);
        }
    }
    public function restore($user)
    {
        $this->authorize('restore', User::class);
        $user = User::withTrashed()->findOrFail($user);
        try {
            $user->restore();
            $user->update(['updated_by' => auth()->user()->id]);
            return redirect()->route('users')->with('system_success', 'Account has restored');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->withErrors(['system_error' => systemMessage('Restore account is failed', $th->getMessage())]);
        }
    }
}
