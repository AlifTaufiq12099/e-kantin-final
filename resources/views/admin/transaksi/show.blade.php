@extends('layouts.admin')

@section('title', 'Detail Transaksi')

@section('content')
<div class="mb-6">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Detail Transaksi #{{ $t->transaksi_id }}</h1>
            <p class="text-gray-600">Lihat detail lengkap transaksi</p>
        </div>
        <a href="{{ route('admin.transaksi.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition font-medium">
            ← Kembali
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Informasi Transaksi -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Informasi Transaksi</h2>
        <div class="space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                <span class="text-sm text-gray-600">ID Transaksi</span>
                <span class="text-sm font-medium text-gray-800">#{{ $t->transaksi_id }}</span>
            </div>
            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                <span class="text-sm text-gray-600">Waktu Transaksi</span>
                <span class="text-sm font-medium text-gray-800">{{ \Carbon\Carbon::parse($t->waktu_transaksi)->format('d/m/Y H:i') }}</span>
            </div>
            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                <span class="text-sm text-gray-600">User</span>
                <span class="text-sm font-medium text-gray-800">{{ optional($t->user)->name ?? '-' }}</span>
            </div>
            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                <span class="text-sm text-gray-600">Menu</span>
                <span class="text-sm font-medium text-gray-800">{{ optional($t->menu)->nama_menu ?? '-' }}</span>
            </div>
            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                <span class="text-sm text-gray-600">Lapak</span>
                <span class="text-sm font-medium text-gray-800">{{ optional($t->lapak)->nama_lapak ?? '-' }}</span>
            </div>
            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                <span class="text-sm text-gray-600">Jumlah</span>
                <span class="text-sm font-medium text-gray-800">{{ $t->jumlah }} porsi</span>
            </div>
            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                <span class="text-sm text-gray-600">Harga Satuan</span>
                <span class="text-sm font-medium text-gray-800">Rp {{ number_format($t->menu->harga ?? 0, 0, ',', '.') }}</span>
            </div>
            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                <span class="text-sm text-gray-600">Metode Pembayaran</span>
                <span class="text-sm font-medium text-gray-800">{{ ucfirst($t->metode_pembayaran ?? '-') }}</span>
            </div>
            <div class="flex items-center justify-between">
                <span class="text-lg font-semibold text-gray-800">Total Harga</span>
                <span class="text-xl font-bold text-purple-600">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <!-- Status & Bukti Pembayaran -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Status & Bukti</h2>
        
        <!-- Status Transaksi -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Status Transaksi</label>
            <div class="mb-4">
                <span class="px-3 py-2 text-sm rounded-lg inline-block
                    @if($t->status_transaksi == 'selesai') bg-green-100 text-green-600
                    @elseif($t->status_transaksi == 'diproses') bg-yellow-100 text-yellow-600
                    @elseif($t->status_transaksi == 'dibatalkan') bg-red-100 text-red-600
                    @else bg-blue-100 text-blue-600
                    @endif">
                    {{ ucfirst($t->status_transaksi) }}
                </span>
            </div>
            
            @if($t->status_transaksi != 'selesai' && $t->status_transaksi != 'dibatalkan')
            <form action="{{ route('admin.transaksi.updateStatus', $t->transaksi_id) }}" method="POST" class="mb-4">
                @csrf
                <select name="status_transaksi" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent outline-none mb-3">
                    <option value="baru" {{ $t->status_transaksi == 'baru' ? 'selected' : '' }}>Baru</option>
                    <option value="menunggu_konfirmasi" {{ $t->status_transaksi == 'menunggu_konfirmasi' ? 'selected' : '' }}>Menunggu Konfirmasi</option>
                    <option value="diproses" {{ $t->status_transaksi == 'diproses' ? 'selected' : '' }}>Diproses</option>
                    <option value="selesai" {{ $t->status_transaksi == 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="dibatalkan" {{ $t->status_transaksi == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
                <button type="submit" class="w-full bg-gradient-to-r from-purple-500 to-indigo-600 text-white px-4 py-2 rounded-lg hover:shadow-lg transition font-medium">
                    Update Status
                </button>
            </form>
            @endif
        </div>

        <!-- Bukti Pembayaran -->
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Bukti Pembayaran</label>
            @if($t->bukti_pembayaran)
                <div class="mb-3">
                    @php
                        $exists = \Illuminate\Support\Facades\Storage::disk('public')->exists($t->bukti_pembayaran);
                    @endphp
                    @if($exists)
                        <img src="{{ asset('storage/'.$t->bukti_pembayaran) }}" class="max-w-full rounded-lg border border-gray-200 shadow-sm" alt="Bukti Pembayaran">
                    @else
                        <p class="text-sm text-gray-500">File bukti pembayaran tidak ditemukan.</p>
                    @endif
                </div>
                <p class="text-xs text-gray-500">Bukti pembayaran yang diupload oleh user.</p>
            @else
                <div class="text-center py-8 bg-gray-50 rounded-lg border border-gray-200">
                    <p class="text-gray-500">Tidak ada bukti pembayaran</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
