<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\EventSchedule;
use App\Models\EventAssignment;
use App\Models\Staff;
use App\Models\Activity;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;

class c_event extends Controller
{
    // Definisikan roles sebagai properti class agar bisa diakses di method lain (optional)
    private $roles = ['Koordinator', 'Fotografer', 'MC', 'Makeup Artist'];

    public function index()
    {
        $events = Event::with(['schedules.staff', 'schedules.assignment'])->get();
        return view('admin.event.v_kelolakegiatan', compact('events'));
    }

    public function create()
    {
        $activities = Activity::all();
        $staffs = Staff::all();
        $roles = $this->roles; // ambil dari properti class
        return view('admin.event.v_create', compact('activities', 'staffs', 'roles'));
    }

    public function store(Request $request)
    {
        $roles = $this->roles;

        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'location' => 'required',
            'schedule_time.*' => 'required',
            'schedule_activity.*' => 'required',
            'staff_id.*' => 'required',
            'role.*' => 'required|string|in:' . implode(',', $roles),
        ]);

        DB::transaction(function () use ($request) {
            $event = Event::create([
                'booking_id' => $request->booking_id,
                'location' => $request->location,
                'status' => 'pending', // atau sesuai kebutuhan
            ]);

            foreach ($request->schedule_time as $i => $time) {
                $schedule = EventSchedule::create([
                    'event_id' => $event->id,
                    'time' => $time,
                    'activity_id' => $request->schedule_activity[$i],
                    'staff_id' => $request->staff_id[$i],
                ]);

                EventAssignment::create([
                    'schedule_id' => $schedule->id,
                    'staff_id' => $request->staff_id[$i],
                    'job_description' => $request->role[$i],
                ]);
            }
        });

        return redirect()->route('event.index')->with('success', 'Kegiatan berhasil ditambahkan.');
    }


    public function show($id)
    {
        $event = Event::with(['schedules.staff', 'schedules.assignment'])->findOrFail($id);
        return view('admin.event.v_detail', compact('event'));
    }

    public function edit($id)
    {
        $event = Event::with(['schedules.staff', 'schedules.assignment'])->findOrFail($id);
        $activities = Activity::all();
        $staffs = Staff::all();
        $roles = $this->roles;
        return view('admin.event.v_edit', compact('event', 'activities', 'staffs', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $roles = $this->roles;

        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'location' => 'required',
            'schedule_time.*' => 'required',
            'schedule_activity.*' => 'required',
            'staff_id.*' => 'required',
            'role.*' => 'required|string|in:' . implode(',', $roles),
        ]);

        DB::transaction(function () use ($request, $id) {
            $event = Event::findOrFail($id);
            $event->update([
                'booking_id' => $request->booking_id,
                'location' => $request->location,
                'status' => 'pending', // atau sesuai kebutuhan
            ]);

            $scheduleIds = EventSchedule::where('event_id', $id)->pluck('id')->toArray();
            EventAssignment::whereIn('schedule_id', $scheduleIds)->delete();
            EventSchedule::where('event_id', $id)->delete();

            foreach ($request->schedule_time as $i => $time) {
                $schedule = EventSchedule::create([
                    'event_id' => $event->id,
                    'time' => $time,
                    'activity_id' => $request->schedule_activity[$i],
                    'staff_id' => $request->staff_id[$i],
                ]);

                EventAssignment::create([
                    'schedule_id' => $schedule->id,
                    'staff_id' => $request->staff_id[$i],
                    'job_description' => $request->role[$i],
                ]);
            }
        });

        return redirect()->route('event.index')->with('success', 'Kegiatan berhasil diperbarui.');
    }


    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $scheduleIds = $event->schedules()->pluck('id')->toArray();
        EventAssignment::whereIn('schedule_id', $scheduleIds)->delete();
        EventSchedule::where('event_id', $event->id)->delete();
        $event->delete();

        return redirect()->route('event.index')->with('success', 'Kegiatan berhasil dihapus.');
    }
}
