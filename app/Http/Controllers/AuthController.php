<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Penjual;
use App\Models\Lapak;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

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

    /**
     * Redirect to Google OAuth
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle Google OAuth callback
     */
    public function handleGoogleCallback(Request $request)
    {
        try {
            // Check if error from Google
            if ($request->has('error')) {
                return redirect('/login/pembeli')->with([
                    'key' => 'error',
                    'value' => 'Login dibatalkan atau terjadi kesalahan di Google.'
                ]);
            }

            // Get code from Google
            if (!$request->has('code')) {
                return redirect('/login/pembeli')->with([
                    'key' => 'error',
                    'value' => 'Authorization code tidak ditemukan.'
                ]);
            }

            // Try to get user, if state validation fails, bypass it
            try {
                $googleUser = Socialite::driver('google')->user();
            } catch (\Exception $e) {
                // State validation failed, try manual approach
                \Log::warning('State validation failed, trying manual approach', ['error' => $e->getMessage()]);

                // Get access token manually
                $client = new \GuzzleHttp\Client([
                    'verify' => false // Disable SSL verification untuk development (Laragon SSL issue)
                ]);
                $response = $client->post('https://oauth2.googleapis.com/token', [
                    'form_params' => [
                        'client_id' => config('services.google.client_id'),
                        'client_secret' => config('services.google.client_secret'),
                        'code' => $request->code,
                        'grant_type' => 'authorization_code',
                        'redirect_uri' => config('services.google.redirect'),
                    ]
                ]);

                $token = json_decode((string) $response->getBody(), true);

                // Get user info
                $userResponse = $client->get('https://www.googleapis.com/oauth2/v2/userinfo', [
                    'headers' => ['Authorization' => 'Bearer ' . $token['access_token']]
                ]);

                $userData = json_decode((string) $userResponse->getBody(), true);
                $googleUser = (object) [
                    'email' => $userData['email'],
                    'name' => $userData['name'] ?? $userData['email'],
                    'id' => $userData['id']
                ];
            }

            \Log::info('Google User Retrieved:', [
                'email' => $googleUser->email ?? $googleUser->getEmail(),
                'name' => $googleUser->name ?? $googleUser->getName()
            ]);

            // Cari atau buat user berdasarkan Google email
            $email = $googleUser->email ?? $googleUser->getEmail();
            $name = $googleUser->name ?? $googleUser->getName();

            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $name,
                    'password' => Hash::make(uniqid('google_')),
                ]
            );

            \Log::info('User Found/Created:', ['user_id' => $user->id]);

            // Set session info
            session([
                'user_id' => $user->id,
                'username' => $user->name,
                'role' => 'pembeli',
                'logged_in' => true
            ]);

            \Log::info('Session Set:', session()->all());

            return redirect('/pembeli/lapak')->with([
                'key' => 'success',
                'value' => 'Login berhasil dengan Google!'
            ]);

        } catch (\Exception $e) {
            \Log::error('Google OAuth Error:', [
                'message' => $e->getMessage(),
                'class' => get_class($e),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return redirect('/login/pembeli')->with([
                'key' => 'error',
                'value' => 'Gagal login dengan Google: ' . $e->getMessage()
            ]);
        }
    }

}

