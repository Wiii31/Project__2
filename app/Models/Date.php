<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Date extends Model
{
    protected $table = 'dates';

    protected $fillable = [
        'tanggal',
        'status',
    ];

    // Relasi ke Booking jika Date terhubung dengan booking
    public function bookings()
    {
        return $this->hasMany(Booking::class, 'date_id');
    }

    // Scope untuk ambil hanya yang available
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    // Scope untuk ambil yang sudah dibooking atau pending
    public function scopeBlocked($query)
    {
        return $query->whereIn('status', ['booked', 'pending']);
    }

    // Scope untuk ambil berdasarkan tanggal
    public function scopeOnDate($query, $date)
    {
        return $query->where('tanggal', $date);
    }
}
