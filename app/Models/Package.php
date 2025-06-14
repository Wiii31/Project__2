<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $table = 'packages';

    protected $fillable = [
        'type',
        'nama',
        'deskripsi',
        'harga_total',
        'foto',
    ];

    // Relasi ke package_rabs (one to many)
    public function packageRabs()
    {
        return $this->hasMany(PackageRab::class, 'package_id');
    }
}
