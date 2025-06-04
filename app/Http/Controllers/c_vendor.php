<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vendor;
use Illuminate\Support\Facades\Storage;

class c_vendor extends Controller
{
    public function index()
    {
        $vendors = Vendor::all();
        return view('admin.vendor.v_index', compact('vendors'));
    }

    public function show($id)
    {
        $vendor = Vendor::findOrFail($id);
        return view('admin.vendor.v_detailvendor', compact('vendor'));
    }

    // Kalau butuh edit status di masa depan tinggal ditambahkan di sini
    // public function updateStatus(Request $request, $id) {...}
    
    public function destroy($id)
    {
        $vendor = Vendor::findOrFail($id);
        $vendor->delete();
        return redirect()->route('admin.vendor.index')->with('success', 'Vendor berhasil dihapus.');
    }
    public function toggleStatus($id)
    {
        $vendor = Vendor::findOrFail($id);
        $vendor->status = $vendor->status == 'aktif' ? 'nonaktif' : 'aktif';
        $vendor->save();

        return redirect()->route('admin.vendor.index')->with('success', 'Status vendor diperbarui.');
    }

}


