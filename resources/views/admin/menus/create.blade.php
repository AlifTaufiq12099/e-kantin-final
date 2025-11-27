@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <h4>Buat Menu</h4>
        <form method="POST" action="{{ route('admin.menus.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nama Menu</label>
                <input type="text" name="nama_menu" class="form-control" value="{{ old('nama_menu') }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control">{{ old('deskripsi') }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Harga</label>
                <input type="number" step="0.01" name="harga" class="form-control" value="{{ old('harga', 0) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Kategori</label>
                <input type="text" name="kategori" class="form-control" value="{{ old('kategori') }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Stok</label>
                <input type="number" name="stok" class="form-control" value="{{ old('stok', 0) }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Foto Menu (opsional)</label>
                <input type="file" name="image" accept="image/*" class="form-control @error('image') is-invalid @enderror">
                @error('image') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Lapak (ID)</label>
                <input type="number" name="lapak_id" class="form-control" value="{{ old('lapak_id') }}">
                <small class="text-muted">Masukkan lapak_id atau kosongkan.</small>
            </div>
            <button class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.menus.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
