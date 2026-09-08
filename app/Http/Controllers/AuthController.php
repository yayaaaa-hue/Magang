<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Tampilkan Halaman Login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Proses Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Redirect langsung menggunakan named routes
            if ($user->role === 'admin_master' || $user->role === 'admin') {
                return redirect()->route('admin.aset');
            } elseif ($user->role === 'mahasiswa') {
                return redirect()->route('mahasiswa.dashboard');
            } elseif ($user->role === 'pegawai') {
                return redirect()->route('pegawai.dashboard');
            }

            return redirect('/');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan salah.',
        ])->onlyInput('email');
    }

    // Tampilkan Halaman Register
    public function showRegister()
    {
        return view('auth.register');
    }

    // Proses Register
    public function register(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'role' => ['required', 'in:mahasiswa,pegawai'],
            
            // Dynamic fields per role
            'nim' => ['nullable', 'required_if:role,mahasiswa', 'string', 'max:50'],
            'universitas' => ['nullable', 'required_if:role,mahasiswa', 'string', 'max:150'],
            'jurusan' => ['nullable', 'required_if:role,mahasiswa', 'string', 'max:100'],
            
            'nip' => ['nullable', 'required_if:role,pegawai', 'string', 'max:50'],
            'unit_kerja' => ['nullable', 'required_if:role,pegawai', 'string', 'max:150'],
            'jabatan' => ['nullable', 'required_if:role,pegawai', 'string', 'max:100'],
        ]);

        if ($validated['role'] === 'mahasiswa') {
            $instansi = $validated['universitas'] . ($validated['jurusan'] ? ' (' . $validated['jurusan'] . ')' : '');
        } else {
            $instansi = $validated['unit_kerja'] . ($validated['jabatan'] ? ' - ' . $validated['jabatan'] : '') . ($validated['nip'] ? ' (NIP: ' . $validated['nip'] . ')' : '');
        }

        $user = User::create([
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'instansi_bidang' => $instansi,
        ]);

        Auth::login($user);

        if ($user->role === 'mahasiswa') {
            return redirect()->route('mahasiswa.dashboard')->with('success', 'Registrasi berhasil! Silakan lengkapi pendaftaran magang Anda.');
        }
        
        return redirect()->route('pegawai.dashboard')->with('success', 'Registrasi akun pegawai berhasil!');
    }

    // Proses Logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}