@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <h4>Edit Lapak</h4>
        <form method="POST" action="{{ route('admin.lapaks.update', $lapak->lapak_id) }}">
            @csrf @method('PUT')
            <div class="mb-3">
                <label class="form-label">Nama Lapak</label>
                <input type="text" name="nama_lapak" class="form-control" value="{{ old('nama_lapak', $lapak->nama_lapak) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Pemilik</label>
                <input type="text" name="pemilik" class="form-control" value="{{ old('pemilik', $lapak->pemilik) }}">
            </div>
            <div class="mb-3">
                <label class="form-label">No HP Pemilik</label>
                <input type="text" name="no_hp_pemilik" class="form-control" value="{{ old('no_hp_pemilik', $lapak->no_hp_pemilik) }}">
            </div>
            <button class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.lapaks.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection
