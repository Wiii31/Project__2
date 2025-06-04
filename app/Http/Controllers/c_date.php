<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Date;

class c_date extends Controller
{
    public function index()
    {
        // Ambil semua data tanggal
        $dates = Date::all();
        return view('admin.date.v_kelolatanggal', compact('dates'));
    }

    public function updateStatus(Request $request)
    {
        // Validasi input, sekarang status juga bisa 'available'
        $request->validate([
            'tanggal' => 'required|date',
            'status' => 'required|in:booked,cancelled,pending,holiday,available',
        ]);

        try {
            if ($request->status === 'available') {
                // Jika status available, hapus data tanggal kalau ada
                Date::where('tanggal', $request->tanggal)->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Tanggal berhasil dihapus dari status (tersedia).',
                ]);
            } else {
                // Jika status selain available, update atau buat baru
                $date = Date::updateOrCreate(
                    ['tanggal' => $request->tanggal],
                    ['status' => $request->status]
                );

                return response()->json([
                    'success' => true,
                    'message' => 'Status tanggal berhasil diupdate',
                    'data' => $date
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal update status: '.$e->getMessage()
            ], 500);
        }
    }
}
