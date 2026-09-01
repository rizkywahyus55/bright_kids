<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgressReport;
use App\Models\Student;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ProgressReportController extends Controller
{
    public function index(Request $request)
    {
        $students = Student::orderBy('full_name')->get();

        $reports = ProgressReport::with(['student', 'creator'])
            ->when($request->search, function ($q, $s) {
                $q->whereHas('student', fn($sq) => $sq->where('full_name', 'like', "%{$s}%"))
                  ->orWhere('period', 'like', "%{$s}%");
            })
            ->when($request->student_id, fn($q, $sid) => $q->where('student_id', $sid))
            ->latest()
            ->paginate(15);

        return view('admin.progress_reports.index', compact('reports', 'students'));
    }

    public function create()
    {
        $students = Student::orderBy('full_name')->get();
        return view('admin.progress_reports.create', compact('students'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id'          => 'required|exists:students,id',
            'period'              => 'required|string|max:100',
            'current_stage'       => 'required|string|max:200',
            'reading_skill'       => 'nullable|string|max:100',
            'writing_skill'       => 'nullable|string|max:100',
            'attendance_summary'  => 'nullable|string|max:200',
            'progress_narrative'  => 'required|string',
            'recommendations'     => 'nullable|string',
        ]);

        $validated['created_by'] = auth('admin')->id() ?? auth()->id();

        ProgressReport::create($validated);

        return redirect()->route('admin.laporan-perkembangan.index')
            ->with('success', 'Laporan perkembangan siswa berhasil disimpan.');
    }

    public function edit(ProgressReport $laporanPerkembangan)
    {
        $students = Student::orderBy('full_name')->get();
        $report = $laporanPerkembangan;
        return view('admin.progress_reports.edit', compact('report', 'students'));
    }

    public function update(Request $request, ProgressReport $laporanPerkembangan)
    {
        $validated = $request->validate([
            'student_id'          => 'required|exists:students,id',
            'period'              => 'required|string|max:100',
            'current_stage'       => 'required|string|max:200',
            'reading_skill'       => 'nullable|string|max:100',
            'writing_skill'       => 'nullable|string|max:100',
            'attendance_summary'  => 'nullable|string|max:200',
            'progress_narrative'  => 'required|string',
            'recommendations'     => 'nullable|string',
        ]);

        $laporanPerkembangan->update($validated);

        return redirect()->route('admin.laporan-perkembangan.index')
            ->with('success', 'Laporan berhasil diperbarui.');
    }

    public function destroy(ProgressReport $laporanPerkembangan)
    {
        $laporanPerkembangan->delete();
        return back()->with('success', 'Laporan berhasil dihapus.');
    }

    public function downloadPdf($id)
    {
        $report = ProgressReport::with([
            'student.parent',
            'student.registration.schedule',
            'student.activeRegistration.schedule',
            'creator'
        ])->findOrFail($id);

        $settings = [
            'site_title'      => \App\Models\Setting::getByKey('site_title', 'Bright Kids'),
            'site_tagline'    => \App\Models\Setting::getByKey('site_tagline', 'Bimbingan Belajar Membaca & Menulis Anak Usia Dini'),
            'address'         => \App\Models\Setting::getByKey('address', 'Jl. Sidodrajat No. 57 RT. 03 RW. 19, Kel. Muktiharjo Kidul, Kec. Pedurungan, Kota Semarang'),
            'whatsapp_number' => \App\Models\Setting::getByKey('whatsapp_number', '082137690701'),
            'teacher_name'    => \App\Models\Setting::getByKey('teacher_name', 'Barijanti, S.Pd.'),
        ];

        return view('admin.progress_reports.pdf', compact('report', 'settings'));
    }

    public function publicPdf($id)
    {
        return $this->downloadPdf($id);
    }
}
