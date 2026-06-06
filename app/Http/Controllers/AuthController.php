<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function signIn(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Email tidak valid',
            'password.required' => 'Password wajib diisi',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Redirect sesuai role
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Selamat datang, ' . Auth::user()->name);
            }

            return redirect()->route('petani.dashboard')->with('success', 'Selamat datang, ' . Auth::user()->name);
        }

        return back()->withErrors(['email' => 'Email atau password salah'])->onlyInput('email');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function signUp(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:users,name',
            'email' => 'required|email',
            'password' => 'required|confirmed',
        ], [
            'required' => ':attribute wajib diisi',
            'unique' => ':attribute sudah terdaftar',
            'email' => ':attribute tidak valid',
            'confirmed' => ':attribute tidak cocok',
        ], [
            'name' => 'Username',
            'email' => 'Email',
            'password' => 'Password',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'petani',
        ]);

        return redirect()->route('login')->with('success', 'Berhasil mendaftar, silahkan login');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Logout berhasil, Terima kasih');
    }
}
