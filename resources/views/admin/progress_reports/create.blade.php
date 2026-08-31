@extends('layouts.admin')
@section('title', 'Buat Laporan Perkembangan')
@section('page-title', 'Buat Laporan Perkembangan Murid')
@section('page-subtitle', 'Isi formulir penilaian perkembangan belajar murid')

@section('content')
<div class="max-w-3xl mx-auto">
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
    <form action="{{ route('admin.laporan-perkembangan.store') }}" method="POST" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Nama Murid</label>
                <select name="student_id" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm bg-white">
                    <option value="" disabled {{ old('student_id') ? '' : 'selected' }} hidden></option>
                    @foreach($students as $st)
                        <option value="{{ $st->id }}" {{ old('student_id') == $st->id ? 'selected' : '' }}>{{ $st->full_name }} ({{ $st->class_level_label }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Periode Laporan</label>
                <input type="text" name="period" value="{{ old('period') }}" required placeholder="Contoh: Juli 2026 atau Semester 1 2026" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm">
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Tahap Belajar Saat Ini</label>
            <input type="text" name="current_stage" value="{{ old('current_stage') }}" required placeholder="Contoh: Tahap 2 – Mengenal Suku Kata Sederhana" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Kemampuan Membaca</label>
                <select name="reading_skill" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm bg-white">
                    <option value="Belum Berkembang" {{ old('reading_skill') === 'Belum Berkembang' ? 'selected' : '' }}>Belum Berkembang (BB)</option>
                    <option value="Mulai Berkembang" {{ old('reading_skill') === 'Mulai Berkembang' ? 'selected' : '' }}>Mulai Berkembang (MB)</option>
                    <option value="Berkembang Sesuai Harapan" {{ old('reading_skill') === 'Berkembang Sesuai Harapan' ? 'selected' : '' }}>Berkembang Sesuai Harapan (BSH)</option>
                    <option value="Berkembang Sangat Baik" {{ old('reading_skill') === 'Berkembang Sangat Baik' ? 'selected' : '' }}>Berkembang Sangat Baik (BSB)</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Kemampuan Menulis</label>
                <select name="writing_skill" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm bg-white">
                    <option value="Belum Berkembang" {{ old('writing_skill') === 'Belum Berkembang' ? 'selected' : '' }}>Belum Berkembang (BB)</option>
                    <option value="Mulai Berkembang" {{ old('writing_skill') === 'Mulai Berkembang' ? 'selected' : '' }}>Mulai Berkembang (MB)</option>
                    <option value="Berkembang Sesuai Harapan" {{ old('writing_skill') === 'Berkembang Sesuai Harapan' ? 'selected' : '' }}>Berkembang Sesuai Harapan (BSH)</option>
                    <option value="Berkembang Sangat Baik" {{ old('writing_skill') === 'Berkembang Sangat Baik' ? 'selected' : '' }}>Berkembang Sangat Baik (BSB)</option>
                </select>
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Rekap Kehadiran</label>
            <input type="text" name="attendance_summary" value="{{ old('attendance_summary') }}" placeholder="Contoh: Hadir 12x, Sakit 1x, Tidak Hadir 0x" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm">
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Narasi Perkembangan Belajar *</label>
            <textarea name="progress_narrative" rows="5" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm" placeholder="Tuliskan narasi perkembangan belajar murid secara detail...">{{ old('progress_narrative') }}</textarea>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Catatan & Rekomendasi untuk Orang Tua</label>
            <textarea name="recommendations" rows="3" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm" placeholder="Tuliskan saran dan tindak lanjut yang perlu dilakukan di rumah...">{{ old('recommendations') }}</textarea>
        </div>

        <div class="flex gap-3 pt-2">
            <a href="{{ route('admin.laporan-perkembangan.index') }}" class="flex-1 py-3 rounded-xl border border-slate-200 text-sm font-bold text-slate-700 text-center hover:bg-slate-50">Batal</a>
            <button type="submit" class="flex-1 py-3 rounded-xl bg-sky-600 hover:bg-sky-700 text-white text-sm font-bold shadow-md">Simpan Laporan</button>
        </div>
    </form>
</div>
</div>
@endsection
