@extends('layout.v_template4')

@section('content')

<style>
    /* Font elegan untuk nuansa pernikahan */
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display&family=Roboto&display=swap');

    body {
        background: #faf7f5;
        font-family: 'Roboto', sans-serif;
        color: #4a4a4a;
    }

    /* Animasi halus */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(15px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .fade-in-up {
        animation: fadeInUp 0.5s ease forwards;
        opacity: 0;
    }

    /* Container form */
    .booking-container {
        max-width: 460px;
        margin: 3rem auto 4rem;
        background: #fff;
        padding: 2.5rem 3rem;
        border-radius: 14px;
        box-shadow: 0 12px 28px rgba(0,0,0,0.1);
        font-family: 'Roboto', sans-serif;
    }

    /* Judul form */
    .booking-container h2 {
        font-family: 'Playfair Display', serif;
        font-weight: 700;
        font-size: 2.1rem;
        color: #a83f56;
        text-align: center;
        margin-bottom: 2rem;
        letter-spacing: 1.1px;
    }

    /* Label */
    label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        color: #6e4a59;
        font-size: 1rem;
        letter-spacing: 0.02em;
    }

    /* Input wrapper */
    .input-icon-wrapper {
        position: relative;
        margin-bottom: 30px;
    }

    /* Input fields */
    .input-icon-wrapper input {
        width: 100%;
        padding: 14px 44px 14px 16px;
        border: 2px solid #d7b8bc;
        border-radius: 10px;
        font-size: 16px;
        color: #5a4a50;
        background-color: #fcfbfa;
        transition: border-color 0.25s ease, box-shadow 0.25s ease;
        outline-offset: 3px;
        cursor: pointer;
        font-family: 'Roboto', sans-serif;
    }

    .input-icon-wrapper input:focus {
        border-color: #a83f56;
        box-shadow: 0 0 8px #bf6775aa;
        outline: none;
        background-color: #fff;
    }

    /* Kalender icon */
    .input-icon-wrapper svg {
        position: absolute;
        top: 50%;
        right: 16px;
        transform: translateY(-50%);
        width: 20px;
        height: 20px;
        fill: #a83f56;
        pointer-events: none;
    }

    /* Button style */
    button.book-btn {
        width: 100%;
        background: linear-gradient(135deg, #a83f56cc, #bb5a6ecc);
        color: #fff;
        font-weight: 700;
        font-size: 17px;
        padding: 13px 0;
        border: none;
        border-radius: 12px;
        cursor: pointer;
        box-shadow: 0 5px 15px rgba(184, 63, 86, 0.5);
        transition: background 0.3s ease, box-shadow 0.3s ease;
        font-family: 'Playfair Display', serif;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 10px;
    }

    button.book-btn:hover:not(:disabled) {
        background: linear-gradient(135deg, #8b3446cc, #9d4e5bcc);
        box-shadow: 0 7px 20px rgba(157, 78, 91, 0.7);
    }

    button.book-btn:disabled {
        background-color: #c8b0b4;
        cursor: not-allowed;
        box-shadow: none;
    }

    /* Loading spinner */
    .spinner {
        border: 3px solid #f3f3f3;
        border-top: 3px solid #fff;
        border-radius: 50%;
        width: 18px;
        height: 18px;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg);}
        100% { transform: rotate(360deg);}
    }

    /* Error message */
    .error-msg {
        color: #d9534f;
        font-size: 0.9rem;
        margin-top: -22px;
        margin-bottom: 20px;
        font-weight: 600;
        font-family: 'Roboto', sans-serif;
    }

    /* Alert messages */
    .alert {
        padding: 13px 18px;
        border-radius: 10px;
        margin-bottom: 1.7rem;
        font-weight: 600;
        font-family: 'Roboto', sans-serif;
        text-align: center;
        max-width: 460px;
        margin-left: auto;
        margin-right: auto;
        letter-spacing: 0.04em;
    }

    .alert-success {
        background-color: #eaf4f4;
        color: #2e7d7d;
        border: 1px solid #90c9c9;
    }

    .alert-error {
        background-color: #fce8e6;
        color: #a63943;
        border: 1px solid #e19ba1;
    }

    /* Legend container */
    .legend-container {
        max-width: 460px;
        margin: 30px auto 0;
        font-weight: 600;
        color: #5a4a50;
        font-family: 'Roboto', sans-serif;
        letter-spacing: 0.05em;
    }

    .legend-items {
        display: flex;
        flex-wrap: wrap;
        gap: 18px;
        margin-top: 12px;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 8px;
        user-select: none;
        font-size: 0.9rem;
    }

    .legend-color {
        width: 20px;
        height: 20px;
        border-radius: 6px;
        box-shadow: 0 0 6px rgba(0,0,0,0.1);
    }

    .color-booked {
        background-color: rgba(220, 53, 69, 0.4);
        box-shadow: 0 0 8px rgba(220, 53, 69, 0.18);
    }

    .color-pending {
        background-color: rgba(23, 162, 184, 0.4);
        box-shadow: 0 0 8px rgba(23, 162, 184, 0.18);
    }

    .color-cancelled {
        background-color: rgba(108, 117, 125, 0.4);
        box-shadow: 0 0 8px rgba(108, 117, 125, 0.18);
    }

    .color-holiday {
        background-color: rgba(255, 193, 7, 0.4);
        box-shadow: 0 0 8px rgba(255, 193, 7, 0.18);
    }

    .color-available {
        border: 1.5px solid #6c757d;
        background: transparent;
    }

    /* Link kembali */
    .back-link {
        display: inline-block;
        margin-top: 32px;
        background-color: #8c6a73;
        color: white;
        padding: 11px 22px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        font-family: 'Roboto', sans-serif;
        letter-spacing: 0.04em;
        transition: background-color 0.3s ease;
    }
    .back-link:hover {
        background-color: #734f59;
    }

    /* Responsive */
    @media (max-width: 540px) {
        .booking-container {
            margin: 2rem 15px 3rem;
            padding: 2rem 2.2rem;
        }
        .booking-container h2 {
            font-size: 1.75rem;
        }
    }
