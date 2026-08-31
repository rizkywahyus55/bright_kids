@extends('layouts.admin')
@section('title', 'Input Absensi')
@section('page-title', 'Input Absensi Pertemuan')
@section('page-subtitle', 'Pilih sesi & tanggal, lalu tandai kehadiran tiap murid')

@section('content')

    <!-- Filter Sesi & Tanggal -->
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-5 mb-6">
        <form action="{{ route('admin.absensi.create') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Pilih Sesi Jadwal</label>
                <select name="schedule_id" onchange="this.form.submit()" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm bg-white font-semibold">
                    <option value="" {{ !$selectedScheduleId ? 'selected' : '' }} disabled hidden></option>
                    @foreach($schedules as $s)
                        <option value="{{ $s->id }}" {{ $selectedScheduleId == $s->id ? 'selected' : '' }}>
                            {{ $s->session_name }} ({{ $s->formatted_time }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Tanggal Pertemuan</label>
                <input type="date" name="date" value="{{ $selectedDate }}" onchange="this.form.submit()" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm">
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full px-4 py-3 rounded-xl bg-sky-600 hover:bg-sky-700 text-white text-sm font-bold shadow-md">
                    <i class="fa-solid fa-filter mr-1"></i> Filter Pertemuan
                </button>
            </div>
        </form>
    </div>

    @if($existingMeeting)
        <div class="mb-4 p-3.5 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-xs font-semibold flex items-center gap-2">
            <i class="fa-solid fa-triangle-exclamation flex-shrink-0"></i>
            Absensi untuk sesi ini pada tanggal yang dipilih sudah pernah diinput. Anda dapat memperbarui data kehadiran di bawah.
        </div>
    @endif

    @if($students->isNotEmpty())
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                <h3 class="font-bold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-clipboard-list text-sky-500"></i>
                    Daftar Kehadiran Murid
                    <span class="text-xs font-normal text-slate-400 ml-1">({{ $students->count() }} murid terdaftar pada sesi ini)</span>
                </h3>
            </div>

            <form action="{{ route('admin.absensi.store') }}" method="POST">
                @csrf
                <input type="hidden" name="schedule_id" value="{{ $selectedScheduleId }}">
                <input type="hidden" name="meeting_date" value="{{ $selectedDate }}">

                <div class="p-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Catatan Pertemuan (Opsional)</label>
                        <input type="text" name="notes" value="{{ $existingMeeting?->notes }}" placeholder="Contoh: Materi membaca kata bola, sapu..." class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm">
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead>
                            <tr class="text-xs font-bold uppercase tracking-wider text-slate-400 bg-slate-50/70 border-y border-slate-100">
                                <th class="px-5 py-3">No</th>
                                <th class="px-5 py-3">Nama Murid</th>
                                <th class="px-5 py-3">Jenjang</th>
                                <th class="px-5 py-3">Status Kehadiran</th>
                                <th class="px-5 py-3">Catatan Singkat</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($students as $i => $student)
                                @php
                                    $existing = $existingMeeting?->attendances->firstWhere('student_id', $student->id);
                                @endphp
                                <input type="hidden" name="attendances[{{ $i }}][student_id]" value="{{ $student->id }}">
                                <tr class="hover:bg-slate-50/50">
                                    <td class="px-5 py-4 text-slate-400 font-bold text-xs">{{ $i + 1 }}</td>
                                    <td class="px-5 py-4 font-bold text-slate-900">{{ $student->full_name }}</td>
                                    <td class="px-5 py-4 text-xs text-slate-500">{{ $student->class_level_label }}</td>
                                    <td class="px-5 py-4">
                                        <div class="flex flex-wrap gap-2">
                                            @foreach(['hadir' => 'Hadir', 'izin' => 'Izin', 'sakit' => 'Sakit', 'alpa' => 'Tidak Hadir'] as $val => $label)
                                                <label class="flex items-center gap-1.5 cursor-pointer">
                                                    <input type="radio" name="attendances[{{ $i }}][status]" value="{{ $val }}"
                                                        {{ ($existing?->status === $val || (!$existing && $val === 'hadir')) ? 'checked' : '' }}
                                                        class="text-sky-600 focus:ring-sky-200" required>
                                                    <span class="text-xs font-semibold {{ $val === 'hadir' ? 'text-emerald-700' : ($val === 'alpa' ? 'text-rose-600' : 'text-slate-600') }}">{{ $label }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="px-5 py-4">
                                        <input type="text" name="attendances[{{ $i }}][notes]" value="{{ $existing?->notes }}" placeholder="Catatan opsional..." class="px-3 py-2 rounded-lg border border-slate-200 focus:border-sky-500 outline-none text-xs w-full max-w-xs">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="p-5 border-t border-slate-100 flex gap-3">
                    <a href="{{ route('admin.absensi.index') }}" class="px-6 py-3 rounded-xl border border-slate-200 text-sm font-bold text-slate-700 hover:bg-slate-50">Batal</a>
                    <button type="submit" class="flex-1 sm:flex-none px-8 py-3 rounded-xl bg-sky-600 hover:bg-sky-700 text-white text-sm font-bold shadow-md">
                        <i class="fa-solid fa-floppy-disk mr-1.5"></i> Simpan Data Absensi
                    </button>
                </div>
            </form>
        </div>
    @elseif($selectedScheduleId)
        <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center text-slate-400 shadow-sm">
            <i class="fa-solid fa-user-slash text-4xl mb-3 block opacity-30"></i>
            <p class="font-semibold">Tidak ada murid terverifikasi pada sesi yang dipilih.</p>
            <p class="text-xs mt-1">Pastikan ada pendaftaran berstatus Terverifikasi untuk sesi ini.</p>
        </div>
    @else
        <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center text-slate-400 shadow-sm">
            <i class="fa-solid fa-calendar-day text-4xl mb-3 block opacity-30"></i>
            <p class="font-semibold">Pilih sesi jadwal & tanggal untuk melihat daftar murid.</p>
        </div>
    @endif

@endsection
