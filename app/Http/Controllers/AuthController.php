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

        return view('auth.form');
    }

    // Proses login
    public function login(Request $request)
    {
        // Validasi input termasuk captcha
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

            return $this->redirectByRole($user);
        }

        return back()->with('error', 'Email atau password salah, atau belum terdaftar.');
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

        // Simpan user ke variabel
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
        ]);

        // Kirim link verifikasi email
        $user->sendEmailVerificationNotification();

        return redirect()->route('login')->with('success', 'Registrasi berhasil. Silakan verifikasi email Anda sebelum login.');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

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