</style>

<div class="booking-container fade-in-up">

    <h2>Booking Paket: {{ $package->nama }}</h2>

    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form id="bookingForm" method="POST" action="{{ route('klien.booking.store') }}">
        @csrf
        <input type="hidden" name="package_id" value="{{ $package->id }}">

        <div class="input-icon-wrapper">
            <label for="date_id">Pilih Tanggal Acara</label>
            <input 
                type="text" 
                id="date_id" 
                name="date_id" 
                required 
                readonly 
                placeholder="Klik untuk pilih tanggal" 
                autocomplete="off"
            />
            <!-- Kalender icon -->
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
                <path d="M7 10h5v5H7z" opacity=".3"/>
                <path d="M19 4h-1V2h-2v2H8V2H6v2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2zm0 16H5V9h14zM7 11h5v5H7z"/>
            </svg>
        </div>

        <div id="error-date" class="error-msg" style="display:none;">* Harap pilih tanggal acara terlebih dahulu.</div>

    </form>
    <form action="{{ route('klien.booking.list') }}" method="get">
                <button type="submit" class="book-btn">
                    Booking Sekarang
                </button>
    </form>

    <a href="{{ route('klien.booking.index') }}" class="back-link" aria-label="Kembali ke daftar paket">← Kembali ke Daftar Paket</a>

    {{-- Legend Warna --}}
    <div class="legend-container" aria-label="Keterangan warna tanggal">
        <strong>Keterangan Tanggal:</strong>
        <div class="legend-items">
            <div class="legend-item"><div class="legend-color color-booked"></div> Booked</div>
            <div class="legend-item"><div class="legend-color color-pending"></div> Pending</div>
            <div class="legend-item"><div class="legend-color color-cancelled"></div> Cancelled</div>
            <div class="legend-item"><div class="legend-color color-holiday"></div> Holiday</div>
            <div class="legend-item"><div class="legend-color color-available"></div> Available</div>
        </div>
    </div>
</div>

<!-- Flatpickr -->
<link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet"/>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>

<script>
    const bookedDates = @json($bookedDates);

    flatpickr("#date_id", {
        dateFormat: "Y-m-d",
        locale: "id",
        disable: bookedDates
            .filter(d => d.status !== "available")
            .map(d => d.date),
        onDayCreate: function(dObj, dStr, fp, dayElem) {
            const date = dayElem.dateObj.toISOString().split('T')[0];
            const matched = bookedDates.find(d => d.date === date);

            if (matched) {
                if (matched.status === "available") {
                    dayElem.classList.add("flatpickr-available");
                } else if (matched.status === "booked") {
                    dayElem.classList.add("flatpickr-booked");
                } else if (matched.status === "pending") {
                    dayElem.classList.add("flatpickr-pending");
                } else if (matched.status === "cancelled") {
                    dayElem.classList.add("flatpickr-cancelled");
                } else if (matched.status === "holiday") {
                    dayElem.classList.add("flatpickr-holiday");
                }
            }
        },
        minDate: "today",
        maxDate: new Date().fp_incr(365),
        allowInput: false,
    });

    // Validasi dan UI feedback submit
    document.getElementById("bookingForm").addEventListener("submit", function(e){
        const dateInput = document.getElementById("date_id");
        const errorMsg = document.getElementById("error-date");
        const submitBtn = document.getElementById("submitBtn");

        if(!dateInput.value) {
            e.preventDefault();
            errorMsg.style.display = "block";
            dateInput.focus();
            return false;
        } else {
            errorMsg.style.display = "none";

            // Disable tombol dan kasih loading spinner
            submitBtn.disabled = true;
            submitBtn.innerHTML = `<span class="spinner"></span> Memproses...`;
        }
    });
</script>

<style>
    /* Flatpickr colors sesuai legend */
    .flatpickr-available {
        border: 2px solid #6c757d !important;
        background: transparent !important;
    }
    .flatpickr-booked {
        background-color: rgba(220, 53, 69, 0.4) !important;
        box-shadow: 0 0 8px rgba(220, 53, 69, 0.18) !important;
    }
    .flatpickr-pending {
        background-color: rgba(23, 162, 184, 0.4) !important;
        box-shadow: 0 0 8px rgba(23, 162, 184, 0.18) !important;
    }
    .flatpickr-cancelled {
        background-color: rgba(108, 117, 125, 0.4) !important;
        box-shadow: 0 0 8px rgba(108, 117, 125, 0.18) !important;
    }
    .flatpickr-holiday {
        background-color: rgba(255, 193, 7, 0.4) !important;
        box-shadow: 0 0 8px rgba(255, 193, 7, 0.18) !important;
    }
</style>


@endsection
