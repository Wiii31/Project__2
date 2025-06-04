@extends('layout.v_template')

@section('content')
<div class="container">
    <h2>Edit Kegiatan</h2>

    <form action="{{ route('admin.event.update', $event->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="client" class="form-label">Klien</label>
            <input type="text" id="client" name="client" class="form-control" value="{{ $event->client }}" required>
        </div>

        <div class="mb-3">
            <label for="location" class="form-label">Lokasi</label>
            <input type="text" id="location" name="location" class="form-control" value="{{ $event->location }}" required>
        </div>

        <div class="mb-3">
            <label for="event_date" class="form-label">Tanggal Kegiatan</label>
            <input type="date" id="event_date" name="event_date" class="form-control" value="{{ $event->event_date }}" required>
        </div>

        <hr>
        <h4>Jadwal & Penugasan</h4>
        <div id="jadwal-container">
            @foreach($event->schedules as $i => $schedule)
            <div class="row jadwal-item mb-2">
                <input type="hidden" name="schedule_id[]" value="{{ $schedule->id }}">
                <div class="col">
                    <input type="time" name="schedule_time[]" class="form-control" value="{{ $schedule->time }}" required>
                </div>
                <div class="col">
                    <select name="schedule_activity[]" class="form-control" required>
                        <option value="">-- Pilih Aktivitas --</option>
                        @foreach($activities as $a)
                            <option value="{{ $a->id }}" {{ $schedule->activity_id == $a->id ? 'selected' : '' }}>{{ $a->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <select name="staff_id[]" class="form-control" required>
                        <option value="">-- Penanggung Jawab --</option>
                        @foreach($staffs as $staff)
                            <option value="{{ $staff->id }}" {{ optional($schedule->assignments->first())->staff_id == $staff->id ? 'selected' : '' }}>
                                {{ $staff->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <input type="text" name="role[]" class="form-control" placeholder="Peran" value="{{ optional($schedule->assignments->first())->role }}" required>
                </div>
                <div class="col">
                    <button type="button" class="btn btn-danger remove-jadwal">-</button>
                </div>
            </div>
            @endforeach
        </div>

        <button type="button" class="btn btn-secondary" id="add-jadwal">+ Tambah Jadwal</button>
        <br><br>
        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('admin.event.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>

{{-- Script untuk tambah & hapus --}}
<script>
    document.getElementById('add-jadwal').addEventListener('click', function () {
        const container = document.getElementById('jadwal-container');
        const item = container.querySelector('.jadwal-item');
        const clone = item.cloneNode(true);
        clone.querySelectorAll('input, select').forEach(el => el.value = '');
        container.appendChild(clone);
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-jadwal')) {
            const item = e.target.closest('.jadwal-item');
            const container = document.getElementById('jadwal-container');
            if (container.querySelectorAll('.jadwal-item').length > 1) {
                item.remove();
            }
        }
    });
</script>
@endsection
