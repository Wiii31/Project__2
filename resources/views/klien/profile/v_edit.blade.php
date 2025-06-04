
@extends('layout.v_template4')

@section('content')
<div class="container py-4">
    <h2 class="mb-4">Edit Profil Saya</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('klien.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Data Pengguna --}}
        <div class="mb-3">
            <label for="nama" class="form-label">Nama</label>
            <input type="text" id="nama" name="nama" class="form-control @error('nama') is-invalid @enderror" 
                   value="{{ old('nama', $klien->pengguna->nama) }}" required>
            @error('nama')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                   value="{{ old('email', $klien->pengguna->email) }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat</label>
            <textarea id="alamat" name="alamat" class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat', $klien->pengguna->alamat) }}</textarea>
            @error('alamat')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="no_hp" class="form-label">No HP</label>
            <input type="text" id="no_hp" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" 
                   value="{{ old('no_hp', $klien->pengguna->no_hp) }}">
            @error('no_hp')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password Baru (kosongkan jika tidak ingin ganti)</label>
            <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" >
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
        </div>

        {{-- Data tambahan klien --}}
        <hr>
        <h5>Data Tambahan Klien</h5>

        <div class="mb-3">
            <label for="nama_pasangan" class="form-label">Nama Pasangan</label>
            <input type="text" id="nama_pasangan" name="nama_pasangan" class="form-control @error('nama_pasangan') is-invalid @enderror" 
                   value="{{ old('nama_pasangan', $klien->nama_pasangan) }}">
            @error('nama_pasangan')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="no_ktp" class="form-label">No. KTP</label>
            <input type="text" id="no_ktp" name="no_ktp" class="form-control @error('no_ktp') is-invalid @enderror" 
                   value="{{ old('no_ktp', $klien->no_ktp) }}">
            @error('no_ktp')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="alamat_akad" class="form-label">Alamat Akad</label>
            <textarea id="alamat_akad" name="alamat_akad" class="form-control @error('alamat_akad') is-invalid @enderror">{{ old('alamat_akad', $klien->alamat_akad) }}</textarea>
            @error('alamat_akad')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="alamat_resepsi" class="form-label">Alamat Resepsi</label>
            <textarea id="alamat_resepsi" name="alamat_resepsi" class="form-control @error('alamat_resepsi') is-invalid @enderror">{{ old('alamat_resepsi', $klien->alamat_resepsi) }}</textarea>
            @error('alamat_resepsi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Upload foto --}}
        <div class="mb-3">
            <label for="foto" class="form-label">Foto Klien</label><br>
            @if($klien->foto)
                <img src="{{ asset('images/foto_klien/' . $klien->foto) }}" alt="Foto Klien" class="img-thumbnail mb-2" style="width:150px; height:150px; object-fit: cover;">
            @endif
            <input type="file" id="foto" name="foto" class="form-control @error('foto') is-invalid @enderror">
            @error('foto')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>


<style>
    /* Card style not used in this form, so removed */
    .form-label {
        font-weight: 600;
    }
    .form-control,
    .form-select {
        border-radius: 0.5rem;
        border: 1px solid #000 !important;
        padding: 0.5rem 1rem;
        background-color: #fff;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }
    .form-control:focus,
    .form-select:focus {
        border-color: #000;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.25);
        outline: none;
    }
    .img-thumbnail {
        border-radius: 0.5rem;
        object-fit: cover;
    }
    /* Small spacing for buttons */
    #add-rab {
        margin-bottom: 1rem;
    }
</style>
@endsection
