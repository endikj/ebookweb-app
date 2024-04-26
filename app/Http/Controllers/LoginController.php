<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate(
            [
                'username' => 'required',
                'password' => 'required',
            ],
            [
                'username.required' => 'username tidak boleh kosong',
                'password.required' => 'password tidak boleh kosong',
            ]
        );

        $credential = $request->only('username', 'password');
        if (Auth::attempt($credential)) {
            $request->session()->regenerate();

            $user = Auth::user();
            if ($user->role == '1' || $user->role == '2') {
                return redirect()->intended('dashboard');
            } elseif ($user->role == '3') {
                return redirect()->intended('home');
            } else {
                Auth::logout();
                return redirect()->intended('login')->with('error', 'Role tidak valid. Silakan login kembali.');
            }
        } else {
            return redirect()->intended('login')->with('error', 'Username atau password salah.');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
