@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Data Keuangan Lapak Saya</h2>
    <a href="{{ route('penjual.keuangan.create') }}" class="btn btn-primary mb-3">Tambah</a>
    <table class="table">
        <thead><tr><th>ID</th><th>Tanggal</th><th>Jenis</th><th>Jumlah</th><th>Keterangan</th></tr></thead>
        <tbody>
        @foreach($items as $i)
        <tr>
            <td>{{ $i->keuangan_id }}</td>
            <td>{{ $i->tanggal }}</td>
            <td>{{ $i->jenis_transaksi }}</td>
            <td>{{ $i->jumlah_uang }}</td>
            <td>{{ $i->keterangan }}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
    {{ $items->links() }}
</div>
@endsection
