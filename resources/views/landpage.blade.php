<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kantin D-pipe - Pesan Makanan Kampus</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .gradient-bg {
            background: linear-gradient(135deg, #FF8E53 0%, #FE6B8B 100%);
        }
        .hero-pattern {
            background-color: #FF8E53;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        .fade-in {
            animation: fadeIn 1s ease-in;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
            backdrop-filter: blur(5px);
        }
        .modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .modal-content {
            animation: slideDown 0.3s ease;
        }
        @keyframes slideDown {
            from { transform: translateY(-50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
    </style>
</head>
<body class="bg-gray-50">

    <!-- Navbar -->
    <nav class="bg-white shadow-lg fixed w-full top-0 z-50">
        <div class="container mx-auto px-6 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 gradient-bg rounded-lg flex items-center justify-center text-white font-bold text-xl">
                        KD
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Kantin D-pipe</h1>
                        <p class="text-xs text-gray-500">Pesan Makanan Kampus</p>
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <a href="#menu" class="hidden md:block text-gray-600 hover:text-orange-500 transition">Menu</a>
                    <a href="#tentang" class="hidden md:block text-gray-600 hover:text-orange-500 transition">Tentang</a>
                    <button onclick="openAdminLoginModal()" class="bg-gradient-to-r from-blue-500 to-indigo-600 text-white px-6 py-2 rounded-full hover:shadow-lg transition font-medium">
                        Login Admin
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-pattern pt-32 pb-20 px-6">
        <div class="container mx-auto text-center fade-in">
            <h2 class="text-5xl md:text-6xl font-bold text-white mb-6 leading-tight">
                Pesan Makanan Kampus<br/>
                <span class="text-yellow-300">Jadi Lebih Mudah</span>
            </h2>
            <p class="text-white text-lg md:text-xl mb-8 max-w-2xl mx-auto">
                Hemat waktu dengan memesan makanan favoritmu secara online. Tinggal datang dan ambil!
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                <button onclick="openUserLoginModal()" class="bg-white text-orange-500 px-8 py-4 rounded-full text-lg font-semibold hover:shadow-2xl transition transform hover:scale-105">
                    🍽️ Pesan Sekarang
                </button>
                <a href="#menu" class="border-2 border-white text-white px-8 py-4 rounded-full text-lg font-semibold hover:bg-white hover:text-orange-500 transition">
                    Lihat Menu
                </a>
            </div>
            <div class="mt-8 text-white">
                <p class="text-sm">⏰ Jam Operasional: <span class="font-semibold">07:00 - 15:00</span></p>
            </div>
        </div>
    </section>

    <!-- Menu Populer -->
    <section id="menu" class="py-20 px-6 bg-white">
        <div class="container mx-auto">
            <div class="text-center mb-12">
                <h3 class="text-4xl font-bold text-gray-800 mb-4">Menu Populer</h3>
                <p class="text-gray-600">Makanan dan minuman favorit mahasiswa</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Menu Item 1 -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-hover">
                    <div class="h-48 bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center">
                        <span class="text-8xl">🍚</span>
                    </div>
                    <div class="p-6">
                        <h4 class="text-xl font-bold text-gray-800 mb-2">Nasi Gila</h4>
                        <p class="text-orange-500 font-bold text-2xl mb-3">Rp 10.000</p>
                        <button onclick="openUserLoginModal()" class="w-full bg-orange-500 text-white py-2 rounded-lg hover:bg-orange-600 transition">
                            Pesan
                        </button>
                    </div>
                </div>

                <!-- Menu Item 2 -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-hover">
                    <div class="h-48 bg-gradient-to-br from-yellow-400 to-orange-500 flex items-center justify-center">
                        <span class="text-8xl">🍜</span>
                    </div>
                    <div class="p-6">
                        <h4 class="text-xl font-bold text-gray-800 mb-2">Mie Jawa</h4>
                        <p class="text-orange-500 font-bold text-2xl mb-3">Rp 10.000</p>
                        <button onclick="openUserLoginModal()" class="w-full bg-orange-500 text-white py-2 rounded-lg hover:bg-orange-600 transition">
                            Pesan
                        </button>
                    </div>
                </div>

                <!-- Menu Item 3 -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-hover">
                    <div class="h-48 bg-gradient-to-br from-amber-400 to-orange-600 flex items-center justify-center">
                        <span class="text-8xl">🥤</span>
                    </div>
                    <div class="p-6">
                        <h4 class="text-xl font-bold text-gray-800 mb-2">Es Teh</h4>
                        <p class="text-orange-500 font-bold text-2xl mb-3">Rp 5.000</p>
                        <button onclick="openUserLoginModal()" class="w-full bg-orange-500 text-white py-2 rounded-lg hover:bg-orange-600 transition">
                            Pesan
                        </button>
                    </div>
                </div>

                <!-- Menu Item 4 -->
                <div class="bg-white rounded-2xl shadow-lg overflow-hidden card-hover">
                    <div class="h-48 bg-gradient-to-br from-yellow-300 to-yellow-500 flex items-center justify-center">
                        <span class="text-8xl">🍺</span>
                    </div>
                    <div class="p-6">
                        <h4 class="text-xl font-bold text-gray-800 mb-2">Es Jeruk</h4>
                        <p class="text-orange-500 font-bold text-2xl mb-3">Rp 5.000</p>
                        <button onclick="openUserLoginModal()" class="w-full bg-orange-500 text-white py-2 rounded-lg hover:bg-orange-600 transition">
                            Pesan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Fitur Section -->
    <section id="tentang" class="py-20 px-6 bg-gray-50">
        <div class="container mx-auto">
            <div class="text-center mb-12">
                <h3 class="text-4xl font-bold text-gray-800 mb-4">Kenapa Pilih Kami?</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
                <div class="text-center p-8 bg-white rounded-2xl shadow-lg card-hover">
                    <div class="w-20 h-20 gradient-bg rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-4xl">⚡</span>
                    </div>
                    <h4 class="text-xl font-bold text-gray-800 mb-2">Hemat Waktu</h4>
                    <p class="text-gray-600">Pesan online, ambil langsung tanpa antri</p>
                </div>

                <div class="text-center p-8 bg-white rounded-2xl shadow-lg card-hover">
                    <div class="w-20 h-20 gradient-bg rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-4xl">💳</span>
                    </div>
                    <h4 class="text-xl font-bold text-gray-800 mb-2">Praktis</h4>
                    <p class="text-gray-600">Pembayaran mudah dan aman</p>
                </div>

                <div class="text-center p-8 bg-white rounded-2xl shadow-lg card-hover">
                    <div class="w-20 h-20 gradient-bg rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-4xl">🎯</span>
                    </div>
                    <h4 class="text-xl font-bold text-gray-800 mb-2">Terpercaya</h4>
                    <p class="text-gray-600">Digunakan oleh ribuan mahasiswa</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="gradient-bg py-8 px-6 text-white">
        <div class="container mx-auto text-center">
            <p class="text-lg font-semibold mb-2">Kantin D-pipe</p>
            <p class="text-sm opacity-90">📍 Kampus | ⏰ 07:00 - 15:00 | 📞 Contact Us</p>
            <p class="text-xs mt-4 opacity-75">&copy; 2025 Kantin D-pipe. All rights reserved.</p>
        </div>
    </footer>

    <!-- Modal Login User (Pembeli & Penjual) -->
    <div id="userLoginModal" class="modal">
        <div class="modal-content bg-white rounded-3xl shadow-2xl max-w-md w-full mx-4 p-8">
            <div class="text-center mb-8">
                <div class="w-16 h-16 gradient-bg rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-3xl">🔐</span>
                </div>
                <h3 class="text-3xl font-bold text-gray-800 mb-2">Masuk Sebagai</h3>
                <p class="text-gray-600">Pilih role untuk melanjutkan</p>
            </div>

            <div class="space-y-4">
                <!-- Role Pembeli -->
                <a href="/login/pembeli" class="block bg-gradient-to-r from-orange-500 to-pink-500 text-white p-4 rounded-xl hover:shadow-xl transition transform hover:scale-105">
                    <div class="flex items-center">
                        <div class="text-4xl mr-4">🍽️</div>
                        <div>
                            <h4 class="font-bold text-lg">Pembeli</h4>
                            <p class="text-sm opacity-90">Pesan makanan favoritmu</p>
                        </div>
                    </div>
                </a>

                <!-- Role Penjual -->
                <a href="/login/penjual" class="block bg-gradient-to-r from-green-500 to-emerald-600 text-white p-4 rounded-xl hover:shadow-xl transition transform hover:scale-105">
                    <div class="flex items-center">
                        <div class="text-4xl mr-4">👨‍🍳</div>
                        <div>
                            <h4 class="font-bold text-lg">Penjual</h4>
                            <p class="text-sm opacity-90">Kelola menu & pesanan</p>
                        </div>
                    </div>
                </a>
            </div>

            <button onclick="closeUserLoginModal()" class="w-full mt-6 text-gray-600 py-3 rounded-xl border-2 border-gray-200 hover:bg-gray-50 transition">
                Batal
            </button>
        </div>
    </div>

    <!-- Modal Login Admin -->
    <div id="adminLoginModal" class="modal">
        <div class="modal-content bg-white rounded-3xl shadow-2xl max-w-md w-full mx-4 p-8">
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-3xl">👨‍💼</span>
                </div>
                <h3 class="text-3xl font-bold text-gray-800 mb-2">Login Admin</h3>
                <p class="text-gray-600">Masuk ke panel administrator</p>
            </div>

            <div class="space-y-4">
                <!-- Role Admin -->
                <a href="/login/admin" class="block bg-gradient-to-r from-blue-500 to-indigo-600 text-white p-4 rounded-xl hover:shadow-xl transition transform hover:scale-105">
                    <div class="flex items-center justify-center">
                        <div class="text-4xl mr-4">👨‍💼</div>
                        <div>
                            <h4 class="font-bold text-lg">Admin</h4>
                            <p class="text-sm opacity-90">Kelola sistem kantin</p>
                        </div>
                    </div>
                </a>
            </div>

            <button onclick="closeAdminLoginModal()" class="w-full mt-6 text-gray-600 py-3 rounded-xl border-2 border-gray-200 hover:bg-gray-50 transition">
                Batal
            </button>
        </div>
    </div>

    <script>
        // Modal User Login (Pembeli & Penjual)
        function openUserLoginModal() {
            document.getElementById('userLoginModal').classList.add('active');
        }

        function closeUserLoginModal() {
            document.getElementById('userLoginModal').classList.remove('active');
        }

        // Modal Admin Login
        function openAdminLoginModal() {
            document.getElementById('adminLoginModal').classList.add('active');
        }

        function closeAdminLoginModal() {
            document.getElementById('adminLoginModal').classList.remove('active');
        }

        // Close modal when clicking outside
        document.getElementById('userLoginModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeUserLoginModal();
            }
        });

        document.getElementById('adminLoginModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeAdminLoginModal();
            }
        });

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>

</body>
</html>     
