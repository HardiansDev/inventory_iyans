<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Menampilkan form login
    public function showLogin()
    {
        return view('auth.form'); // Menampilkan form login/register
    }

    // Melakukan login
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        // Cek kredensial dan login
        if (Auth::attempt($credentials)) {
            return redirect()->route('dashboard'); // Halaman default setelah login
        }

        // Jika login gagal
        return redirect()->route('login')->with('error', 'Invalid credentials.');
    }

    // Menampilkan form registrasi
    public function showRegister()
    {
        return view('auth.form'); // Menampilkan form login/register
    }

    // Melakukan registrasi
    public function register(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email', // Pastikan email unik
            'password' => 'required|min:8|confirmed', // Validasi konfirmasi password
        ]);

        // Membuat user baru dengan password yang di-hash
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']), // Meng-hash password
            'role' => 'user', // Default role 'user'
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil, silakan login.');
    }

    // Melakukan logout
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
