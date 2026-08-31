<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\Student;
use App\Models\ParentModel;
use App\Models\Schedule;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class RegistrationController extends Controller
{
    public function index(Request $request)
    {
        $registrations = Registration::with(['student', 'parent', 'schedule', 'latestPayment'])
            ->when($request->search, function ($q, $s) {
                $q->whereHas('student', fn($sq) => $sq->where('full_name', 'like', "%{$s}%"))
                  ->orWhereHas('parent', fn($pq) => $pq->where('full_name', 'like', "%{$s}%")->orWhere('whatsapp_number', 'like', "%{$s}%"));
            })
            ->when($request->status, fn($q, $s) => $q->where('status', $s))
            ->latest()
            ->paginate(15);

        return view('admin.registrations.index', compact('registrations'));
    }

    public function create()
    {
        $schedules = Schedule::where('is_active', true)->orderBy('session_name')->get();
        return view('admin.registrations.create', compact('schedules'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'full_name'       => 'required|string|max:150',
            'date_of_birth'   => 'required|date',
            'class_level'     => 'required|string',
            'school_origin'   => 'required|string|max:150',
            'parent_name'     => 'required|string|max:150',
            'whatsapp_number' => 'required|string|max:20',
            'address'         => 'required|string',
            'schedule_id'     => 'required|exists:schedules,id',
            'status'          => 'required|in:menunggu_verifikasi,terverifikasi',
        ]);

        // Create Parent
        $parent = ParentModel::create([
            'full_name'        => $validated['parent_name'],
            'whatsapp_number'  => $validated['whatsapp_number'],
            'address'          => $validated['address'],
        ]);

        // Create Student
        $student = Student::create([
            'parent_id'     => $parent->id,
            'full_name'     => $validated['full_name'],
            'date_of_birth' => $validated['date_of_birth'],
            'class_level'   => $validated['class_level'],
            'school_origin' => $validated['school_origin'],
        ]);

        // Create Registration
        $regCode = 'BK-' . strtoupper(Str::random(6));
        Registration::create([
            'registration_code' => $regCode,
            'student_id'  => $student->id,
            'parent_id'   => $parent->id,
            'schedule_id' => $validated['schedule_id'],
            'status'      => $validated['status'],
            'registered_at' => Carbon::now(),
        ]);

        return redirect()->route('admin.pendaftaran.index')
            ->with('success', 'Pendaftaran offline berhasil disimpan. Kode: ' . $regCode);
    }

    public function show(Registration $pendaftaran)
    {
        $pendaftaran->load(['student', 'parent', 'schedule', 'payments']);
        return view('admin.registrations.show', compact('pendaftaran'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:terverifikasi,ditolak,nonaktif']);

        $pendaftaran = $id instanceof Registration ? $id : Registration::findOrFail($id);
        $pendaftaran->update(['status' => $request->status]);

        // Sync student active status
        if ($pendaftaran->student) {
            $pendaftaran->student->update([
                'status' => $request->status === 'terverifikasi' ? 'aktif' : 'nonaktif'
            ]);
        }

        return back()->with('success', 'Status pendaftaran ' . $pendaftaran->registration_code . ' berhasil diperbarui menjadi ' . $pendaftaran->status_label . '.');
    }

    public function destroy(Registration $pendaftaran)
    {
        \Illuminate\Support\Facades\DB::transaction(function () use ($pendaftaran) {
            $student = $pendaftaran->student;
            $parent  = $pendaftaran->parent;

            // Delete payments for this registration
            $pendaftaran->payments()->delete();

            // Delete registration
            $pendaftaran->delete();

            // Delete student if they have no other registrations
            if ($student && !$student->registrations()->exists()) {
                $student->attendances()->delete();
                $student->progressReports()->delete();
                $student->delete();
            }

            // Delete parent if they have no other registrations
            if ($parent && !$parent->registrations()->exists()) {
                $parent->delete();
            }
        });

        return redirect()->route('admin.pendaftaran.index')
            ->with('success', 'Data pendaftaran beserta data anak dan wali terkait berhasil dihapus bersih.');
    }
}
