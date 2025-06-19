<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            // Sudah login, arahkan sesuai role
            $user = Auth::user();
            if ($user->role_id == 1) {
                return redirect('/users');
            } elseif ($user->role_id == 2) {
                return redirect('/class');
            } elseif ($user->role_id == 3) {
                return redirect('/absene');
            }
        }

        // Belum login, tampilkan form login
        return view('auth.login');
    }

    public function verify(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('web')->attempt(['email' => $data['email'], 'password' => $data['password'], 'role_id' => '1'])) {
            $request->session()->regenerate();
            return redirect()->intended('/users');
        }

        if (Auth::guard('web')->attempt(['email' => $data['email'], 'password' => $data['password'], 'role_id' => '2'])) {
            $request->session()->regenerate();
            return redirect()->intended('/class');
        }

        if (Auth::guard('web')->attempt(['email' => $data['email'], 'password' => $data['password'], 'role_id' => '3'])) {
            $request->session()->regenerate();
            return redirect()->intended('/absen');
        }

        return back()->with('loginError', 'Email or password is incorrect.');
    }

    public function logout(Request $request)
    {
        if (Auth::guard('1')->check()) {
            Auth::guard('1')->logout();
        } else if (Auth::guard('2')->check()) {
            Auth::guard('2')->logout();
        }
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
