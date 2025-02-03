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
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Cari user berdasarkan username
        $user = User::where('user_nama', $request->username)->first();

        // Cek apakah user ditemukan
        if (!$user || !Hash::check($request->password, $user->user_pass)) {
            return back()->withErrors(['login' => 'Username atau password salah!']);
        }

        // Login user
        Auth::login($user);

        // Redirect berdasarkan user_hak
        return $this->redirectBasedOnRole($user->user_hak);
    }

    private function redirectBasedOnRole($role)
    {
        $routes = [
            'admin'    => 'dashboard.admin',
            'su'       => 'su.dashboard.super.user',
            'operator' => 'dashboard.operator',
        ];

        return isset($routes[$role])
            ? redirect()->route($routes[$role])
            : redirect()->route('login')->withErrors(['role' => 'Role tidak dikenali.']);
    }

    public function logout()
    {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/login');
    }
}
