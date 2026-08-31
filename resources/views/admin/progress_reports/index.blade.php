@extends('layouts.admin')
@section('title', 'Laporan Perkembangan')
@section('page-title', 'Laporan Perkembangan Murid')
@section('page-subtitle', 'Buat, kelola, dan unduh laporan belajar murid dalam format PDF')

@section('content')

    <div class="flex flex-col sm:flex-row gap-3 mb-6">
        <form action="{{ route('admin.laporan-perkembangan.index') }}" method="GET" class="flex gap-2 flex-1">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama murid atau periode..." class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm">
            <select name="student_id" onchange="this.form.submit()" class="px-3 py-2.5 rounded-xl border border-slate-200 outline-none text-sm bg-white font-semibold text-slate-700 max-w-xs">
                <option value="">Semua Murid</option>
                @foreach($students as $st)
                    <option value="{{ $st->id }}" {{ request('student_id') == $st->id ? 'selected' : '' }}>{{ $st->full_name }}</option>
                @endforeach
            </select>
            <button type="submit" class="px-4 py-2.5 rounded-xl bg-slate-800 text-white text-sm font-bold"><i class="fa-solid fa-magnifying-glass"></i></button>
            @if(request()->hasAny(['search','student_id'])) <a href="{{ route('admin.laporan-perkembangan.index') }}" class="px-3 py-2.5 rounded-xl border text-sm text-slate-600"><i class="fa-solid fa-xmark"></i></a> @endif
        </form>
        <a href="{{ route('admin.laporan-perkembangan.create') }}" class="flex items-center gap-2 px-5 py-2.5 rounded-xl bg-sky-600 hover:bg-sky-700 text-white text-sm font-bold shadow-md">
            <i class="fa-solid fa-plus"></i> Buat Laporan Baru
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="text-xs font-bold uppercase tracking-wider text-slate-400 bg-slate-50/70 border-b border-slate-100">
                        <th class="px-5 py-3.5">Siswa</th>
                        <th class="px-5 py-3.5">Periode Laporan</th>
                        <th class="px-5 py-3.5">Tahap Saat Ini</th>
                        <th class="px-5 py-3.5">Kehadiran</th>
                        <th class="px-5 py-3.5">Dibuat Oleh</th>
                        <th class="px-5 py-3.5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100/80">
                    @forelse($reports as $report)
                        <tr class="hover:bg-slate-50/50">
                            <td class="px-5 py-4">
                                <div class="font-bold text-slate-900">{{ $report->student->full_name }}</div>
                                <div class="text-xs text-slate-400">{{ $report->student->class_level_label }}</div>
                            </td>
                            <td class="px-5 py-4">
                                <span class="px-2.5 py-1 rounded-lg bg-indigo-50 text-indigo-700 text-xs font-bold">{{ $report->period }}</span>
                            </td>
                            <td class="px-5 py-4 text-sm text-slate-700 max-w-xs">{{ $report->current_stage }}</td>
                            <td class="px-5 py-4 text-xs font-semibold text-slate-600">{{ $report->attendance_summary ?? '-' }}</td>
                            <td class="px-5 py-4 text-xs text-slate-500">{{ $report->creator->name ?? 'Admin' }}</td>
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.laporan-perkembangan.pdf', $report->id) }}" target="_blank" class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 flex items-center justify-center" title="Download PDF">
                                        <i class="fa-solid fa-file-pdf text-xs"></i>
                                    </a>
                                    <a href="{{ route('admin.laporan-perkembangan.edit', $report->id) }}" class="w-8 h-8 rounded-lg bg-sky-50 text-sky-600 hover:bg-sky-100 flex items-center justify-center" title="Edit">
                                        <i class="fa-solid fa-pen text-xs"></i>
                                    </a>
                                    <form action="{{ route('admin.laporan-perkembangan.destroy', $report->id) }}" method="POST" onsubmit="return confirm('Hapus laporan ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="w-8 h-8 rounded-lg bg-rose-50 text-rose-500 hover:bg-rose-100 flex items-center justify-center" title="Hapus">
                                            <i class="fa-solid fa-trash-can text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-5 py-12 text-center text-slate-400 text-sm">Belum ada laporan perkembangan murid.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-4 border-t border-slate-100">{{ $reports->withQueryString()->links() }}</div>
    </div>

@endsection
