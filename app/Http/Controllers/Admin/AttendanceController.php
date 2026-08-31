<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use App\Models\Attendance;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\Registration;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $schedules = Schedule::orderBy('session_name')->get();

        $meetings = Meeting::with(['schedule', 'attendances'])
            ->when($request->schedule_id, fn($q, $s) => $q->where('schedule_id', $s))
            ->when($request->date, fn($q, $d) => $q->whereDate('meeting_date', $d))
            ->latest('meeting_date')
            ->paginate(15);

        return view('admin.attendances.index', compact('meetings', 'schedules'));
    }

    public function create(Request $request)
    {
        $schedules          = Schedule::where('is_active', true)->orderBy('session_name')->get();
        $selectedScheduleId = $request->schedule_id;
        $selectedDate       = $request->filled('date') ? $request->date : Carbon::today()->format('Y-m-d');

        $students = collect();
        $existingMeeting = null;

        if ($selectedScheduleId) {
            // Get active students in this schedule
            $studentIds = Registration::where('schedule_id', $selectedScheduleId)
                ->where('status', 'terverifikasi')
                ->pluck('student_id');

            $students = Student::whereIn('id', $studentIds)->orderBy('full_name')->get();

            // Check existing meeting
            $existingMeeting = Meeting::where('schedule_id', $selectedScheduleId)
                ->whereDate('meeting_date', $selectedDate)
                ->with('attendances')
                ->first();
        }

        return view('admin.attendances.create', compact(
            'schedules', 'selectedScheduleId', 'selectedDate', 'students', 'existingMeeting'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'schedule_id'   => 'required|exists:schedules,id',
            'meeting_date'  => 'required|date',
            'attendances'   => 'required|array',
        ]);

        // Find or create meeting
        $meeting = Meeting::firstOrCreate(
            [
                'schedule_id'  => $request->schedule_id,
                'meeting_date' => $request->meeting_date,
            ],
            ['notes' => $request->notes]
        );

        if ($meeting->wasRecentlyCreated === false) {
            $meeting->update(['notes' => $request->notes]);
        }

        // Sync attendances
        foreach ($request->attendances as $att) {
            Attendance::updateOrCreate(
                [
                    'meeting_id' => $meeting->id,
                    'student_id' => $att['student_id'],
                ],
                [
                    'status' => $att['status'],
                    'notes'  => $att['notes'] ?? null,
                ]
            );
        }

        return redirect()->route('admin.absensi.index')
            ->with('success', 'Data absensi berhasil disimpan untuk ' . count($request->attendances) . ' siswa.');
    }

    public function destroy(Meeting $absensi)
    {
        $absensi->attendances()->delete();
        $absensi->delete();
        return back()->with('success', 'Data absensi pertemuan berhasil dihapus.');
    }
}
