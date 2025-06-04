@extends('layout.v_template4')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-center">Daftar Booking Saya</h2>

    @if($bookings->isEmpty())
        <div class="alert alert-info text-center">
            Belum ada booking yang dilakukan.
        </div>
    @else
        <div class="list-group">
            @foreach($bookings as $booking)
                <div class="list-group-item mb-3 shadow-sm rounded">
                    <h5 class="mb-1">Paket: {{ $booking->package->nama }}</h5>
                    <p class="mb-1">
                        <strong>Tanggal Booking:</strong> {{ \Carbon\Carbon::parse($booking->date->tanggal)->format('d M Y') }} <br>
                        <strong>Nama Klien:</strong> {{ $booking->pengguna->klien->nama_pasangan ?? $booking->pengguna->nama }} <br>
                        <strong>Status:</strong> 
                        @if($booking->status == 'pending')
                            <span class="badge bg-warning text-dark">Pending</span>
                        @elseif($booking->status == 'booked')
                            <span class="badge bg-success">Booked</span>
                        @elseif($booking->status == 'cancelled')
                            <span class="badge bg-danger">Cancelled</span>
                        @else
                            <span class="badge bg-secondary">{{ ucfirst($booking->status) }}</span>
                        @endif
                    </p>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
