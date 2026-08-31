@extends('layouts.admin')
@section('title', 'Edit Laporan Perkembangan')
@section('page-title', 'Edit Laporan Perkembangan')
@section('page-subtitle', 'Perbarui data laporan perkembangan belajar murid')

@section('content')
<div class="max-w-3xl mx-auto">
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
    <form action="{{ route('admin.laporan-perkembangan.update', $report->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Nama Murid *</label>
                <select name="student_id" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm bg-white">
                    <option value="" disabled {{ old('student_id', $report->student_id) ? '' : 'selected' }} hidden></option>
                    @foreach($students as $st)
                        <option value="{{ $st->id }}" {{ (old('student_id', $report->student_id) == $st->id) ? 'selected' : '' }}>
                            {{ $st->full_name }} ({{ $st->class_level_label }})
                        </option>
                    @endforeach
                </select>
                @error('student_id')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Periode Laporan *</label>
                <input type="text" name="period" value="{{ old('period', $report->period) }}" required
                    placeholder="Contoh: Agustus 2026"
                    class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm">
                @error('period')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Tahap Belajar Saat Ini *</label>
            <input type="text" name="current_stage" value="{{ old('current_stage', $report->current_stage) }}" required
                placeholder="Contoh: Tahap 2 – Mengenal Suku Kata Sederhana"
                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm">
            @error('current_stage')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Kemampuan Membaca</label>
                <select name="reading_skill" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm bg-white">
                    @foreach(['Belum Berkembang' => 'Belum Berkembang (BB)', 'Mulai Berkembang' => 'Mulai Berkembang (MB)', 'Berkembang Sesuai Harapan' => 'Berkembang Sesuai Harapan (BSH)', 'Berkembang Sangat Baik' => 'Berkembang Sangat Baik (BSB)'] as $val => $label)
                        <option value="{{ $val }}" {{ old('reading_skill', $report->reading_skill) === $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Kemampuan Menulis</label>
                <select name="writing_skill" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm bg-white">
                    @foreach(['Belum Berkembang' => 'Belum Berkembang (BB)', 'Mulai Berkembang' => 'Mulai Berkembang (MB)', 'Berkembang Sesuai Harapan' => 'Berkembang Sesuai Harapan (BSH)', 'Berkembang Sangat Baik' => 'Berkembang Sangat Baik (BSB)'] as $val => $label)
                        <option value="{{ $val }}" {{ old('writing_skill', $report->writing_skill) === $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Rekap Kehadiran</label>
            <input type="text" name="attendance_summary" value="{{ old('attendance_summary', $report->attendance_summary) }}"
                placeholder="Contoh: Hadir 12x, Sakit 1x, Tidak Hadir 0x"
                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm">
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Narasi Perkembangan Belajar *</label>
            <textarea name="progress_narrative" rows="5" required
                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm"
                placeholder="Tuliskan narasi perkembangan belajar murid secara detail...">{{ old('progress_narrative', $report->progress_narrative) }}</textarea>
            @error('progress_narrative')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Catatan & Rekomendasi untuk Orang Tua</label>
            <textarea name="recommendations" rows="3"
                class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm"
                placeholder="Tuliskan saran dan tindak lanjut yang perlu dilakukan di rumah...">{{ old('recommendations', $report->recommendations) }}</textarea>
        </div>

        <div class="flex gap-3 pt-2">
            <a href="{{ route('admin.laporan-perkembangan.index') }}" class="flex-1 py-3 rounded-xl border border-slate-200 text-sm font-bold text-slate-700 text-center hover:bg-slate-50 transition-colors">Batal</a>
            <button type="submit" class="flex-1 py-3 rounded-xl bg-sky-600 hover:bg-sky-700 text-white text-sm font-bold shadow-md transition-colors">
                <i class="fa-solid fa-floppy-disk mr-1.5"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>
</div>
@endsection
