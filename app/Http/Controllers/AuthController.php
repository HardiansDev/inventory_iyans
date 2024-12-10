<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.form'); // Menampilkan form login/register
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $role = Auth::user()->role;

            // Redirect based on user role
            switch ($role) {
                case 'superadmin':
                    return redirect()->route('dashboard'); // Halaman dashboard
                case 'kasir':
                    return redirect()->route('customer.index'); // Halaman customer
                case 'admin_gudang':
                    return redirect()->route('product.index'); // Halaman produk
                case 'manager':
                    return redirect()->route('dashboard'); // Atau halaman lain untuk manager
                default:
                    Auth::logout();
                    return redirect()->route('login')->with('error', 'Role not assigned.');
            }
        }

        return redirect()->route('login')->with('error', 'Invalid credentials.');
    }

    public function showRegister()
    {
        return view('auth.form'); // Menampilkan form login/register
    }

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
            'role' => $request->role ?? 'user', // Default role 'user'
        ]);

        return redirect()->route('login')->with('success', 'Registrasi berhasil, silakan login.');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
