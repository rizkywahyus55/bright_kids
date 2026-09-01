@extends('layouts.admin')
@section('title', 'Rekap Absensi')
@section('page-title', 'Rekap Absensi Pertemuan')
@section('page-subtitle', 'Daftar seluruh pertemuan dan status kehadiran murid')

@section('content')

    <div class="flex flex-col sm:flex-row gap-3 mb-6">
        <form action="{{ route('admin.absensi.index') }}" method="GET" class="flex gap-2 flex-1">
            <select name="schedule_id" onchange="this.form.submit()" class="px-3 py-2.5 rounded-xl border border-slate-200 outline-none text-sm bg-white font-semibold text-slate-700">
                <option value="">Semua Sesi</option>
                @foreach($schedules as $s)
                    <option value="{{ $s->id }}" {{ request('schedule_id') == $s->id ? 'selected' : '' }}>{{ $s->session_name }}</option>
                @endforeach
            </select>
            <input type="date" name="date" value="{{ request('date') }}" onchange="this.form.submit()" class="px-3 py-2.5 rounded-xl border border-slate-200 outline-none text-sm">
            @if(request()->hasAny(['schedule_id','date'])) <a href="{{ route('admin.absensi.index') }}" class="px-3 py-2.5 rounded-xl border text-sm text-slate-600"><i class="fa-solid fa-xmark"></i></a> @endif
        </form>
        <a href="{{ route('admin.absensi.create') }}" class="flex items-center gap-2 px-5 py-2.5 rounded-xl bg-sky-600 hover:bg-sky-700 text-white text-sm font-bold shadow-md">
            <i class="fa-solid fa-plus"></i> Input Absensi Baru
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="text-xs font-bold uppercase tracking-wider text-slate-400 bg-slate-50/70 border-b border-slate-100">
                        <th class="px-5 py-3.5">Tanggal Pertemuan</th>
                        <th class="px-5 py-3.5">Sesi Belajar</th>
                        <th class="px-5 py-3.5 text-center">Hadir</th>
                        <th class="px-5 py-3.5 text-center">Izin</th>
                        <th class="px-5 py-3.5 text-center">Sakit</th>
                        <th class="px-5 py-3.5 text-center">Tidak Hadir</th>
                        <th class="px-5 py-3.5 text-center">Total</th>
                        <th class="px-5 py-3.5">Catatan Singkat</th>
                        <th class="px-5 py-3.5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100/80">
                    @forelse($meetings as $meeting)
                        @php
                            $atts = $meeting->attendances;
                            $hadir = $atts->where('status','hadir')->count();
                            $izin  = $atts->where('status','izin')->count();
                            $sakit = $atts->where('status','sakit')->count();
                            $alpa  = $atts->where('status','alpa')->count();
                            $total = $atts->count();
                            $studentNotes = $atts->filter(fn($a) => !empty($a->notes));
                        @endphp
                        <tr class="hover:bg-slate-50/50">
                            <td class="px-5 py-4 align-top">
                                <div class="font-bold text-slate-900">{{ \Carbon\Carbon::parse($meeting->meeting_date)->locale('id')->translatedFormat('d F Y') }}</div>
                            </td>
                            <td class="px-5 py-4 align-top">
                                <div class="font-semibold text-slate-700">{{ $meeting->schedule->session_name ?? '-' }}</div>
                            </td>
                            <td class="px-5 py-4 align-top text-center">
                                <span class="px-2.5 py-1 rounded-lg bg-emerald-100 text-emerald-800 text-xs font-black">{{ $hadir }}</span>
                            </td>
                            <td class="px-5 py-4 align-top text-center">
                                <span class="px-2.5 py-1 rounded-lg bg-sky-100 text-sky-700 text-xs font-black">{{ $izin }}</span>
                            </td>
                            <td class="px-5 py-4 align-top text-center">
                                <span class="px-2.5 py-1 rounded-lg bg-amber-100 text-amber-700 text-xs font-black">{{ $sakit }}</span>
                            </td>
                            <td class="px-5 py-4 align-top text-center">
                                <span class="px-2.5 py-1 rounded-lg bg-rose-100 text-rose-700 text-xs font-black">{{ $alpa }}</span>
                            </td>
                            <td class="px-5 py-4 align-top text-center text-slate-700 font-bold">{{ $total }} murid</td>
                            <td class="px-5 py-4 align-top text-slate-600">
                                @if($studentNotes->isNotEmpty() || !empty($meeting->notes))
                                    <div class="space-y-1">
                                        @if(!empty($meeting->notes))
                                            <div>{{ $meeting->notes }}</div>
                                        @endif
                                        @foreach($studentNotes as $sn)
                                            <div>{{ $sn->notes }}</div>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-slate-300">-</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 align-top text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.absensi.create') }}?schedule_id={{ $meeting->schedule_id }}&date={{ $meeting->meeting_date->format('Y-m-d') }}" class="w-8 h-8 rounded-lg bg-sky-50 text-sky-600 hover:bg-sky-100 flex items-center justify-center" title="Edit Absensi">
                                        <i class="fa-solid fa-pen text-xs"></i>
                                    </a>
                                    <form action="{{ route('admin.absensi.destroy', $meeting->id) }}" method="POST" onsubmit="return confirm('Hapus seluruh data absensi pertemuan ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="w-8 h-8 rounded-lg bg-rose-50 text-rose-500 hover:bg-rose-100 flex items-center justify-center" title="Hapus">
                                            <i class="fa-solid fa-trash-can text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="9" class="px-5 py-12 text-center text-slate-400 text-sm">Belum ada data absensi pertemuan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-4 border-t border-slate-100">{{ $meetings->withQueryString()->links() }}</div>
    </div>

@endsection
