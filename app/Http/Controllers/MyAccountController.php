<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rules\Password;

class MyAccountController extends Controller
{
    public function index(User $user)
    {
        if (Gate::none(['is-owner'], $user->id)) {
            return redirect()->back()->withErrors(['system_error' => "You don\'t have enough access!"]);
        }
        return view('account.index', compact('user'));
    }
    public function changeProfile(Request $req, User $user)
    {
        if (Gate::none(['is-admin', 'is-owner'], $user->id)) {
            return redirect()->back()->withErrors(['system_error' => "You don\'t have enough access!"]);
        }
        $validated = $req->validate([
            'username' => 'required|min:3|alpha_dash|unique:users,username,' . $user->id,
            'email' => "required|unique:users,email," . $user->id
        ]);
        try {
            $user->update($validated);
            return redirect()->route('accounts', ['user' => $user->id])->with('system_success', 'Your profile information has updated');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->withErrors(['system_error' => setMessage($th->getMessage(), 'Failed to update profile information!')]);
        }
    }
    public function changePassword(Request $req, User $user)
    {
        if (Gate::none(['is-admin', 'is-owner'], $user->id)) {
            return redirect()->back()->withErrors(['system_error' => "You don\'t have enough access!"]);
        }
        $validated = $req->validate([
            'password' => ['nullable', 'confirmed', Password::min(7)->numbers()->letters()]
        ]);
        try {
            $user->update($validated);
            return redirect()->route('accounts', ['user' => $user->id])->with('system_success', 'Your password has updated');
        } catch (\Throwable $th) {
            return redirect()->back()->withInput()->withErrors(['system_error' => setMessage($th->getMessage(), 'Failed to update profile information!')]);
        }
    }
}
