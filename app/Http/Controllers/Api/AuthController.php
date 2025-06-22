<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules\Password as PasswordRule;

class AuthController extends Controller
{
    /**
     * Menangani permintaan registrasi dari API.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', PasswordRule::min(6)],
        ]);

        $user = User::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'user',
        ]);

        return response()->json(['success' => true, 'message' => 'Registrasi berhasil!', 'user' => $user], 201);
    }

    /**
     * Menangani permintaan login dari API.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate(['username' => 'required', 'password' => 'required']);

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Username atau password salah'], 401);
        }

        $user = User::where('username', $credentials['username'])->first();

        if ($user->role !== 'user') {
            Auth::logout(); // Pastikan logout jika role tidak sesuai
            return response()->json(['message' => 'Login untuk role ini hanya melalui halaman admin'], 403);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['user' => $user, 'token' => $token]);
    }

    /**
     * Menangani permintaan logout dari API.
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logout berhasil']);
    }

    /**
     * Menangani permintaan Lupa Password dari API.
     */
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json(['message' => 'Link reset password telah dikirim ke email Anda!']);
        }

        // Gunakan pesan dari $status untuk error yang lebih spesifik jika perlu
        return response()->json(['message' => 'Kami tidak dapat menemukan pengguna dengan alamat email tersebut.'], 422);
    }
}