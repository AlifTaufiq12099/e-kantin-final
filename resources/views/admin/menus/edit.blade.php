@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <h4>Edit Menu</h4>
        <form method="POST" action="{{ route('admin.menus.update', $menu->menu_id) }}">
        <form method="POST" action="{{ route('admin.menus.update', $menu->menu_id) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label">Nama Menu</label>
                <input type="text" name="nama_menu" class="form-control" value="{{ old('nama_menu', $menu->nama_menu) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control">{{ old('deskripsi', $menu->deskripsi) }}</textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Harga</label>
                <input type="number" step="0.01" name="harga" class="form-control" value="{{ old('harga', $menu->harga) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Kategori</label>
                <input type="text" name="kategori" class="form-control" value="{{ old('kategori', $menu->kategori) }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Stok</label>
                <input type="number" name="stok" class="form-control" value="{{ old('stok', $menu->stok) }}">
            </div>
            <div class="mb-3">
                <label class="form-label">Foto Menu (opsional)</label>
                @if(!empty($menu->image))
                    <div class="mb-2">
                        <img src="{{ asset('storage/'.$menu->image) }}" alt="{{ $menu->nama_menu }}" style="max-height:120px;">
                    </div>
                @endif
                <input type="file" name="image" accept="image/*" class="form-control @error('image') is-invalid @enderror">
                @error('image') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Lapak (ID)</label>
                <input type="number" name="lapak_id" class="form-control" value="{{ old('lapak_id', $menu->lapak_id) }}">
            </div>
            <button class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.menus.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
