<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail Pesanan #{{ $t->transaksi_id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
<div class="container mx-auto p-6">
    <a href="{{ route('pembeli.lapak.select') }}" class="text-gray-600 hover:text-orange-500">&larr; Kembali ke Pilih Lapak</a>

    <div class="bg-white p-6 rounded-2xl shadow mt-4">
        <h2 class="text-2xl font-bold mb-2">Pesanan #{{ $t->transaksi_id }}</h2>
        <p class="text-sm text-gray-600 mb-4">Waktu: {{ $t->waktu_transaksi }}</p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <h3 class="font-semibold">Menu</h3>
                <p>{{ $t->menu->nama_menu ?? '-' }}</p>
                <p class="text-sm text-gray-500">{{ $t->menu->deskripsi ?? '' }}</p>
            </div>
            <div>
                <h3 class="font-semibold">Ringkasan</h3>
                <p>Jumlah: {{ $t->jumlah }}</p>
                <p>Total: Rp {{ number_format($t->total_harga,0,',','.') }}</p>
                <p>Metode: {{ $t->metode_pembayaran ?? 'Tunai' }}</p>
                <p>Status: <strong>{{ $t->status_transaksi }}</strong></p>
            </div>
        </div>

        <div class="mt-6">
            <h4 class="font-semibold mb-2">Status Pesanan</h4>
            @php
                $status = $t->status_transaksi;
            @endphp
            @if($status == 'menunggu_pembayaran')
                <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-3 rounded mb-3">Menunggu pembayaran. Silakan unggah bukti pembayaran.</div>
            @elseif($status == 'menunggu_konfirmasi')
                <div class="bg-blue-50 border border-blue-200 text-blue-800 px-4 py-3 rounded mb-3">Bukti terkirim. Menunggu konfirmasi dari penjual.</div>
            @elseif($status == 'sedang_dibuat')
                <div class="bg-indigo-50 border border-indigo-200 text-indigo-800 px-4 py-3 rounded mb-3">Pesanan sedang dibuat. Pembayaran berhasil dikonfirmasi.</div>
            @elseif($status == 'siap')
                <div class="bg-teal-50 border border-teal-200 text-teal-800 px-4 py-3 rounded mb-3">Pesanan sudah siap. Silakan ambil di lapak.</div>
                    <div class="mt-3">
                        <form method="POST" action="{{ route('pembeli.order.confirmReceived', $t->transaksi_id) }}">
                            @csrf
                            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Konfirmasi Terima Pesanan</button>
                        </form>
                    </div>
            @elseif($status == 'selesai')
                <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded mb-3">Pesanan selesai. Terima kasih.</div>
            @elseif($status == 'dibatalkan')
                <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded mb-3">Pesanan dibatalkan.</div>
            @else
                <div class="bg-gray-50 border border-gray-200 text-gray-800 px-4 py-3 rounded mb-3">Status: {{ $status }}</div>
            @endif

            @if($t->bukti_pembayaran)
                <p class="mb-2">Bukti pembayaran:</p>
                <img src="{{ asset('storage/'.$t->bukti_pembayaran) }}" alt="bukti" class="max-w-xs rounded mb-3">
            @endif

            @if($status == 'menunggu_pembayaran')
                <h4 class="font-semibold mb-2">Kirim Bukti Pembayaran</h4>
                <form action="{{ route('pembeli.order.uploadProof', $t->transaksi_id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="bukti" accept="image/*" required class="mb-3">
                    <div>
                        <button type="submit" class="bg-orange-500 text-white px-4 py-2 rounded">Kirim Bukti</button>
                    </div>
                </form>
            @endif
        </div>

    </div>
</div>
</body>
</html>
