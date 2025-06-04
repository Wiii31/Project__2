<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'client_id',
        'package_id',
        'date_id',
        'status',
    ];

    // Relasi ke user (klien)
    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    // Relasi ke paket
    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

    // Relasi ke tanggal booking
    public function date()
    {
        return $this->belongsTo(Date::class, 'date_id');
    }
}
