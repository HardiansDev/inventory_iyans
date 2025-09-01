<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Tampilkan form login/register
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user());
        }

        // Buat angka random untuk captcha
        $a = rand(1, 9);
        $b = rand(1, 9);

        // Simpan pertanyaan dan jawabannya di session
        session([
            'captcha_question' => "$a + $b",
            'captcha_answer' => $a + $b,
        ]);

        // Cek apakah sudah ada Super Admin
        $superadminExists = \App\Models\User::where('role', 'superadmin')->exists();

        return view('auth.form', compact('superadminExists'));
    }

    // Proses login
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'captcha_answer' => 'required|numeric',
        ]);

        // Cek jawaban captcha
        if ((int)$validated['captcha_answer'] !== session('captcha_answer')) {
            return back()->with('error', 'Jawaban captcha salah.')->withInput();
        }

        // Coba login
        if (Auth::attempt(['email' => $validated['email'], 'password' => $validated['password']])) {
            $user = Auth::user();

            // Catat ke log
            activity_log('login', "User {$user->name} berhasil login.");

            return $this->redirectByRole($user);
        }

        // Catat login gagal
        activity_log('login_failed', "Login gagal untuk email {$validated['email']}.");

        return back()->with('error', 'Email atau password salah, atau belum terdaftar.');
    }

    public function showRegister()
    {
        $superadminExists = User::where('role', 'superadmin')->exists();
        return view('auth.form', compact('superadminExists'));
    }

    // Proses registrasi
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:kasir,manager,superadmin,admin_gudang',
        ]);

        if ($validated['role'] === 'superadmin' && User::where('role', 'superadmin')->exists()) {
            return back()->withErrors([
                'role' => 'Role Super Admin sudah digunakan dan tidak bisa dipilih lagi.'
            ])->withInput();
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        // Catat ke log
        activity_log('register', "User {$user->name} berhasil registrasi sebagai {$user->role}.");

        return redirect()->route('login')->with('success', 'Registrasi berhasil.');
    }

    // Logout
    public function logout(Request $request)
    {
        $user = Auth::user();

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Catat ke log
        if ($user) {
            activity_log('logout', "User {$user->name} telah logout.");
        }

        return redirect('/login')->with('status', 'Anda telah logout.');
    }

    // Redirect berdasarkan role pengguna
    public function redirectByRole($user)
    {
        return match ($user->role) {
            'admin_gudang' => redirect()->route('productin.index'),
            'kasir' => redirect()->route('sales.index'),
            'superadmin', 'manager' => redirect()->route('dashboard'),
            default => redirect()->route('login')->with('error', 'Peran tidak dikenali.')
        };
    }
}
