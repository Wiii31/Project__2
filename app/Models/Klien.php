<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Klien extends Model
{
    protected $table = 'klien';
    protected $primaryKey = 'id_klien';

    protected $fillable = [
        'id_pengguna',
        'tanggal_daftar',
        'catatan',
        'nama_pasangan',
        'no_ktp',
        'alamat_akad',
        'alamat_resepsi',
    ];


    public $timestamps = true;

    // Relasi ke pengguna
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna', 'id');
    }
}
