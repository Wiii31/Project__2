@extends('layout.v_template')

@section('content')
<div class="container">
    <h1 class="mb-4">Kelola Paket</h1>

    {{-- Filter jenis paket --}}
    <div class="mb-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
        <a href="{{ route('admin.package.create') }}" class="btn btn-primary">Tambah Paket</a>

        <select id="filterType" class="form-select w-auto" aria-label="Filter jenis paket">
            <option value="">Semua Jenis Paket</option>
            <option value="paket">Paket</option>
            <option value="jasa">Jasa</option>
        </select>
    </div>

    <div class="row" id="packageContainer">
        @foreach($packages as $package)
        <div class="col-md-4 package-card" data-type="{{ $package->type }}">
            <div class="card mb-4 shadow-sm">
                @if($package->foto && file_exists(public_path('images/foto_paket/' . $package->foto)))
                    <img src="{{ asset('images/foto_paket/' . $package->foto) }}" alt="Foto Paket" 
                        class="card-img-top img-preview cursor-pointer" style="height:200px; object-fit: cover;" data-bs-toggle="modal" data-bs-target="#fotoModal" data-src="{{ asset('images/foto_paket/' . $package->foto) }}">
                @else
                    <img src="{{ asset('images/default.jpg') }}" alt="Default Foto Paket" 
                        class="card-img-top img-preview cursor-pointer" style="height:200px; object-fit: cover;" data-bs-toggle="modal" data-bs-target="#fotoModal" data-src="{{ asset('images/default.jpg') }}">
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $package->nama }}</h5>
                    <p class="card-text" style="min-height: 60px;">{{ Str::limit($package->deskripsi, 100) }}</p>
                    <h6>Total Biaya: <strong>Rp {{ number_format($package->harga_total, 0, ',', '.') }}</strong></h6>

                    @if($package->type == 'paket')
                        <table class="table table-bordered mt-2">
                            <thead class="table-light">
                                <tr>
                                    <th>Komponen Paket</th>
                                    <th>Biaya</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($package->packageRabs as $rab)
                                    <tr>
                                        <td>{{ $rab->vendorService->nama_item ?? '-' }}</td>
                                        <td>Rp {{ number_format($rab->harga_item, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="mt-2">
                            <span class="badge bg-info">Jasa - Tidak Ada RAB</span>
                        </div>
                    @endif

                    <div class="mt-4 text-center d-flex justify-content-center gap-2">
                        <a href="{{ route('admin.package.show', $package->id) }}" class="btn btn-info btn-sm" data-bs-toggle="tooltip" title="Lihat Detail"><i class="bi bi-eye"></i></a>
                        <a href="{{ route('admin.package.edit', $package->id) }}" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" title="Edit Paket"><i class="bi bi-pencil-square"></i></a>
                        <form action="{{ route('admin.package.destroy', $package->id) }}" method="POST" style="display:inline-block" class="form-delete" >
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" title="Hapus Paket"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- Modal Foto Preview --}}
<div class="modal fade" id="fotoModal" tabindex="-1" aria-labelledby="fotoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content bg-dark">
      <div class="modal-body p-0">
        <img src="" alt="Foto Paket" id="modalImage" class="w-100" style="object-fit: contain; max-height: 80vh;">
      </div>
      <div class="modal-footer p-2">
        <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script>
    // Tooltip bootstrap init
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    })

    // Filter paket by type
    document.getElementById('filterType').addEventListener('change', function() {
        const selected = this.value;
        const cards = document.querySelectorAll('.package-card');
        cards.forEach(card => {
            if (!selected || card.dataset.type === selected) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    });

    // Modal preview foto on image click
    document.querySelectorAll('.img-preview').forEach(img => {
        img.addEventListener('click', function() {
            document.getElementById('modalImage').src = this.dataset.src;
        });
    });

    // SweetAlert konfirmasi hapus
    document.querySelectorAll('.form-delete').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Yakin ingin hapus paket ini?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.submit();
                }
            });
        });
    });
</script>
@endsection
