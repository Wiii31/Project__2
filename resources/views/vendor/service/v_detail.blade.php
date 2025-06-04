@extends('layout.v_template3')

@section('title', 'Detail Layanan Vendor')

@section('content')
<div class="container mt-4">
    <h2>Detail Layanan Vendor</h2>

    <div class="mb-3">
        <strong>Nama Item:</strong>
        <p>{{ $service->nama_item }}</p>
    </div>

    <div class="mb-3">
        <strong>Deskripsi:</strong>
        <p>{{ $service->deskripsi ?? '-' }}</p>
    </div>

    <div class="mb-3">
        <strong>Harga:</strong>
        <p>Rp {{ number_format($service->harga, 0, ',', '.') }}</p>
    </div>

    <div class="mb-3">
        <strong>Kategori:</strong>
        <p>{{ $service->kategori ?? '-' }}</p>
    </div>

    <div class="mb-3">
        <strong>Foto:</strong><br>
        @if($service->foto && file_exists(public_path('images/vendorservices/' . $service->foto)))
            <img src="{{ asset('images/vendorservices/' . $service->foto) }}" width="200" class="img-thumbnail">
        @else
            <span>-</span>
        @endif
    </div>

    <a href="{{ route('vendor.service.index') }}" class="btn btn-secondary">Kembali</a>
    <a href="{{ route('vendor.service.edit', $service->id) }}" class="btn btn-warning">Edit</a>
</div>
@endsection
