<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Lapak - Kantin D-pipe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .gradient-bg {
            background: linear-gradient(135deg, #FF8E53 0%, #FE6B8B 100%);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        .lapak-card {
            cursor: pointer;
            border: 3px solid transparent;
            transition: all 0.3s ease;
        }
        .lapak-card:hover {
            border-color: #FF8E53;
            transform: scale(1.02);
        }
        .lapak-card.selected {
            border-color: #FF8E53;
            background: linear-gradient(135deg, rgba(255, 142, 83, 0.1) 0%, rgba(254, 107, 139, 0.1) 100%);
        }
        
        /* Mobile Menu Toggle */
        .mobile-menu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }
        .mobile-menu.active {
            max-height: 500px;
        }
        
        /* Floating Button */
        .floating-btn {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 40;
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.4);
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0%, 100% {
                box-shadow: 0 8px 20px rgba(59, 130, 246, 0.4);
            }
            50% {
                box-shadow: 0 8px 30px rgba(59, 130, 246, 0.6);
            }
        }
        
        .floating-btn:hover {
            transform: scale(1.1);
            transition: transform 0.2s;
        }
    </style>
</head>
<body class="bg-gray-50">

    <!-- Navbar -->
    <nav class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4 py-3">
            <!-- Desktop & Mobile Header -->
            <div class="flex items-center justify-between">
                <!-- Logo & Title -->
                <div class="flex items-center space-x-2">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 gradient-bg rounded-lg flex items-center justify-center text-white font-bold text-lg sm:text-xl">
                        KD
                    </div>
                    <div>
                        <h1 class="text-base sm:text-xl font-bold text-gray-800">Kantin D-pipe</h1>
                        <p class="text-xs text-gray-500 hidden sm:block">⏰ 07:00 - 15:00</p>
                    </div>
                </div>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-4">
                    <div class="text-right">
                        <p class="text-sm font-semibold text-gray-800">{{ session('username') }}</p>
                        <p class="text-xs text-gray-500">Pembeli</p>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition text-sm font-medium">
                            Logout
                        </button>
                    </form>
                </div>

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-btn" class="md:hidden p-2 rounded-lg hover:bg-gray-100 transition">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>

            <!-- Mobile Menu Dropdown -->
            <div id="mobile-menu" class="mobile-menu md:hidden">
                <div class="py-4 space-y-3 border-t mt-3">
                    <div class="px-2 py-2 bg-gray-50 rounded-lg">
                        <p class="text-sm font-semibold text-gray-800">{{ session('username') }}</p>
                        <p class="text-xs text-gray-500">Pembeli</p>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full bg-red-500 text-white px-4 py-3 rounded-lg hover:bg-red-600 transition text-sm font-medium">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-4 sm:py-8">

        <!-- Welcome Section -->
        <div class="gradient-bg rounded-2xl sm:rounded-3xl p-4 sm:p-8 text-white mb-6 sm:mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl sm:text-3xl font-bold mb-1 sm:mb-2">Selamat Datang, {{ session('username') }}! 👋</h2>
                    <p class="text-sm sm:text-lg opacity-90">Pilih lapak favorit dan pesan makananmu!</p>
                </div>
                <div class="text-3xl sm:text-6xl">
                    🍽
                </div>
            </div>
        </div>

        <!-- Pilih Lapak Section -->
        <div id="section-lapak">
            <h3 class="text-xl sm:text-2xl font-bold text-gray-800 mb-4 sm:mb-6">Pilih Lapak</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 mb-8">
                @foreach($lapaks as $lapak)
                    <a href="{{ route('pembeli.lapak.show', $lapak->lapak_id) }}" class="lapak-card bg-white rounded-xl sm:rounded-2xl shadow-md p-4 sm:p-6 block">
                        <div class="flex items-start justify-between mb-3 sm:mb-4">
                            <div class="flex items-center space-x-2 sm:space-x-3">
                                <div class="w-12 h-12 sm:w-16 sm:h-16 gradient-bg rounded-lg sm:rounded-xl flex items-center justify-center text-2xl sm:text-3xl">
                                    🏪
                                </div>
                                <div>
                                    <h4 class="font-bold text-gray-800 text-base sm:text-lg">{{ $lapak->nama_lapak }}</h4>
                                    <p class="text-xs sm:text-sm text-gray-500">⭐ 4.8</p>
                                </div>
                            </div>
                            <span class="bg-green-100 text-green-700 px-2 sm:px-3 py-1 rounded-full text-xs font-semibold">Buka</span>
                        </div>
                        <div class="space-y-1 sm:space-y-2 text-xs sm:text-sm text-gray-600">
                            <div class="flex items-center">
                                <span class="mr-2">👤</span>
                                <span>{{ $lapak->pemilik ?? '-' }}</span>
                            </div>
                            <div class="flex items-center">
                                <span class="mr-2">📱</span>
                                <span>{{ $lapak->no_hp_pemilik ?? '-' }}</span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

    </div>

    <!-- Floating Button Riwayat Pesanan -->
    <a href="{{ route('pembeli.riwayat') }}" class="floating-btn bg-blue-500 hover:bg-blue-600 text-white rounded-full p-4 flex items-center space-x-2 shadow-lg">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
        </svg>
        <span class="hidden sm:inline font-medium">Riwayat</span>
    </a>

    <script>
        // Mobile Menu Toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('active');
        });

        // Select Lapak
        function selectLapak(slug, el) {
            document.querySelectorAll('.lapak-card').forEach(c => c.classList.remove('selected'));
            el.classList.add('selected');
        }
    </script>

</body>
</html>