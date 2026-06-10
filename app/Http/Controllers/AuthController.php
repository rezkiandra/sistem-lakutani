<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

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
                return redirect()->route('admin.dashboard')->with('success', 'Selamat datang, '.Auth::user()->name);
            }

            return redirect()->route('petani.dashboard')->with('success', 'Selamat datang, '.Auth::user()->name);
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

    public function edit()
    {
        $user = Auth::user();

        return view('pengaturan', compact('user')); // Sesuaikan dengan folder view kamu
    }

    // Memproses update data
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validasi input
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'], // 'confirmed' otomatis mengecek field password_confirmation
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan oleh pengguna lain.',
            'password.min' => 'Password minimal harus 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        // Update Nama dan Email
        $user->name = $request->name;
        $user->email = $request->email;

        // Jika password diisi, enkripsi lalu update
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Kembalikan ke halaman dengan status sukses (bisa ditangkap SweetAlert / Alert bawaan)
        return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui!');
    }
}
