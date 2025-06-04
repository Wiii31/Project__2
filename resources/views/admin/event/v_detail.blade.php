@extends('layout.v_template')

@section('content')
<div class="container">
    <h2>Detail Kegiatan</h2>

    <table class="table">
        <tr>
            <th>Klien</th>
            <td>{{ $event->client }}</td>
        </tr>
        <tr>
            <th>Lokasi</th>
            <td>{{ $event->location }}</td>
        </tr>
        <tr>
            <th>Tanggal</th>
            <td>{{ \Carbon\Carbon::parse($event->event_date)->format('d-m-Y') }}</td>
        </tr>
    </table>

    <h4>Jadwal & Penugasan</h4>
    <ul class="list-group">
        @forelse($event->schedules as $schedule)
        <li class="list-group-item">
            <strong>{{ \Carbon\Carbon::parse($schedule->time)->format('H:i') }}</strong> - {{ $schedule->activity }}
            @if($schedule->assignments && $schedule->assignments->count())
                <br>
                @foreach($schedule->assignments as $assignment)
                    <em>PJ: {{ $assignment->pj }} ({{ $assignment->role }})</em><br>
                @endforeach
            @endif
        </li>
        @empty
        <li class="list-group-item text-muted">Belum ada jadwal ditambahkan.</li>
        @endforelse
    </ul>

    <br>
    <a href="{{ route('event.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
