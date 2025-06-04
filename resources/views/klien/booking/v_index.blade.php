@extends('layout.v_template4')

@section('content')
<div class="container py-5">
    <h2 class="fw-bold text-center mb-5 text-primary">Pilih Paket Pernikahan</h2>

    {{-- Filter --}}
    <form method="GET" class="row g-3 mb-5 justify-content-center">
        <div class="col-md-4">
            <input type="text" name="search" class="form-control rounded-pill border-primary" placeholder="Cari nama paket..." value="{{ request('search') }}">
        </div>
        <div class="col-md-3">
            <input type="number" name="budget" class="form-control rounded-pill border-primary" placeholder="Budget maksimal (Rp)" value="{{ request('budget') }}">
        </div>
        <div class="col-md-2">
            <button class="btn btn-primary w-100 rounded-pill">Filter</button>
        </div>
    </form>

    {{-- Kelompokkan berdasarkan type --}}
    @php
        $grouped = $packages->groupBy('type');
    @endphp

    @forelse ($grouped as $type => $items)
        <h4 class="fw-bold text-uppercase text-primary mt-5 mb-4 border-bottom pb-2">{{ ucfirst($type) }}</h4>

        <div class="row row-cols-1 row-cols-md-3 g-4">
            @foreach ($items as $item)
                <div class="col">
                    <div class="card h-100 shadow rounded-4 border-0">
                        @if ($item->foto)
                            <img src="{{ asset('images/foto_paket/' . $item->foto) }}" class="card-img-top rounded-top-4" alt="{{ $item->nama }}" style="height: 240px; object-fit: cover;">
                        @endif
                        <div class="card-body p-4">
                            <h5 class="card-title text-capitalize fw-bold text-primary fs-5">{{ $item->nama }}</h5>
                            <p class="text-danger fw-bold fs-5 mb-2">Rp {{ number_format($item->harga_total, 0, ',', '.') }}</p>
                            <p class="card-text text-muted mb-3" style="min-height: 50px">{{ $item->deskripsi }}</p>

                            <h6 class="fw-semibold text-secondary mb-2">RAB Ringkas:</h6>
                            @if ($item->packageRabs->count())
                                <div class="table-responsive">
                                    <table class="table table-sm table-bordered mb-3">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="text-nowrap">Nama Item</th>
                                                <th class="text-end text-nowrap">Harga (Rp)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($item->packageRabs->take(2) as $rab)
                                                <tr>
                                                    <td>
                                                        <div class="fw-semibold">{{ $rab->nama_item }}</div>
                                                        <div class="text-muted small">{{ $rab->deskripsi }}</div>
                                                    </td>
                                                    <td class="text-end">{{ number_format($rab->harga_item, 0, ',', '.') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="fst-italic text-muted">Belum ada RAB.</p>
                            @endif
                        </div>
                        <div class="card-footer bg-white border-0 d-flex justify-content-between px-4 pb-4">
                            <a href="{{ url('klien/booking/create/'.$item->id) }}" class="btn btn-success rounded-pill px-4">Pilih Tanggal</a>
                            <button class="btn btn-outline-danger rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#detailModal{{ $item->id }}">Lihat Detail</button>
                        </div>
                    </div>
                </div>

                {{-- Modal Detail --}}
                <div class="modal fade" id="detailModal{{ $item->id }}" tabindex="-1" aria-labelledby="detailModalLabel{{ $item->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                        <div class="modal-content rounded-4">
                            <div class="modal-header bg-primary text-white rounded-top-4">
                                <h5 class="modal-title" id="detailModalLabel{{ $item->id }}">{{ $item->nama }}</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    @if ($item->foto)
                                        <div class="col-md-5 mb-3 mb-md-0">
                                            <img src="{{ asset('images/foto_paket/' . $item->foto) }}" alt="{{ $item->nama }}" class="img-fluid rounded-4 shadow-sm">
                                        </div>
                                    @endif
                                    <div class="col-md-7">
                                        <p class="fw-bold text-danger fs-4 mb-2">Rp {{ number_format($item->harga_total, 0, ',', '.') }}</p>
                                        <p>{{ $item->deskripsi }}</p>
                                    </div>
                                </div>

                                <hr>

                                <h6 class="fw-bold text-primary mb-3">Rincian RAB:</h6>
                                @if($item->packageRabs->count())
                                    <table class="table table-bordered table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Nama Item</th>
                                                <th class="text-end">Harga (Rp)</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($item->packageRabs as $rab)
                                                <tr>
                                                    <td>
                                                        <div><strong>{{ $rab->nama_item }}</strong></div>
                                                        <div class="text-muted small">{{ $rab->deskripsi }}</div>
                                                    </td>
                                                    <td class="text-end">{{ number_format($rab->harga_item, 0, ',', '.') }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <p class="fst-italic text-muted">Belum ada rincian RAB.</p>
                                @endif
                            </div>
                            <div class="modal-footer">
                                <a href="{{ url('klien/booking/create/'.$item->id) }}" class="btn btn-success rounded-pill px-4">Pilih Tanggal</a>
                                <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- End Modal --}}
            @endforeach
        </div>

    @empty
        <p class="text-center text-muted fs-5 mt-5">Tidak ada paket ditemukan.</p>
    @endforelse
</div>
@endsection
