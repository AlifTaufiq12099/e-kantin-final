@extends('layouts.admin')

@section('title', 'Transaksi')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-2">Riwayat Transaksi</h1>
    <p class="text-gray-600">Lihat semua transaksi yang terjadi</p>
</div>

<div class="bg-white rounded-xl shadow-md p-6">
    <div class="mb-6">
        <h2 class="text-xl font-semibold text-gray-800">Semua Transaksi</h2>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-200">
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">ID</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">User</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Menu</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Lapak</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Waktu</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Jumlah</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Total</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksis as $t)
                <tr class="border-b border-gray-100 hover:bg-purple-50 transition" style="cursor: pointer;">
                    <td class="px-4 py-3 text-sm text-gray-600">
                        <a href="{{ route('admin.transaksi.show', $t->transaksi_id) }}" class="block text-purple-600 hover:text-purple-800 font-medium">
                            #{{ $t->transaksi_id }}
                        </a>
                    </td>
                    <td class="px-4 py-3 text-sm font-medium text-gray-800">
                        <a href="{{ route('admin.transaksi.show', $t->transaksi_id) }}" class="block">
                            {{ optional($t->user)->name ?? '-' }}
                        </a>
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-600">
                        <a href="{{ route('admin.transaksi.show', $t->transaksi_id) }}" class="block">
                            {{ optional($t->menu)->nama_menu ?? '-' }}
                        </a>
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-600">
                        <a href="{{ route('admin.transaksi.show', $t->transaksi_id) }}" class="block">
                            {{ optional($t->lapak)->nama_lapak ?? '-' }}
                        </a>
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-600">
                        <a href="{{ route('admin.transaksi.show', $t->transaksi_id) }}" class="block">
                            {{ \Carbon\Carbon::parse($t->waktu_transaksi)->format('d/m/Y H:i') }}
                        </a>
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-600">
                        <a href="{{ route('admin.transaksi.show', $t->transaksi_id) }}" class="block">
                            {{ $t->jumlah }}
                        </a>
                    </td>
                    <td class="px-4 py-3 text-sm font-medium text-gray-800">
                        <a href="{{ route('admin.transaksi.show', $t->transaksi_id) }}" class="block">
                            Rp {{ number_format($t->total_harga, 0, ',', '.') }}
                        </a>
                    </td>
                    <td class="px-4 py-3">
                        <a href="{{ route('admin.transaksi.show', $t->transaksi_id) }}" class="block">
                            <span class="px-2 py-1 text-xs rounded-full 
                                @if($t->status_transaksi == 'selesai') bg-green-100 text-green-600
                                @elseif($t->status_transaksi == 'diproses') bg-yellow-100 text-yellow-600
                                @else bg-blue-100 text-blue-600
                                @endif">
                                {{ ucfirst($t->status_transaksi) }}
                            </span>
                        </a>
                    </td>
                    <td class="px-4 py-3">
                        <a href="{{ route('admin.transaksi.show', $t->transaksi_id) }}" 
                           class="px-3 py-1 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 transition text-sm font-medium inline-block">
                            Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="px-4 py-8 text-center text-gray-500">
                        Belum ada transaksi
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($transaksis->hasPages())
    <div class="mt-6">
        {{ $transaksis->links() }}
    </div>
    @endif
</div>
@endsection
