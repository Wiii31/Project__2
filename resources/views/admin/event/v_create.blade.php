@extends('layout.v_template')

@section('content')
<div class="container">
    <h2>Tambah Kegiatan</h2>

    <form action="{{ route('admin.event.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="client" class="form-label">Klien</label>
            <input type="text" id="client" name="client" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="location" class="form-label">Lokasi</label>
            <input type="text" id="location" name="location" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="event_date" class="form-label">Tanggal Kegiatan</label>
            <input type="date" id="event_date" name="event_date" class="form-control" required>
        </div>

        <hr>
        <h4>Jadwal & Penugasan</h4>
        <div id="jadwal-container">
            <div class="row jadwal-item mb-2">
                <div class="col">
                    <input type="time" name="schedule_time[]" class="form-control" required>
                </div>
                <div class="col">
                    <select name="schedule_activity[]" class="form-control" required>
                        <option value="">-- Pilih Aktivitas --</option>
                        @foreach($activities as $a)
                            <option value="{{ $a->id }}">{{ $a->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <select name="staff_id[]" class="form-control" required>
                        <option value="">-- Pilih Penanggung Jawab --</option>
                        @foreach($staffs as $staff)
                            <option value="{{ $staff->id }}">{{ $staff->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <select name="role[]" class="form-control" required>
                        <option value="">-- Pilih Peran --</option>
                        @foreach($roles as $r)
                            <option value="{{ $r }}">{{ $r }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <button type="button" class="btn btn-danger remove-jadwal">-</button>
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-secondary" id="add-jadwal">+ Tambah Jadwal</button>
        <br><br>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('admin.event.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>

{{-- Script untuk tambah dan hapus jadwal --}}
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

{{-- Styling tambahan --}}
<style>
    .card {
        border: none;
        box-shadow: 0 0 20px rgba(0,0,0,0.08);
        border-radius: 10px;
    }

    .form-label {
        font-weight: 500;
    }

    .form-control,
    .form-select {
        border-radius: 8px;
        padding: 0.6rem 1rem;
        border: 1px solid #000 !important;
        background-color: #fff;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #000;
        box-shadow: 0 0 0 0.15rem rgba(0, 0, 0, 0.25);
    }

    .img-thumbnail {
        border-radius: 8px;
        object-fit: cover;
    }
</style>
@endsection
