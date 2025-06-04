<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'bookings';
    protected $fillable = ['pengguna_id', 'package_id', 'date_id', 'status'];

    // Relasi
    public function pengguna()
    {
        return $this->belongsTo(Pengguna::class, 'pengguna_id');
    }

    public function date()
    {
        return $this->belongsTo(Date::class, 'date_id');
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }


    public static function getBlockedDateIds()
    {
        return self::whereIn('status', ['pending', 'confirmed'])->pluck('date_id')->toArray();
    }
}
