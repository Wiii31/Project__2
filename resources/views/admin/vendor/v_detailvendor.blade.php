@extends('layout.v_template')

@section('content')
<div class="container mt-4">
    <h2>Detail Vendor</h2>
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">{{ $vendor->pengguna->nama ?? '-' }}</h4>
        </div>
        <div class="card-body">
            <p><strong>Status:</strong>
                @if($vendor->status == 'aktif')
                    <span class="badge bg-success">Aktif</span>
                @else
                    <span class="badge bg-secondary">Nonaktif</span>
                @endif
            </p>

            <p><strong>Kategori:</strong> {{ $vendor->kategori }}</p>
            
            <p><strong>Deskripsi:</strong><br>{{ $vendor->deskripsi ?? '-' }}</p>

            <p><strong>Email:</strong> {{ $vendor->pengguna->email ?? '-' }}</p>

            <p><strong>Telepon:</strong> {{ $vendor->pengguna->no_hp ?? '-' }}</p>

            <p><strong>Alamat:</strong><br>{{ $vendor->pengguna->alamat ?? '-' }}</p>

            <p><strong>Foto:</strong><br>
                @if($vendor->vendorService && $vendor->vendorService->foto && file_exists(public_path('images/vendorservices/' . $vendor->vendorService->foto)))
                    <img src="{{ asset('images/vendorservices/' . $vendor->vendorService->foto) }}" 
                         alt="Foto {{ $vendor->pengguna->nama ?? '-' }}" class="img-thumbnail" width="250">
                @else
                    <img src="{{ asset('images/no-image.png') }}" alt="No Image" class="img-thumbnail" width="250">
                @endif
            </p>

            <a href="{{ route('admin.vendor.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
        </div>
    </div>
</div>
@endsection
