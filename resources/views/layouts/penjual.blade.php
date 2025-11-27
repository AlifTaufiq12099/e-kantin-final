<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Penjual') - Kantin D-pipe</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .gradient-bg {
            background: linear-gradient(135deg, #FF8E53 0%, #FE6B8B 100%);
        }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-lg fixed h-full">
            <!-- Logo Header -->
            <div class="p-6 border-b">
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-12 h-12 gradient-bg rounded-lg flex items-center justify-center text-white font-bold text-xl">
                        👨‍🍳
                    </div>
                    <div>
                        <h2 class="font-bold text-gray-800">Dashboard Penjual</h2>
                        <p class="text-xs text-gray-500">Kantin D-pipe</p>
                    </div>
                </div>

                <!-- Lapak Info Card -->
                @php
                    $penjual = Auth::guard('penjual')->user();
                    $lapak = $penjual ? \App\Models\Lapak::find($penjual->lapak_id) : null;
                @endphp
                @if($lapak)
                <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
                    <div class="flex items-center space-x-2 mb-3">
                        <span class="text-2xl">🏪</span>
                        <h3 class="font-bold text-gray-800 text-sm">{{ $lapak->nama_lapak }}</h3>
                    </div>
                    <div class="space-y-1 text-xs text-gray-600 mb-3">
                        
                        <p>👤 {{ $lapak->pemilik ?? '-' }}</p>
                        <p>📱 {{ $lapak->no_hp_pemilik ?? '-' }}</p>
                    </div>
                    <a href="{{ route('penjual.lapak.edit') }}" class="text-orange-500 text-xs font-semibold hover:text-orange-600">
                        Edit Profil →
                    </a>
                </div>
                @endif
            </div>

            <!-- Navigation -->
            <nav class="p-4 space-y-2">
                <a href="{{ route('penjual.dashboard') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('penjual.dashboard') ? 'bg-orange-50 text-orange-600 border-l-4 border-orange-500' : 'text-gray-700 hover:bg-gray-100' }}">
                    <span class="text-xl">📊</span>
                    <span class="font-medium">Dashboard</span>
                </a>
                <a href="{{ route('penjual.transaksi.index') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('penjual.transaksi.*') ? 'bg-orange-50 text-orange-600 border-l-4 border-orange-500' : 'text-gray-700 hover:bg-gray-100' }}">
                    <span class="text-xl">📋</span>
                    <span class="font-medium">Pesanan</span>
                </a>
                <a href="{{ route('penjual.menus.index') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('penjual.menus.*') ? 'bg-orange-50 text-orange-600 border-l-4 border-orange-500' : 'text-gray-700 hover:bg-gray-100' }}">
                    <span class="text-xl">🍽️</span>
                    <span class="font-medium">Menu</span>
                </a>
                <a href="{{ route('penjual.laporan.harian') }}" class="flex items-center space-x-3 p-3 rounded-lg {{ request()->routeIs('penjual.laporan.*') ? 'bg-orange-50 text-orange-600 border-l-4 border-orange-500' : 'text-gray-700 hover:bg-gray-100' }}">
                    <span class="text-xl">💰</span>
                    <span class="font-medium">Laporan Keuangan</span>
                </a>
            </nav>

            <!-- Logout Button -->
            <div class="absolute bottom-0 w-full p-4 border-t">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center space-x-3 p-3 rounded-lg text-red-600 hover:bg-red-50 w-full">
                        <span class="text-xl">🚪</span>
                        <span class="font-medium">Logout</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 ml-64 overflow-y-auto">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b px-6 py-4 flex items-center justify-between">
                <div class="flex-1">
                    <h1 class="text-2xl font-bold text-gray-800">@yield('page-title', 'Dashboard')</h1>
                    @hasSection('page-subtitle')
                        <p class="text-sm text-gray-600 mt-1">@yield('page-subtitle')</p>
                    @endif
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-right">
                        <p class="text-sm font-semibold text-gray-800">Hari ini</p>
                        <p class="text-xs text-gray-500">{{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</p>
                    </div>
                    <div class="w-10 h-10 gradient-bg rounded-full flex items-center justify-center text-white font-bold">
                        {{ substr(session('username') ?? 'P', 0, 1) }}
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="p-6">
                @if(session('key') && session('value'))
                    <div class="mb-4 p-4 rounded-lg {{ session('key') === 'success' ? 'bg-green-50 border border-green-200 text-green-800' : 'bg-red-50 border border-red-200 text-red-800' }}">
                        {{ session('value') }}
                    </div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    @stack('scripts')
</body>
</html>

