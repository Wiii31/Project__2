<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Package;
use App\Models\Booking;
use App\Models\Date;
use App\Models\Klien;

class c_booking extends Controller
{
    // Menampilkan daftar paket yang dapat dibooking
    public function index(Request $request)
    {
        $query = Package::with('packageRabs.vendorService');

        if ($request->filled('budget')) {
            $query->where('harga_total', '<=', $request->budget);
        }

        if ($request->filled('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%');
        }

        $packages = $query->get();

        return view('klien.booking.v_index', compact('packages'));
    }

    // Tampilkan form booking berdasarkan ID paket
    public function create($id)
    {
        $package = Package::with('packageRabs.vendorService')->findOrFail($id);

        // Ambil semua tanggal beserta statusnya
        $bookedDates = Date::all()->map(function ($item) {
            return [
                'date' => $item->tanggal,
                'status' => $item->status,
            ];
        });

        // Ambil hanya tanggal yang statusnya 'available'
        $availableDates = Date::where('status', 'available')->pluck('tanggal')->toArray();

        return view('klien.booking.v_create', compact('package', 'bookedDates', 'availableDates'));
    }


    // Menyimpan data booking
    public function store(Request $request)
    {
        $request->validate([
            'package_id' => 'required|exists:packages,id',
            'date_id' => 'required|exists:dates,id',
        ]);

        $date = Date::find($request->date_id);

        if (!$date || $date->status !== 'available') {
            return redirect()->back()->with('error', 'Tanggal tidak tersedia untuk booking.');
        }

        // Update status tanggal menjadi booked
        $date->update(['status' => 'booked']);

        Booking::create([
        'pengguna_id' => Auth::id(),
        'package_id' => $request->package_id,
        'date_id' => $request->date_id,
        'status' => 'pending',
    ]);

        return redirect()->route('klien.booking.list')->with('success', 'Booking berhasil!');
    }

    // Daftar booking user saat ini
    public function list()
    {
        dd(Auth::id());
        $bookings = Booking::with(['package', 'date', 'pengguna.klien'])
        ->where('pengguna_id', Auth::id(7))
        ->latest()
        ->get();

        return view('klien.booking.v_list', compact('bookings'));
    }

    
}
