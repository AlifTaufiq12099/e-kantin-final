<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Penjual;
use App\Models\Lapak;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Show login form pembeli
     */
    public function showLoginPembeli()
    {
        return view('login-pembeli');
    }

    /**
     * Handle login pembeli
     */
    public function loginPembeli(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $email = $request->email;
        $password = $request->password;

        // Cek apakah variabel tersedia
        if (isset($email) && isset($password)) {
            // Coba autentikasi menggunakan guard default (users table)
            $credentials = ['email' => $email, 'password' => $password];
            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                session([
                    'user_id' => $user->id,
                    'username' => $user->name,
                    'role' => 'pembeli',
                    'logged_in' => true
                ]);

                return redirect()->route('pembeli.lapak.select')->with([
                    'key' => 'success',
                    'value' => 'Login berhasil!'
                ]);
            }

            // Email atau password salah
            return back()->with([
                'key' => 'error',
                'value' => 'Email atau Password salah!'
            ])->withInput();
        }

        // Form tidak lengkap
        return back()->with([
            'key' => 'error',
            'value' => 'Form tidak lengkap!'
        ]);
    }

    /**
     * Show login form penjual
     */
    public function showLoginPenjual()
    {
        return view('auth.login-penjual');
    }

    /**
     * Handle login penjual
     */
    public function loginPenjual(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $username = $request->username;
        $password = $request->password;

        // Cek apakah variabel tersedia
        if (isset($username) && isset($password)) {
            // Gunakan Laravel Auth guard 'penjual' untuk mencoba login
            $credentials = ['email' => $username, 'password' => $password];
            if (Auth::guard('penjual')->attempt($credentials)) {
                $penjual = Auth::guard('penjual')->user();
                session([
                    'user_id' => $penjual->penjual_id,
                    'username' => $penjual->nama_penjual,
                    'role' => 'penjual',
                    'lapak_id' => $penjual->lapak_id,
                    'logged_in' => true
                ]);

                return redirect()->to('/penjual/dashboard')->with([
                    'key' => 'success',
                    'value' => 'Login berhasil!'
                ]);
            }

            // Username atau password salah
            return back()->with([
                'key' => 'error',
                'value' => 'Email atau Password salah!'
            ]);
        }

        // Form tidak lengkap
        return back()->with([
            'key' => 'error',
            'value' => 'Form tidak lengkap!'
        ]);
    }

    /**
     * Show login form admin
     */
    public function showLoginAdmin()
    {
        return view('auth.login-admin');
    }

    /**
     * Handle login admin
     */
    public function loginAdmin(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $username = $request->username;
        $password = $request->password;

        // Cek apakah variabel tersedia
        if (isset($username) && isset($password)) {
            // Gunakan Laravel Auth guard 'admin' untuk mencoba login
            $credentials = ['username' => $username, 'password' => $password];
            if (Auth::guard('admin')->attempt($credentials)) {
                // Set session info (optional, keep compatible with existing checks)
                $admin = Auth::guard('admin')->user();
                session([
                    'user_id' => $admin->admin_id,
                    'username' => $admin->username,
                    'role' => 'admin',
                    'logged_in' => true
                ]);

                return redirect()->to('/admin/dashboard')->with([
                    'key' => 'success',
                    'value' => 'Login berhasil!'
                ]);
            }

            // Username atau password salah
            return back()->with([
                'key' => 'error',
                'value' => 'Username atau Password salah!'
            ]);
        }

        // Form tidak lengkap
        return back()->with([
            'key' => 'error',
            'value' => 'Form tidak lengkap!'
        ]);
    }

    /**
     * Logout
     */
    public function logout()
    {
        // Hapus semua session
        session()->flush();

        return redirect()->to('/')->with([
            'key' => 'success',
            'value' => 'Logout berhasil!'
        ]);
    }

    /**
     * Show register form pembeli
     */
    public function showRegisterPembeli()
    {
        return view('register-pembeli');
    }

    /**
     * Handle register pembeli
     */
    public function registerPembeli(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($user) {
            return redirect()->route('login.pembeli')->with([
                'key' => 'success',
                'value' => 'Pendaftaran berhasil. Silakan login.'
            ]);
        }

        return back()->with([
            'key' => 'error',
            'value' => 'Terjadi kesalahan saat mendaftar.'
        ])->withInput();
    }


}
