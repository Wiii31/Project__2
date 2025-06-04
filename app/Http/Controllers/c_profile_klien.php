<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Klien;
use App\Models\Pengguna;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class c_profile_klien extends Controller
{
    public function index()
    {
        $klien = Klien::with('pengguna')->where('id_pengguna', Auth::id())->first();
        return view('klien.profile.v_index', compact('klien'));
    }

    public function edit()
    {
        $klien = Klien::with('pengguna')->where('id_pengguna', Auth::id())->first();
        return view('klien.profile.v_edit', compact('klien'));
    }

    public function update(Request $request)
    {
        $request->validate([
            // Validasi untuk data pengguna
            'nama' => 'required|string|max:255',
            'email' => 'required|email',
            'alamat' => 'nullable|string',
            'no_hp' => 'nullable|string',
            'password' => 'nullable|confirmed|min:6',

            // Validasi untuk data tambahan klien
            'nama_pasangan' => 'nullable|string|max:100',
            'no_ktp' => 'nullable|string|max:50',
            'alamat_akad' => 'nullable|string',
            'alamat_resepsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $klien = Klien::where('id_pengguna', Auth::id())->first();
        $pengguna = $klien->pengguna;

        // Update data pengguna
        $pengguna->nama = $request->nama;
        $pengguna->email = $request->email;
        $pengguna->alamat = $request->alamat;
        $pengguna->no_hp = $request->no_hp;

        if ($request->filled('password')) {
            $pengguna->password = Hash::make($request->password);
        }
        $pengguna->save();

        // Update data klien tambahan
        $klien->nama_pasangan = $request->nama_pasangan;
        $klien->no_ktp = $request->no_ktp;
        $klien->alamat_akad = $request->alamat_akad;
        $klien->alamat_resepsi = $request->alamat_resepsi;

        // Handle upload foto
        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $namaFile = time() . '_' . $foto->getClientOriginalName();
            $foto->move(public_path('images/foto_klien'), $namaFile);

            // Hapus foto lama kalau ada
            if ($klien->foto && file_exists(public_path('images/foto_klien/' . $klien->foto))) {
                unlink(public_path('images/foto_klien/' . $klien->foto));
            }

            $klien->foto = $namaFile;
        }

        $klien->save();

        return redirect()->route('klien.profile')->with('success', 'Profil berhasil diperbarui.');
    }

}
