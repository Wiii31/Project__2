<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventAssignment extends Model
{
    protected $table = 'event_assignments';

    protected $fillable = [
        'schedule_id',
        'staff_id',
        'job_description',
    ];

    public $timestamps = true; // Karena tabel memiliki kolom created_at dan updated_at

    // Relasi ke schedule
    public function schedule()
    {
        return $this->belongsTo(EventSchedule::class, 'schedule_id');
    }

    // Relasi ke staff
    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }
}
