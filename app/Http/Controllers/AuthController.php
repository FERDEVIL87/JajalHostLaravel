<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password; // <-- Pastikan ini di-import

class AuthController extends Controller
{
    // Menampilkan halaman registrasi
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Memproses registrasi
    public function register(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            // Aturan 'unique' untuk password sudah dihapus
            'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::min(6)],
        ]);

        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        return redirect()->route('login')->with('status', 'Registrasi admin berhasil! Silakan login.');
    }

    // Menampilkan halaman login
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard');
        }
        return view('auth.login');
    }

    // Memproses login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->role === 'admin') {
                $request->session()->regenerate();
                return redirect()->intended('dashboard');
            } else {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return back()->withErrors(['username' => 'Akses ditolak. Hanya admin yang dapat login di sini.'])->onlyInput('username');
            }
        }

        return back()->withErrors(['username' => 'Username atau password salah.'])->onlyInput('username');
    }

    // Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    /**
     * ==========================================================
     * TAMBAHKAN METODE INI
     * ==========================================================
     * Menangani permintaan Lupa Password dari API.
     */
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        // Mengirim link reset password menggunakan mekanisme bawaan Laravel
        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['message' => 'Link reset password telah dikirim ke email Anda!']);
        }

        // Jika email tidak ditemukan atau ada error lain
        return response()->json(['message' => 'Kami tidak dapat menemukan pengguna dengan alamat email tersebut.'], 422);
    }
    // ==========================================================
}