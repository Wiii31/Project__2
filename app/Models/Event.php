<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = 'events';

    protected $fillable = [
        'booking_id',
        'location',
        'status',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    // Relasi ke jadwal event
    public function schedules()
    {
        return $this->hasMany(EventSchedule::class, 'event_id');
    }

    // Accessor supaya kita bisa panggil $event->event_date langsung
    public function getEventDateAttribute()
    {
        return $this->booking ? $this->booking->event_date : null;
    }
}
