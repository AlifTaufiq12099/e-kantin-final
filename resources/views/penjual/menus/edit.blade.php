@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <h4>Edit Menu (Lapak Saya)</h4>
        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('penjual.menus.update', $menu->menu_id) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label">Nama Menu *</label>
                <input type="text" name="nama_menu" class="form-control @error('nama_menu') is-invalid @enderror" value="{{ old('nama_menu', $menu->nama_menu) }}" required>
                @error('nama_menu') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi', $menu->deskripsi) }}</textarea>
                @error('deskripsi') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Harga *</label>
                <input type="number" step="0.01" name="harga" class="form-control @error('harga') is-invalid @enderror" value="{{ old('harga', $menu->harga) }}" required>
                @error('harga') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Kategori</label>
                <input type="text" name="kategori" class="form-control @error('kategori') is-invalid @enderror" value="{{ old('kategori', $menu->kategori) }}">
                @error('kategori') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Stok</label>
                <input type="number" name="stok" class="form-control @error('stok') is-invalid @enderror" value="{{ old('stok', $menu->stok) }}">
                @error('stok') <span class="invalid-feedback">{{ $message }}</span> @enderror
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
            <button class="btn btn-primary">Simpan</button>
            <a href="{{ route('penjual.menus.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
