<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect($this->dashboardForRole(Auth::user()->role));
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
            'role' => 'required|in:Admin,Staff',
        ]);

        $user = User::where('name', $request->username)
            ->orWhere('email', $request->username)
            ->first();

        if (! $user || ! $this->passwordMatches($user, $request->password)) {
            return back()->withErrors(['Invalid username or password.']);
        }

        if (($user->role ?? 'Staff') !== $request->role) {
            return back()->withErrors(['Selected role does not match this account.']);
        }

        if (! str_starts_with($user->password, '$2y$') && ! str_starts_with($user->password, '$argon2')) {
            $user->password = Hash::make($request->password);
            $user->save();
        }

        Auth::login($user);
        return redirect($this->dashboardForRole($user->role))->with('success', 'Welcome back, ' . $user->name . '!');
    }

    private function passwordMatches(User $user, string $password): bool
    {
        $storedPassword = $user->password;

        if (str_starts_with($storedPassword, '$2y$') || str_starts_with($storedPassword, '$argon2')) {
            return Hash::check($password, $storedPassword);
        }

        return hash_equals($storedPassword, $password);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('success', 'Logged out successfully.');
    }

    private function dashboardForRole($role)
    {
        return $role === 'Admin' ? '/admin/dashboard' : '/staff/dashboard';
    }
}
