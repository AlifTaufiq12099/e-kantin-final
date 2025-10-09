<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
            'username' => 'required',
            'password' => 'required'
        ]);

        $username = $request->username;
        $password = $request->password;

        // Hardcode username & password pembeli
        $validUsername = 'Alif';
        $validPassword = '123';

        // Cek apakah variabel tersedia
        if (isset($username) && isset($password)) {
            // Cek username dan password
            if ($username === $validUsername && $password === $validPassword) {
                // Login berhasil - simpan session
                session([
                    'user_id' => 1,
                    'username' => $username,
                    'role' => 'pembeli',
                    'logged_in' => true
                ]);

                // Redirect ke dashboard pembeli
                return redirect()->to('/home')->with([
                    'key' => 'success',
                    'value' => 'Login berhasil!'
                ]);
            } else {
                // Username atau password salah
                return back()->with([
                    'key' => 'error',
                    'value' => 'Username atau Password salah!'
                ]);
            }
        } else {
            // Form tidak lengkap
            return back()->with([
                'key' => 'error',
                'value' => 'Form tidak lengkap!'
            ]);
        }
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

        // Hardcode username & password penjual
        $validUsername = 'penjual';
        $validPassword = '123';

        // Cek apakah variabel tersedia
        if (isset($username) && isset($password)) {
            // Cek username dan password
            if ($username === $validUsername && $password === $validPassword) {
                // Login berhasil - simpan session
                session([
                    'user_id' => 2,
                    'username' => $username,
                    'role' => 'penjual',
                    'logged_in' => true
                ]);

                // Redirect ke dashboard penjual
                return redirect()->to('/penjual/dashboard')->with([
                    'key' => 'success',
                    'value' => 'Login berhasil!'
                ]);
            } else {
                // Username atau password salah
                return back()->with([
                    'key' => 'error',
                    'value' => 'Username atau Password salah!'
                ]);
            }
        } else {
            // Form tidak lengkap
            return back()->with([
                'key' => 'error',
                'value' => 'Form tidak lengkap!'
            ]);
        }
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

        // Hardcode username & password admin
        $validUsername = 'admin';
        $validPassword = '123';

        // Cek apakah variabel tersedia
        if (isset($username) && isset($password)) {
            // Cek username dan password
            if ($username === $validUsername && $password === $validPassword) {
                // Login berhasil - simpan session
                session([
                    'user_id' => 3,
                    'username' => $username,
                    'role' => 'admin',
                    'logged_in' => true
                ]);

                // Redirect ke dashboard admin
                return redirect()->to('/admin/dashboard')->with([
                    'key' => 'success',
                    'value' => 'Login berhasil!'
                ]);
            } else {
                // Username atau password salah
                return back()->with([
                    'key' => 'error',
                    'value' => 'Username atau Password salah!'
                ]);
            }
        } else {
            // Form tidak lengkap
            return back()->with([
                'key' => 'error',
                'value' => 'Form tidak lengkap!'
            ]);
        }
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
}
