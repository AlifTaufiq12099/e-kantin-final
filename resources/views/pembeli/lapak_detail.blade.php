<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $lapak->nama_lapak }} - Menu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        .gradient-bg { background: linear-gradient(135deg, #FF8E53 0%, #FE6B8B 100%); }
        .card-hover { transition: all 0.3s ease; }
        .card-hover:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
    </style>
</head>
<body class="bg-gray-50">

<div class="container mx-auto p-6">
    <div class="mb-4">
        <a href="{{ route('pembeli.lapak.select') }}" class="text-gray-600 hover:text-orange-500">&larr; Pilih Lapak Lain</a>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow mb-6">
        <h1 class="text-2xl font-bold">{{ $lapak->nama_lapak }}</h1>
        <p class="text-sm text-gray-600">Pemilik: {{ $lapak->pemilik }} | No: {{ $lapak->no_hp_pemilik }}</p>
    </div>

    <h2 class="text-xl font-semibold mb-4">Menu</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($menus as $menu)
            <div class="bg-white rounded-2xl shadow p-4 card-hover">
                <div class="h-48 bg-gray-100 rounded-lg mb-4 flex items-center justify-center overflow-hidden">
                    @php
                        $imgUrl = null;
                        $exists = false;
                        
                        if (!empty($menu->image)) {
                            // Cek jika image adalah URL lengkap
                            if (str_starts_with($menu->image, 'http://') || str_starts_with($menu->image, 'https://')) {
                                $imgUrl = $menu->image;
                                $exists = true;
                            } else {
                                // Path image disimpan di storage public
                                $imgPath = $menu->image;
                                
                                // Cek apakah file ada
                                $exists = \Illuminate\Support\Facades\Storage::disk('public')->exists($imgPath);
                                
                                if ($exists) {
                                    $imgUrl = asset('storage/'.$imgPath);
                                } else {
                                    // Coba cek dengan thumbnail jika ada
                                    $thumbPath = 'menus/thumb_'.basename($imgPath);
                                    $exists = \Illuminate\Support\Facades\Storage::disk('public')->exists($thumbPath);
                                    
                                    if ($exists) {
                                        $imgUrl = asset('storage/'.$thumbPath);
                                    } else {
                                        // Fallback: coba langsung dengan path asli
                                        $imgUrl = asset('storage/'.$imgPath);
                                        $exists = true; // Anggap ada, browser akan handle 404
                                    }
                                }
                            }
                        }
                    @endphp
                    @if($imgUrl)
                        <img src="{{ $imgUrl }}" 
                             alt="{{ $menu->nama_menu }}" 
                             class="w-full h-full object-cover"
                             onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'text-center\'><span class=\'text-6xl\'>🍽️</span><p class=\'text-gray-400 text-sm mt-2\'>{{ $menu->nama_menu }}</p></div>';">
                    @else
                        <div class="text-center">
                            <span class="text-6xl">🍽️</span>
                            <p class="text-gray-400 text-sm mt-2">{{ $menu->nama_menu }}</p>
                        </div>
                    @endif
                </div>
                <h3 class="font-semibold text-lg">{{ $menu->nama_menu }}</h3>
                <p class="text-sm text-gray-500 mb-3">{{ $menu->deskripsi }}</p>
                <div class="flex items-center justify-between">
                    <span class="text-orange-500 font-bold">Rp {{ number_format($menu->harga,0,',','.') }}</span>
                    <button onclick="openOrderForm({{ $menu->menu_id }}, '{{ addslashes($menu->nama_menu) }}', {{ $menu->harga }})" class="bg-orange-500 text-white px-3 py-2 rounded-lg">Pesan</button>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Order Modal (simple) -->
    <div id="orderModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center p-4">
        <div class="bg-white rounded-2xl p-6 w-full max-w-md">
            <h3 id="orderTitle" class="text-lg font-semibold mb-2">Pesan</h3>
            <form id="orderForm" method="POST" action="{{ route('pembeli.order.store') }}">
                @csrf
                <input type="hidden" name="menu_id" id="menu_id">
                <input type="hidden" name="lapak_id" value="{{ $lapak->lapak_id }}">

                <div class="mb-3">
                    <label class="block text-sm text-gray-700">Nama Menu</label>
                    <div id="menuName" class="font-medium"></div>
                </div>

                <div class="mb-3">
                    <label class="block text-sm text-gray-700">Jumlah</label>
                    <input type="number" name="jumlah" id="jumlah" value="1" min="1" class="w-full px-3 py-2 border rounded">
                </div>

                <div class="mb-3">
                    <label class="block text-sm text-gray-700">Metode Pembayaran</label>
                    <select name="metode_pembayaran" class="w-full px-3 py-2 border rounded">
                        <option>Tunai</option>
                        <option>Transfer</option>
                    </select>
                </div>

                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="closeOrder()" class="px-4 py-2 border rounded">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-orange-500 text-white rounded">Kirim Pesanan</button>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
    function openOrderForm(menuId, menuName, harga) {
        document.getElementById('menu_id').value = menuId;
        document.getElementById('menuName').innerText = menuName + ' - Rp ' + Number(harga).toLocaleString('id-ID');
        document.getElementById('orderModal').classList.remove('hidden');
        document.getElementById('orderModal').classList.add('flex');
    }
    function closeOrder() {
        document.getElementById('orderModal').classList.add('hidden');
        document.getElementById('orderModal').classList.remove('flex');
    }
</script>

</body>
</html>
