@extends('layout.v_template')

@section('content')
<div class="container">
    <h2>Daftar Kegiatan</h2>
    <a href="{{ route('admin.event.create') }}" class="btn btn-primary mb-3">
    <i class="bi bi-plus-circle"></i> Tambah Kegiatan
</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Klien</th>
                <th>Lokasi</th>
                <th>Tanggal</th>
                <th>Jadwal & Penugasan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($events as $e)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $e->client }}</td>
                <td>{{ $e->location }}</td>
                <td>{{ $e->event_date }}</td>
                <td>
                    <ul>
                        @foreach($e->schedules as $s)
                            <li>
                                <strong>{{ $s->time }}</strong> - {{ $s->activity }}
                                @if($s->assignment)
                                    <br><em>PJ: {{ $s->assignment->pj }} ({{ $s->assignment->role }})</em>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </td>
                <td>
                    <a href="{{ route('admin.event.show', $e->id) }}" class="btn btn-info btn-sm">Detail</a>
                    <a href="{{ route('admin.event.edit', $e->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('admin.event.destroy', $e->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
