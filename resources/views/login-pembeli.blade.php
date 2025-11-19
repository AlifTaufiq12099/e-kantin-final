<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pembeli - Kantin D-pipe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .gradient-bg {
            background: linear-gradient(135deg, #FF8E53 0%, #FE6B8B 100%);
        }
        .input-focus:focus {
            border-color: #FF8E53;
            box-shadow: 0 0 0 3px rgba(255, 142, 83, 0.1);
        }
        .fade-in {
            animation: fadeIn 0.6s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .slide-in {
            animation: slideIn 0.6s ease-out;
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-30px); }
            to { opacity: 1; transform: translateX(0); }
        }
    </style>
</head>
<body class="bg-gray-50">

    <div class="min-h-screen flex">
        <!-- Left Side - Form Login -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
            <div class="max-w-md w-full fade-in">
                <!-- Back Button -->
                <a href="/" class="inline-flex items-center text-gray-600 hover:text-orange-500 mb-8 transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    Kembali
                </a>

                <!-- Logo & Title -->
                <div class="text-center mb-8">
                    <div class="w-20 h-20 gradient-bg rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <span class="text-5xl">🍽️</span>
                    </div>
                    <h1 class="text-4xl font-bold text-gray-800 mb-2">Login Pembeli</h1>
                    <p class="text-gray-600">Masuk untuk memesan makanan favoritmu</p>
                </div>

                <!-- Form Login -->
                <form action="/login/pembeli" method="POST" class="space-y-6">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <!-- Username -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                Email
                            </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    required
                                    value="{{ old('email') }}"
                                    class="input-focus w-full pl-10 pr-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none transition"
                                    placeholder="Masukkan email"
                                >
                        </div>
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                            Password
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                required
                                class="input-focus w-full pl-10 pr-12 py-3 border-2 border-gray-200 rounded-xl focus:outline-none transition"
                                placeholder="Masukkan password"
                            >
                            <button
                                type="button"
                                onclick="togglePassword()"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600"
                            >
                                <svg id="eye-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between">
                        <label class="flex items-center">
                            <input type="checkbox" name="remember" class="w-4 h-4 text-orange-500 border-gray-300 rounded focus:ring-orange-500">
                            <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                        </label>
                        <a href="#" class="text-sm text-orange-500 hover:text-orange-600 font-medium">
                            Lupa password?
                        </a>
                    </div>

                    <!-- Submit Button -->
                    <button
                        type="submit"
                        class="w-full gradient-bg text-white py-3 rounded-xl font-semibold hover:shadow-xl transition transform hover:scale-105"
                    >
                        Masuk
                    </button>

                    <!-- Register Link -->
                    <p class="text-center text-gray-600 text-sm">
                        Belum punya akun?
                        <a href="/register/pembeli" class="text-orange-500 hover:text-orange-600 font-semibold">
                            Daftar sekarang
                        </a>
                    </p>
                </form>

                <!-- Divider -->
                <div class="relative my-8">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-gray-50 text-gray-500">Atau login sebagai</span>
                    </div>
                </div>

                <!-- Role Switch -->
                <div class="grid grid-cols-2 gap-4">
                    <a href="/login/penjual" class="flex items-center justify-center p-3 border-2 border-gray-200 rounded-xl hover:border-green-500 hover:bg-green-50 transition">
                        <span class="text-2xl mr-2">👨‍🍳</span>
                        <span class="font-medium text-gray-700">Penjual</span>
                    </a>
                    <a href="/login/admin" class="flex items-center justify-center p-3 border-2 border-gray-200 rounded-xl hover:border-blue-500 hover:bg-blue-50 transition">
                        <span class="text-2xl mr-2">👨‍💼</span>
                        <span class="font-medium text-gray-700">Admin</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Right Side - Illustration -->
        <div class="hidden lg:flex lg:w-1/2 gradient-bg items-center justify-center p-12 relative overflow-hidden">
            <div class="relative z-10 text-white text-center slide-in">
                <div class="mb-8">
                    <span class="text-9xl">🍽️</span>
                </div>
                <h2 class="text-5xl font-bold mb-4">Selamat Datang!</h2>
                <p class="text-xl mb-8 opacity-90">Pesan makanan kampus jadi lebih mudah dan praktis</p>

                <!-- Features -->
                <div class="space-y-4 max-w-md mx-auto">
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 flex items-center">
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mr-4">
                            <span class="text-2xl">⚡</span>
                        </div>
                        <div class="text-left">
                            <h3 class="font-semibold text-lg">Hemat Waktu</h3>
                            <p class="text-sm opacity-80">Pesan online, ambil langsung</p>
                        </div>
                    </div>

                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 flex items-center">
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mr-4">
                            <span class="text-2xl">💳</span>
                        </div>
                        <div class="text-left">
                            <h3 class="font-semibold text-lg">Pembayaran Mudah</h3>
                            <p class="text-sm opacity-80">Berbagai metode pembayaran</p>
                        </div>
                    </div>

                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-4 flex items-center">
                        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center mr-4">
                            <span class="text-2xl">🎯</span>
                        </div>
                        <div class="text-left">
                            <h3 class="font-semibold text-lg">Menu Lengkap</h3>
                            <p class="text-sm opacity-80">Pilihan makanan & minuman</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Decorative Elements -->
            <div class="absolute top-10 right-10 w-32 h-32 bg-white/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-10 left-10 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>
        </div>
    </div>



</body>
</html>
