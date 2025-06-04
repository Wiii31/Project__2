@extends('layout.v_template4')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-center">Profil Saya</h2>

    <div class="card shadow-sm border-0 mx-auto" style="max-width: 600px;">
        <div class="card-body text-center">
            @if($klien->foto)
                <img src="{{ asset('images/foto_klien/' . $klien->foto) }}" alt="Foto Klien" class="img-thumbnail mb-4" style="width:180px; height:180px; object-fit: cover;">
            @else
                <img src="{{ asset('images/foto_klien/default.png') }}" alt="Foto Default" class="img-thumbnail mb-4" style="width:180px; height:180px; object-fit: cover;">
            @endif

            @php
                $fields = [
                    'Nama' => $klien->pengguna->nama,
                    'Email' => $klien->pengguna->email,
                    'Alamat' => $klien->pengguna->alamat ?? '-',
                    'No HP' => $klien->pengguna->no_hp ?? '-',
                    'Nama Pasangan' => $klien->nama_pasangan ?? '-',
                    'No. KTP' => $klien->no_ktp ?? '-',
                    'Alamat Akad' => $klien->alamat_akad ?? '-',
                    'Alamat Resepsi' => $klien->alamat_resepsi ?? '-',
                ];
            @endphp

            <div class="row justify-content-center text-start">
                @foreach($fields as $label => $value)
                    <div class="col-5 col-sm-4 fw-semibold text-end pe-3 mb-3">{{ $label }}</div>
                    <div class="col-7 col-sm-6">{{ $value }}</div>
                @endforeach
            </div>

            <div class="mt-4">
                <a href="{{ route('klien.profile.edit') }}" class="btn btn-outline-primary">✏️ Edit Profil</a>
            </div>
        </div>
    </div>
</div>

<style>
    .img-thumbnail {
        border-radius: 0.5rem;
        object-fit: cover;
    }
    /* Optional: highlight label */
    .fw-semibold {
        font-weight: 600;
    }
</style>
@endsection
