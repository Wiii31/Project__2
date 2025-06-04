@extends('layout.v_template') 

@section('content')
<div class="container">
    <h2>Tambah Paket</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.package.store') }}" method="POST" enctype="multipart/form-data" id="formPaket">
        @csrf
        <div class="mb-3">
            <label for="type" class="form-label">Tipe Paket</label>
            <select name="type" id="type" class="form-select" required>
                <option value="">-- Pilih Tipe --</option>
                <option value="paket" {{ old('type') == 'paket' ? 'selected' : '' }}>Paket</option>
                <option value="jasa" {{ old('type') == 'jasa' ? 'selected' : '' }}>Jasa</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="nama" class="form-label">Nama Paket</label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
        </div>

        <div class="mb-3">
            <label for="deskripsi" class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="harga_total" class="form-label">Harga Total</label>
            <input type="number" name="harga_total" class="form-control" value="{{ old('harga_total') }}" required min="0" step="any">
        </div>

        <div class="mb-3">
            <label for="foto" class="form-label">Foto Paket (jpg, png, max 2MB)</label>
            <input type="file" name="foto" id="foto" class="form-control" accept="image/*">
        </div>

        <div id="rabContainer" style="display: none;">
            <h4>Detail RAB Paket</h4>
            <table class="table table-bordered" id="rabTable">
                <thead>
                    <tr>
                        <th>Nama Item (Vendor Service)</th>
                        <th>Harga Item</th>
                        <th>Deskripsi</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Baris item RAB dinamis muncul di sini -->
                </tbody>
            </table>
            <button type="button" class="btn btn-sm btn-primary" id="addRabBtn">Tambah Item RAB</button>
        </div>

        <button type="submit" class="btn btn-success mt-3">Simpan Paket</button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const typeSelect = document.getElementById('type');
    const rabContainer = document.getElementById('rabContainer');
    const rabTableBody = document.querySelector('#rabTable tbody');
    const addRabBtn = document.getElementById('addRabBtn');

    const vendorServices = @json($vendorServices);

    function toggleRabSection() {
        if (typeSelect.value === 'paket') {
            rabContainer.style.display = 'block';
            if (rabTableBody.children.length === 0) addRabRow();
        } else {
            rabContainer.style.display = 'none';
            rabTableBody.innerHTML = '';
        }
    }

    function addRabRow(selectedId = '', harga = '', deskripsi = '') {
        const row = document.createElement('tr');

        let selectOptions = `<option value="">-- Pilih Item --</option>`;
        vendorServices.forEach(service => {
            const selected = service.id == selectedId ? 'selected' : '';
           selectOptions += `<option value="${service.id}" ${selected}>${service.nama_item} (${service.kategori}) </option>`;


        });

        row.innerHTML = `
            <td>
                <select name="packageRabs[vendor_service_id][]" class="form-select" required>
                    ${selectOptions}
                </select>
            </td>
            <td>
                <input type="number" name="packageRabs[harga_item][]" class="form-control" value="${harga}" min="0" required step="any">
            </td>
            <td>
                <input type="text" name="packageRabs[deskripsi][]" class="form-control" value="${deskripsi}" placeholder="Deskripsi item...">
            </td>
            <td>
                <button type="button" class="btn btn-danger btn-sm removeRabBtn">&times;</button>
            </td>
        `;

        rabTableBody.appendChild(row);

        row.querySelector('.removeRabBtn').addEventListener('click', function () {
            row.remove();
        });
    }

    typeSelect.addEventListener('change', toggleRabSection);

    addRabBtn.addEventListener('click', function () {
        addRabRow();
    });

    toggleRabSection();

    @if(old('packageRabs.vendor_service_id'))
        const oldVendorServiceIds = @json(old('packageRabs.vendor_service_id'));
        const oldHargaItems = @json(old('packageRabs.harga'));
        const oldDeskripsi = @json(old('packageRabs.deskripsi'));
        rabTableBody.innerHTML = '';
        oldVendorServiceIds.forEach((vsid, i) => {
            addRabRow(vsid, oldHargaItems[i], oldDeskripsi[i]);
        });
    @endif
});
</script>
<style>
    /* Card style not used in this form, so removed */
    .form-label {
        font-weight: 600;
    }
    .form-control,
    .form-select {
        border-radius: 0.5rem;
        border: 1px solid #000 !important;
        padding: 0.5rem 1rem;
        background-color: #fff;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }
    .form-control:focus,
    .form-select:focus {
        border-color: #000;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.25);
        outline: none;
    }
    .img-thumbnail {
        border-radius: 0.5rem;
        object-fit: cover;
    }
    /* Small spacing for buttons */
    #add-rab {
        margin-bottom: 1rem;
    }
</style>
@endsection
