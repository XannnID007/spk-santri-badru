<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pengguna;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100',
            'email' => 'required|email|unique:pengguna,email',
            'no_hp' => 'required|numeric|digits_between:10,15|unique:pengguna,no_hp',
            'password' => 'required|min:6|confirmed',
        ], [
            'nama.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'no_hp.required' => 'No HP wajib diisi',
            'no_hp.numeric' => 'No HP harus berupa angka',
            'no_hp.unique' => 'No HP sudah terdaftar',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $pengguna = Pengguna::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'password' => Hash::make($request->password),
            'role' => 'pendaftar',
        ]);

        // Log aktivitas
        LogAktivitas::create([
            'pengguna_id' => $pengguna->pengguna_id,
            'aktivitas' => 'Registrasi Akun',
            'deskripsi' => 'Pengguna baru mendaftar',
            'ip_address' => $request->ip(),
        ]);

        Auth::login($pengguna);

        return redirect()->route('pendaftar.dashboard')
            ->with('success', 'Registrasi berhasil! Silakan lengkapi profil Anda.');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Password wajib diisi',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Log aktivitas
            LogAktivitas::create([
                'pengguna_id' => $user->pengguna_id,
                'aktivitas' => 'Login',
                'deskripsi' => 'Pengguna login ke sistem',
                'ip_address' => $request->ip(),
            ]);

            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('pendaftar.dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        $user = Auth::user();

        // Log aktivitas
        LogAktivitas::create([
            'pengguna_id' => $user->pengguna_id,
            'aktivitas' => 'Logout',
            'deskripsi' => 'Pengguna logout dari sistem',
            'ip_address' => $request->ip(),
        ]);

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing');
    }
}
