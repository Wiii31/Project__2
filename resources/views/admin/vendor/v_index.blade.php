@extends('layout.v_template')

@section('content')
<div class="container">
    <h2>Data Vendor</h2>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Email</th>
                <th>Telepon</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
                    @forelse($vendors as $i => $v)
                    <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $v->pengguna->nama ?? '-' }}</td>
            <td>{{ $v->kategori }}</td>
            <td>{{ $v->pengguna->email ?? '-' }}</td>
            <td>{{ $v->pengguna->no_hp ?? '-' }}</td>
            <td>
                @if($v->status == 'aktif')
                    <span class="badge bg-success">Aktif</span>
                @else
                    <span class="badge bg-secondary">Nonaktif</span>
                @endif
            </td>
            <td>

                    <a href="{{ route('admin.vendor.show', $v->id) }}" class="btn btn-info btn-sm">Detail</a>

                    <form action="{{ route('admin.vendor.toggleStatus', $v->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('PUT')
                        <button type="submit" 
                                class="btn btn-sm {{ $v->status == 'aktif' ? 'btn-warning' : 'btn-success' }}"
                                onclick="return confirm('Yakin ingin {{ $v->status == 'aktif' ? 'nonaktifkan' : 'aktifkan' }} vendor ini?')">
                            {{ $v->status == 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}
                        </button>
                    </form>

                    <form action="{{ route('admin.vendor.destroy', $v->id) }}" method="POST" style="display:inline-block;" 
                        onsubmit="return confirm('Yakin ingin menghapus vendor ini?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Hapus</button>
                    </form>

                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">Data vendor belum tersedia.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
