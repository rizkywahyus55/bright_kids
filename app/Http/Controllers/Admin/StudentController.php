<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Registration;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $students = Student::with(['registration.parent', 'activeRegistration.schedule'])
            ->when($request->search, function ($q, $s) {
                $q->where('full_name', 'like', "%{$s}%")
                  ->orWhereHas('registration.parent', fn($pq) => $pq->where('full_name', 'like', "%{$s}%"));
            })
            ->when($request->class_level, fn($q, $cl) => $q->where('class_level', $cl))
            ->orderBy('full_name')
            ->paginate(15);

        return view('admin.students.index', compact('students'));
    }

    public function show(Student $siswa)
    {
        $siswa->load([
            'registration.parent',
            'registration.schedule',
            'registration.payments',
            'activeRegistration.schedule',
            'attendances.meeting',
            'progressReports.creator',
        ]);

        return view('admin.students.show', compact('siswa'));
    }

    public function edit(Student $siswa)
    {
        $siswa->load('registration.parent');
        return view('admin.students.edit', compact('siswa'));
    }

    public function update(Request $request, Student $siswa)
    {
        $validated = $request->validate([
            'full_name'     => 'required|string|max:150',
            'date_of_birth' => 'required|date',
            'class_level'   => 'required|string',
            'school_origin' => 'nullable|string|max:150',
            // Parent fields
            'parent_name'        => 'required|string|max:150',
            'whatsapp_number'    => 'required|string|max:25',
            'parent_address'     => 'nullable|string',
        ]);

        $siswa->update([
            'full_name'     => $validated['full_name'],
            'date_of_birth' => $validated['date_of_birth'],
            'class_level'   => $validated['class_level'],
            'school_origin' => $validated['school_origin'],
        ]);

        // Update parent via registration
        $registration = $siswa->registration()->first();
        if ($registration && $registration->parent) {
            $registration->parent->update([
                'full_name'       => $validated['parent_name'],
                'whatsapp_number' => $validated['whatsapp_number'],
                'address'         => $validated['parent_address'],
            ]);
        }

        return redirect()->route('admin.siswa.show', $siswa)
            ->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Student $siswa)
    {
        \Illuminate\Support\Facades\DB::transaction(function () use ($siswa) {
            $parentIds = $siswa->registrations()->pluck('parent_id')->unique();

            // Delete student attendances and progress reports
            $siswa->attendances()->delete();
            $siswa->progressReports()->delete();

            // Delete registrations and their payments
            foreach ($siswa->registrations as $reg) {
                $reg->payments()->delete();
                $reg->delete();
            }

            // Delete student record
            $siswa->delete();

            // Delete parent(s) if they have no other registrations
            foreach ($parentIds as $parentId) {
                $parent = \App\Models\ParentModel::find($parentId);
                if ($parent && !$parent->registrations()->exists()) {
                    $parent->delete();
                }
            }
        });

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Data murid beserta seluruh pendaftaran dan riwayat terkait berhasil dihapus bersih.');
    }
}
