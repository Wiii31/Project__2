<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\PackageRab;
use App\Models\VendorService;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class c_package extends Controller
{
    public function index(Request $request)
    {
        $type = $request->get('type');

        $packages = Package::with(['packageRabs.vendorService.vendor']);

        if ($type) {
            $packages->where('type', $type);
        }

        $packages = $packages->get();

        return view('admin.package.v_kelolapaket', compact('packages'));
    }

   public function create()
    {
        $vendorServices = VendorService::with('vendor')->get(); // ambil relasi vendor juga
        return view('admin.package.v_createpaket', compact('vendorServices'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga_total' => 'required|numeric',
            'type' => 'required|in:paket,jasa',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'packageRabs.*.nama_item' => 'nullable|string',
            'packageRabs.*.harga_item' => 'nullable|numeric',
            'packageRabs.*.vendor_service_id' => 'nullable|exists:vendor_services,id'
        ]);

        $foto = null;
        if ($request->hasFile('foto')) {
            $foto = $this->handleFotoUpload($request->file('foto'));
        }

        DB::transaction(function () use ($request, $foto) {
            $package = Package::create([
                'nama' => $request->nama,
                'deskripsi' => $request->deskripsi,
                'harga_total' => $request->harga_total,
                'type' => $request->type,
                'foto' => $foto,
            ]);

            if ($request->type === 'paket' && $request->has('packageRabs')) {
                foreach ($request->packageRabs as $rab) {
                    if (!empty($rab['nama_item']) && !empty($rab['harga_item'])) {
                        PackageRab::create([
                            'package_id' => $package->id,
                            'nama_item' => $rab['nama_item'],
                            'harga_item' => $rab['harga_item'],
                            'vendor_service_id' => $rab['vendor_service_id'] ?? null,
                        ]);
                    }
                }
            }
        });

        return redirect()->route('admin.package.index')->with('success', 'Paket berhasil ditambahkan.');
    }

    public function show($id)
    {
        $package = Package::with(['packageRabs.vendorService.vendor'])->findOrFail($id);
        return view('admin.package.v_detailpaket', compact('package'));
    }

    public function edit($id)
    {
        $package = Package::with(['packageRabs.vendorService.vendor'])->findOrFail($id);
        $vendorServices = VendorService::with('vendor')->get();
        return view('admin.package.v_editpaket', compact('package', 'vendorServices'));
    }

    // Di dalam update method
   public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'harga_total' => 'required|numeric|min:0',
            'type' => 'required|in:jasa,paket',
            'deskripsi' => 'nullable|string',
        ]);

        $package = Package::findOrFail($id);
        $package->nama = $request->nama;
        $package->harga_total = $request->harga_total;
        $package->type = $request->type;
        $package->deskripsi = $request->deskripsi;
        $package->save();

        // handle RAB jika tipe = paket
        if ($request->type === 'paket') {
            $package->packageRabs()->delete(); // hapus data lama

            $vendorIds = $request->input('packageRabs.vendor_service_id', []);
            $hargaItems = $request->input('packageRabs.harga_item', []);
            $deskripsis = $request->input('packageRabs.deskripsi', []);

            foreach ($vendorIds as $i => $vendorId) {
                $package->packageRabs()->create([
                    'vendor_service_id' => $vendorId,
                    'harga_item' => $hargaItems[$i],
                    'deskripsi' => $deskripsis[$i] ?? null,
                ]);
            }
        }

        return redirect()->route('admin.package.index')->with('success', 'Paket berhasil diperbarui');
    }



    public function destroy($id)
    {
        $package = Package::findOrFail($id);

        if ($package->foto && file_exists(public_path('images/foto_paket/' . $package->foto))) {
            unlink(public_path('images/foto_paket/' . $package->foto));
        }

        PackageRab::where('package_id', $package->id)->delete();
        $package->delete();

        return redirect()->route('admin.package.index')->with('success', 'Paket berhasil dihapus.');
    }

    /**
     * Fungsi bantu untuk upload foto dan hapus foto lama jika ada
     *
     * @param \Illuminate\Http\UploadedFile $fotoFile
     * @param string|null $oldFoto
     * @return string $filename
     */
    private function handleFotoUpload($fotoFile, $oldFoto = null)
    {
        if ($oldFoto && file_exists(public_path('images/foto_paket/' . $oldFoto))) {
            unlink(public_path('images/foto_paket/' . $oldFoto));
        }

        $filename = time() . '_' . Str::random(10) . '.' . $fotoFile->extension();
        $fotoFile->move(public_path('images/foto_paket'), $filename);

        return $filename;
    }
}
