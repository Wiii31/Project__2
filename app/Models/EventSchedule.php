<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventSchedule extends Model
{
    protected $table = 'event_schedules';
    protected $primaryKey = 'id';
    public $timestamps = true; // aktifkan timestamps kalau pakai created_at & updated_at

    protected $fillable = [
        'event_id',
        'time',
        'activity_id',
    ];

    // Relasi ke kegiatan utama (event)
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    // Relasi ke activity
    public function activity()
    {
        return $this->belongsTo(Activity::class, 'activity_id');
    }

    // Relasi ke penugasan (assignment)
    public function assignment()
    {
        return $this->hasOne(EventAssignment::class, 'schedule_id');
    }

    // Jika jadwal bisa punya banyak petugas (opsional)
    public function assignments()
    {
        return $this->hasMany(EventAssignment::class, 'schedule_id');
    }
}
