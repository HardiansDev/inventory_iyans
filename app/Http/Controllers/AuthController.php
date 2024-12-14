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
        // Cek apakah pengguna sudah login
        if (Auth::check()) {
            // Ambil pengguna yang sedang login
            $user = Auth::user();

            // Redirect berdasarkan peran pengguna
            switch ($user->role) {
                case 'admin_gudang':
                    return redirect()->route('product.index'); // Ganti dengan route untuk view produk
                case 'kasir':
                    return redirect()->route('product-out.index'); // Ganti dengan route untuk view customer
                case 'superadmin':
                case 'manager':
                    return redirect()->route('dashboard'); // Ganti dengan route untuk dashboard
                default:
                    // Jika peran tidak dikenali, logout pengguna dan kembali ke login dengan pesan error
                    Auth::logout();
                    return redirect()->route('login')->with('error', 'Peran tidak dikenali.');
            }
        }

        // Validasi input
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Coba login
        if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']])) {
            // Ambil pengguna yang sedang login
            $user = Auth::user();

            // Redirect berdasarkan peran pengguna
            switch ($user->role) {
                case 'admin_gudang':
                    return redirect()->route('product.index'); // Ganti dengan route untuk view produk
                case 'kasir':
                    return redirect()->route('product-out.index'); // Ganti dengan route untuk view customer
                case 'superadmin':
                case 'manager':
                    return redirect()->route('dashboard'); // Ganti dengan route untuk dashboard
                default:
                    // Jika peran tidak dikenali, logout pengguna dan kembali ke login dengan pesan error
                    Auth::logout();
                    return redirect()->route('login')->with('error', 'Peran tidak dikenali.');
            }
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

        return redirect('/login')->with('status', 'Anda telah logout.');
    }
}
