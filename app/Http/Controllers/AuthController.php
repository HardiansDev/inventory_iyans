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
        // Validasi input
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Coba login
        if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']])) {
            // Redirect ke halaman dashboard jika berhasil login
            return redirect()->intended('dashboard');
        }

        // Jika login gagal, kembali ke halaman login dengan pesan kesalahan
        return redirect()->route('login')->with('error', 'Email atau password salah, atau belum terdaftar.');
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
            'role' => 'required|in:kasir,manager,superadmin,admin_gudang', // Validasi role
        ]);

        // Membuat user baru dengan password yang di-hash dan role yang dipilih
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']), // Meng-hash password
            'role' => $validated['role'], // Role yang dipilih saat registrasi
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
