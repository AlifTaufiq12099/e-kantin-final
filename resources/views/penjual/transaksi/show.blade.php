@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Detail Transaksi #{{ $t->transaksi_id }}</h2>
    <p>User: {{ optional($t->user)->name }}</p>
    <p>Menu: {{ optional($t->menu)->nama_menu }}</p>
    <p>Waktu: {{ $t->waktu_transaksi }}</p>
    <p>Jumlah: {{ $t->jumlah }}</p>
    <p>Total: {{ $t->total_harga }}</p>

    <form method="POST" action="{{ route('penjual.transaksi.updateStatus', $t->transaksi_id) }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Ubah Status</label>
            <select name="status_transaksi" class="form-control">
                <option value="diproses" {{ $t->status_transaksi=='diproses' ? 'selected' : '' }}>Diproses</option>
                <option value="selesai" {{ $t->status_transaksi=='selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="dibatalkan" {{ $t->status_transaksi=='dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
            </select>
        </div>
        <button class="btn btn-primary">Update Status</button>
    </form>

    <hr class="my-4">
    <h4>Bukti Pembayaran</h4>
    @if($t->bukti_pembayaran)
        <div class="mb-3">
            <img src="{{ asset('storage/'.$t->bukti_pembayaran) }}" class="max-w-xs rounded" alt="bukti">
        </div>
    @else
        <p>Tidak ada bukti pembayaran.</p>
    @endif

    @if($t->status_transaksi == 'menunggu_konfirmasi')
        <div class="flex space-x-2 mt-3">
            <form method="POST" action="{{ route('penjual.transaksi.updateStatus', $t->transaksi_id) }}">
                @csrf
                <input type="hidden" name="status_transaksi" value="sedang_dibuat">
                <button class="btn btn-success">Terima & Proses (Sedang dibuat)</button>
            </form>
            <form method="POST" action="{{ route('penjual.transaksi.updateStatus', $t->transaksi_id) }}">
                @csrf
                <input type="hidden" name="status_transaksi" value="dibatalkan">
                <button class="btn btn-danger">Tolak / Batalkan</button>
            </form>
        </div>
    @endif

    @if($t->status_transaksi == 'sedang_dibuat')
        <div class="mt-4">
            <form method="POST" action="{{ route('penjual.transaksi.updateStatus', $t->transaksi_id) }}">
                @csrf
                <input type="hidden" name="status_transaksi" value="siap">
                <button class="btn btn-warning">Tandai Siap / Siap Diambil</button>
            </form>
        </div>
    @endif
</div>
@endsection
