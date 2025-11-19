@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <h4>Buat User</h4>
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
            </div>
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" value="1" id="is_penjual" name="is_penjual" {{ old('is_penjual') ? 'checked' : '' }}>
                <label class="form-check-label" for="is_penjual">Daftarkan sebagai <strong>Penjual</strong></label>
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="{{ old('email') }}">
            </div>
            <div id="lapak-fields" style="display: none;">
                <hr>
                <h6>Informasi Lapak (jika mendaftar sebagai Penjual)</h6>
                <div class="mb-3">
                    <label class="form-label">Nama Lapak</label>
                    <input type="text" name="nama_lapak" class="form-control" value="{{ old('nama_lapak') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Pemilik</label>
                    <input type="text" name="pemilik" class="form-control" value="{{ old('pemilik') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">No HP Pemilik</label>
                    <input type="text" name="no_hp_pemilik" class="form-control" value="{{ old('no_hp_pemilik') }}">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control">
                <small class="text-muted">Kosongkan jika tidak ingin mengubah password.</small>
            </div>
            <button class="btn btn-primary">Simpan</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    (function(){
        const checkbox = document.getElementById('is_penjual');
        const lapakFields = document.getElementById('lapak-fields');
        function toggle(){
            lapakFields.style.display = checkbox.checked ? 'block' : 'none';
        }
        checkbox.addEventListener('change', toggle);
        // initial
        toggle();
    })();
</script>
@endpush
