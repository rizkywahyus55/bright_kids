<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\Payment;
use App\Models\Meeting;
use App\Models\Student;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents         = Student::whereHas('activeRegistration')->count();
        $pendingRegistrations  = Registration::where('status', 'menunggu_verifikasi')->count();
        $pendingPayments       = Payment::where('status', 'pending')->count();

        $todayMeetings        = Meeting::whereDate('meeting_date', today())->with('attendances')->get();
        $todayMeetingCount    = $todayMeetings->count();
        $todayAttendanceCount = $todayMeetings->flatMap->attendances->where('status', 'hadir')->count();

        $recentRegistrations  = Registration::with(['student', 'schedule'])
            ->latest()
            ->take(5)
            ->get();

        $recentPayments = Payment::with('registration.student')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalStudents',
            'pendingRegistrations',
            'pendingPayments',
            'todayMeetingCount',
            'todayAttendanceCount',
            'recentRegistrations',
            'recentPayments'
        ));
    }
}
