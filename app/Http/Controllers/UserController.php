<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public $role;
    public function __construct(Role $role)
    {
        $this->role = $role;
    }
    private function deleteRole($user_id)
    {
        DB::table('model_has_roles')->where('model_ulid', $user_id)->delete();
    }
    public function index()
    {
        $this->authorize('view', User::class);
        if (auth()->user()->hasPermissionTo('manage-trash-user')) {
            $users = User::with('roles')->withTrashed()->get();
        } else {
            $users = User::with('roles')->get();
        }
        return view('users.index', compact('users'));
    }
    public function create()
    {
        $this->authorize('create-user', User::class);
        $role_options = $this->role->all()->pluck('name');
        return view('users.create', compact('role_options'));
    }
    public function store(UserRequest $req)
    {
        $this->authorize('create-user', User::class);
        $validated = $req->validated();
        try {
            $validated['created_by'] = auth()->user()->id;
            if ($req->password == null) {
                $validated['password'] = config('app.default_password');
            }
            $user = User::create($validated);
            $user->assignRole($req->role_name);
            return redirect()->route('users')->with('system_success', 'Account has created');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->withErrors(['system_error' => systemMessage('Create new account is failed', $th->getMessage())]);
        }
    }
    public function edit($username)
    {
        $this->any('edit-user', User::class);
        $role_options = $this->role->all()->pluck('name');
        $user = User::with('roles')->where('username', $username)->firstOrFail();
        return view('users.edit', compact('user', 'role_options'));
    }
    public function update(UserRequest $req, User $user)
    {
        $this->authorize('view', User::class);
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
        $this->authorize('delete-user', User::class);
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
        $this->authorize('delete-permanent-user', User::class);
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
        $this->authorize('restore-user', User::class);
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
