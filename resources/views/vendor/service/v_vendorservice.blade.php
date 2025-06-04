@extends('layout.v_template3')

@section('title', 'Daftar Layanan Vendor')

@section('content')
<div class="container mt-4">
    <h2>Daftar Layanan Vendor</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <a href="{{ route('vendor.service.create') }}" class="btn btn-primary mb-3">Tambah Layanan</a>

    @if($services->count())
    <table class="table table-bordered align-middle">
        <thead class="table-light">
            <tr>
                <th>No</th>
                <th>Nama Item</th>
                <th>Deskripsi</th>
                <th>Harga</th>
                <th>Kategori</th>
                <th>Foto</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($services as $index => $service)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $service->nama_item }}</td>
                <td>{{ $service->deskripsi ?? '-' }}</td>
                <td>Rp {{ number_format($service->harga, 0, ',', '.') }}</td>
                <td>{{ $service->kategori ?? '-' }}</td>
                <td>
                    @if($service->foto && file_exists(public_path('images/vendorservices/' . $service->foto)))
                        <img src="{{ asset('images/vendorservices/' . $service->foto) }}" width="80" class="img-thumbnail">
                    @else
                        <span>-</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('vendor.service.show', $service->id) }}" class="btn btn-info btn-sm">Detail</a>
                    <a href="{{ route('vendor.service.edit', $service->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('vendor.service.destroy', $service->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
        <p>Belum ada layanan vendor yang ditambahkan.</p>
    @endif
</div>
@endsection
