@extends('layout.v_template') 

@section('content')
<style>
    #calendar {
        max-width: 900px;
        margin: 20px auto;
        font-size: 14px;
        box-shadow: 0 2px 8px rgb(0 0 0 / 0.1);
        border-radius: 8px;
        background: white;
        padding: 15px;
    }
    .calendar-wrapper {
        max-width: 900px;
        margin: 0 auto 40px auto;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .legend {
        margin-top: 20px;
        width: 100%;
        display: flex;
        justify-content: center;
        gap: 15px;
        flex-wrap: wrap;
        font-family: Arial, sans-serif;
        font-size: 14px;
        color: #444;
        user-select: none;
    }
    .legend-item {
        display: flex;
        align-items: center;
        gap: 8px;
        padding: 6px 14px;
        border-radius: 5px;
        background: #f9f9f9;
        box-shadow: 0 0 5px rgb(0 0 0 / 0.1);
        cursor: pointer;
        transition: background-color 0.3s ease;
        user-select: none;
    }
    .legend-item:hover {
        background-color: #e0e0e0;
    }
    .legend-item.active {
        background-color: #ddd;
        font-weight: 600;
    }
    .legend-color {
        width: 22px;
        height: 22px;
        border-radius: 6px;
        flex-shrink: 0;
        box-shadow: 0 0 8px rgba(0,0,0,0.1);
    }
    #statusModal {
        display: none;
        position: fixed;
        top: 25%;
        left: 50%;
        transform: translateX(-50%);
        background: #fff;
        padding: 20px;
        border: 1px solid #ccc;
        box-shadow: 0 0 10px rgb(0 0 0 / 0.2);
        z-index: 1000;
        border-radius: 8px;
        width: 280px;
    }
</style>

<h2 style="text-align:center;">Kelola Tanggal Booking</h2>

<div class="calendar-wrapper">
    <div id="calendar"></div>

    <div class="legend">
        <div class="legend-item active" data-status="all">
            <div class="legend-color" style="background-color: transparent; border: 1px solid #ccc;"></div> All
        </div>
        <div class="legend-item" data-status="booked">
            <div class="legend-color" style="background-color: rgba(220, 53, 69, 0.4);"></div> Booked
        </div>
        <div class="legend-item" data-status="pending">
            <div class="legend-color" style="background-color: rgba(23, 162, 184, 0.4);"></div> Pending
        </div>
        <div class="legend-item" data-status="cancelled">
            <div class="legend-color" style="background-color: rgba(108, 117, 125, 0.4);"></div> Cancelled
        </div>
        <div class="legend-item" data-status="holiday">
            <div class="legend-color" style="background-color: rgba(255, 193, 7, 0.4);"></div> Holiday
        </div>
    </div>
</div>

<!-- Modal ubah status -->
<div id="statusModal">
    <h4>Ubah Status Tanggal</h4>
    <form id="statusForm">
        <input type="hidden" id="selectedDate" name="tanggal">
        <label for="status">Status:</label>
        <select name="status" id="status" style="margin-left:10px;">
            <option value="available">Tersedia</option>
            <option value="pending">Pending</option>
            <option value="booked">Booked</option>
            <option value="cancelled">Cancelled</option>
            <option value="holiday">Holiday</option>
        </select>
        <br><br>
        <button type="submit" style="margin-right:10px;">Simpan</button>
        <button type="button" onclick="document.getElementById('statusModal').style.display='none'">Batal</button>
    </form>
</div>

<!-- FullCalendar + Axios -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    let allEvents = [
        @foreach($dates as $date)
        {
            title: '{{ ucfirst($date->status === "available" ? "Tersedia" : $date->status) }}',
            start: '{{ $date->tanggal }}',
            status: '{{ $date->status }}',
            color: 
            @switch($date->status)
                @case('pending') 'rgba(23, 162, 184, 0.4)' @break
                @case('booked') 'rgba(220, 53, 69, 0.4)' @break
                @case('cancelled') 'rgba(108, 117, 125, 0.4)' @break
                @case('holiday') 'rgba(255, 193, 7, 0.4)' @break
                @default 'transparent'
            @endswitch,
            textColor: '{{ $date->status === "available" ? "#343a40" : "#000" }}'
        },
        @endforeach
    ];

    let calendarEl = document.getElementById('calendar');
    let calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        height: 'auto',
        selectable: true,
        events: allEvents,
        dateClick: function(info) {
            document.getElementById('selectedDate').value = info.dateStr;

            // Cari status tanggal yang dipilih, default ke available (tidak berwarna)
            let selectedEvent = allEvents.find(e => e.start === info.dateStr);
            let status = selectedEvent ? selectedEvent.status : 'available';

            document.getElementById('status').value = status;
            document.getElementById('statusModal').style.display = 'block';
        }
    });
    calendar.render();

    // Filter legend
    document.querySelectorAll('.legend-item').forEach(item => {
        item.addEventListener('click', function() {
            let status = this.getAttribute('data-status');

            if (status === 'all') {
                document.querySelectorAll('.legend-item').forEach(i => i.classList.add('active'));
                filterEvents('all');
                return;
            }

            // Nonaktifkan semua legend dulu
            document.querySelectorAll('.legend-item').forEach(i => i.classList.remove('active'));

            // Aktifkan legend yang diklik saja
            this.classList.add('active');

            // Filter event sesuai status legend yang diklik
            filterEvents(status);
        });
    });

    // Submit ubah status
    document.getElementById('statusForm').addEventListener('submit', function (e) {
        e.preventDefault();
        let tanggal = document.getElementById('selectedDate').value;
        let status = document.getElementById('status').value;

        // Jika status 'available', artinya hapus status (hapus warna)
        axios.post('{{ route('admin.dates.updateStatus') }}', {
            tanggal: tanggal,
            status: status,
            _token: '{{ csrf_token() }}'
        })
        .then(res => {
            alert(res.data.message);
            location.reload();
        })
        .catch(err => {
            alert('Gagal update status!');
            console.error(err);
        });

        document.getElementById('statusModal').style.display = 'none';
    });

    function filterEvents(status) {
        let filtered = (status === 'all') ? allEvents : allEvents.filter(e => e.status === status);
        calendar.removeAllEvents();
        calendar.addEventSource(filtered);
    }
});
</script>

@endsection
