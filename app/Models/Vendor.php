<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $table = 'vendors';

    protected $fillable = [
        'id_pengguna', 'kategori', 'deskripsi', 'foto', 'status'
    ];

    // Relasi ke User
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'id_pengguna');
    }
    // Di model Vendor.php
    public function services()
    {
        return $this->hasMany(VendorService::class);
    }

}
