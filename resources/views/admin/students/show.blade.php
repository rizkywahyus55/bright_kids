@extends('layouts.admin')
@section('title', 'Profil Murid – ' . $siswa->full_name)
@section('page-title', 'Profil Murid')
@section('page-subtitle', 'Riwayat belajar dan data lengkap murid')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">

    {{-- Back bar --}}
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.siswa.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-sky-600 transition-colors">
            <i class="fa-solid fa-arrow-left text-xs"></i> Kembali ke Daftar Murid
        </a>
        <div class="flex gap-2">
            <a href="{{ route('admin.siswa.edit', $siswa) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-900 text-white text-sm font-bold shadow-sm transition-all">
                <i class="fa-solid fa-pen"></i> Edit Data
            </a>
            <a href="{{ route('admin.laporan-perkembangan.create') }}?student_id={{ $siswa->id }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-sky-600 hover:bg-sky-700 text-white text-sm font-bold shadow-sm transition-all">
                <i class="fa-solid fa-plus"></i> Buat Laporan
            </a>
        </div>
    </div>

    {{-- Hero Card --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 flex flex-col sm:flex-row items-start sm:items-center gap-5">
        <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-sky-400 to-indigo-500 flex items-center justify-center flex-shrink-0 text-white text-2xl font-black">
            {{ mb_substr($siswa->full_name, 0, 1) }}
        </div>
        <div class="flex-1">
            <div class="flex flex-wrap items-center gap-3">
                <h2 class="text-xl font-extrabold text-slate-900">{{ $siswa->full_name }}</h2>
                <span class="px-2.5 py-1 rounded-full bg-sky-100 text-sky-700 text-xs font-bold">{{ $siswa->class_level_label }}</span>
                @if($siswa->activeRegistration)
                    <span class="px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold"><i class="fa-solid fa-circle-check mr-1"></i>Aktif</span>
                @else
                    <span class="px-2.5 py-1 rounded-full bg-slate-100 text-slate-500 text-xs font-bold">Tidak Aktif</span>
                @endif
            </div>
            <div class="text-sm text-slate-500 mt-1 space-x-3">
                <span><i class="fa-solid fa-cake-candles mr-1"></i>{{ $siswa->date_of_birth?->format('d F Y') }} ({{ $siswa->date_of_birth?->age }} tahun)</span>
                @if($siswa->school_origin)
                    <span><i class="fa-solid fa-school mr-1"></i>{{ $siswa->school_origin }}</span>
                @endif
            </div>
        </div>
        @if($siswa->activeRegistration?->schedule)
            <div class="text-right text-sm">
                <div class="text-xs text-slate-400 font-semibold uppercase tracking-wide">Sesi Aktif</div>
                <div class="font-bold text-slate-800">{{ $siswa->activeRegistration->schedule->session_name }}</div>
                <div class="text-xs text-slate-500">{{ $siswa->activeRegistration->schedule->day }}</div>
            </div>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Left: Data Orang Tua --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <h3 class="font-bold text-slate-900 mb-4 flex items-center gap-2">
                <span class="w-6 h-6 rounded-lg bg-indigo-500 text-white text-xs font-bold flex items-center justify-center"><i class="fa-solid fa-user-group text-xs"></i></span>
                Data Orang Tua / Wali
            </h3>
            @php $reg = $siswa->registration; @endphp
            @if($reg && $reg->parent)
                <dl class="space-y-2.5 text-sm">
                    <div>
                        <dt class="text-xs font-bold text-slate-400 uppercase">Nama Wali</dt>
                        <dd class="font-bold text-slate-900">{{ $reg->parent->full_name }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-bold text-slate-400 uppercase">WhatsApp</dt>
                        <dd>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $reg->parent->whatsapp_number) }}" target="_blank" class="text-emerald-600 hover:underline font-semibold text-sm">
                                <i class="fa-brands fa-whatsapp mr-1"></i>{{ $reg->parent->whatsapp_number }}
                            </a>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-xs font-bold text-slate-400 uppercase">Alamat</dt>
                        <dd class="text-slate-700 leading-relaxed">{{ $reg->parent->address ?? '-' }}</dd>
                    </div>
                </dl>
                <div class="mt-4 pt-4 border-t border-slate-100">
                    <dt class="text-xs font-bold text-slate-400 uppercase mb-1">Kode Pendaftaran</dt>
                    <dd><span class="font-black text-sky-700 text-sm bg-sky-50 px-2 py-0.5 rounded-lg">{{ $reg->registration_code }}</span></dd>
                </div>
            @else
                <p class="text-slate-400 text-sm">Tidak ada data orang tua.</p>
            @endif
        </div>

        {{-- Right: Stats + Attendance Summary --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Stat Cards --}}
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-sky-50 rounded-2xl p-4 text-center border border-sky-100">
                    <div class="text-2xl font-extrabold text-sky-700">{{ $siswa->attendances->count() }}</div>
                    <div class="text-xs font-bold text-sky-600 mt-1">Total Pertemuan</div>
                </div>
                <div class="bg-emerald-50 rounded-2xl p-4 text-center border border-emerald-100">
                    <div class="text-2xl font-extrabold text-emerald-700">{{ $siswa->attendances->where('status', 'hadir')->count() }}</div>
                    <div class="text-xs font-bold text-emerald-600 mt-1">Hadir</div>
                </div>
                <div class="bg-amber-50 rounded-2xl p-4 text-center border border-amber-100">
                    <div class="text-2xl font-extrabold text-amber-700">{{ $siswa->progressReports->count() }}</div>
                    <div class="text-xs font-bold text-amber-600 mt-1">Laporan</div>
                </div>
            </div>

            {{-- Recent Attendance --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
                <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="font-bold text-slate-900 text-sm">Riwayat Kehadiran Terbaru</h3>
                    <a href="{{ route('admin.absensi.index') }}" class="text-xs font-semibold text-sky-600 hover:underline">Lihat Semua</a>
                </div>
                <div class="divide-y divide-slate-100">
                    @forelse($siswa->attendances->sortByDesc(fn($a) => $a->meeting?->meeting_date)->take(6) as $att)
                        <div class="flex items-center justify-between px-5 py-3 text-sm">
                            <div>
                                <div class="font-semibold text-slate-800">{{ $att->meeting?->meeting_date ? \Carbon\Carbon::parse($att->meeting->meeting_date)->locale('id')->translatedFormat('d F Y') : '-' }}</div>
                                @if($att->notes)
                                    <div class="text-xs text-slate-500 italic mt-0.5"><i class="fa-regular fa-comment-dots mr-1 text-slate-400"></i>{{ $att->notes }}</div>
                                @endif
                            </div>
                            <div class="flex items-center gap-2">
                                @if($att->status === 'hadir')
                                    <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold">Hadir</span>
                                @elseif($att->status === 'izin')
                                    <span class="px-2 py-0.5 rounded-full bg-sky-100 text-sky-700 text-xs font-bold">Izin</span>
                                @elseif($att->status === 'sakit')
                                    <span class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-700 text-xs font-bold">Sakit</span>
                                @else
                                    <span class="px-2 py-0.5 rounded-full bg-rose-100 text-rose-600 text-xs font-bold">Tidak Hadir</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="px-5 py-8 text-center text-slate-400 text-sm">Belum ada riwayat kehadiran.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- Progress Reports --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="font-bold text-slate-900">Laporan Perkembangan Belajar</h3>
            <a href="{{ route('admin.laporan-perkembangan.create') }}?student_id={{ $siswa->id }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-amber-50 text-amber-700 hover:bg-amber-100 text-xs font-bold border border-amber-200 transition-colors">
                <i class="fa-solid fa-plus text-xs"></i> Tambah Laporan
            </a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="text-xs font-bold uppercase tracking-wider text-slate-400 bg-slate-50/70 border-b border-slate-100">
                        <th class="px-5 py-3">Periode</th>
                        <th class="px-5 py-3">Tahap Belajar</th>
                        <th class="px-5 py-3">Membaca</th>
                        <th class="px-5 py-3">Menulis</th>
                        <th class="px-5 py-3">Kehadiran</th>
                        <th class="px-5 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($siswa->progressReports->sortByDesc('created_at') as $rpt)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-5 py-3.5 font-bold text-slate-900">{{ $rpt->period }}</td>
                            <td class="px-5 py-3.5 text-slate-700">{{ $rpt->current_stage }}</td>
                            <td class="px-5 py-3.5 text-xs text-slate-600">{{ $rpt->reading_skill ?? '-' }}</td>
                            <td class="px-5 py-3.5 text-xs text-slate-600">{{ $rpt->writing_skill ?? '-' }}</td>
                            <td class="px-5 py-3.5 text-xs text-slate-600">{{ $rpt->attendance_summary ?? '-' }}</td>
                            <td class="px-5 py-3.5 text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('admin.laporan-perkembangan.pdf', $rpt->id) }}" target="_blank" class="w-7 h-7 rounded-lg bg-rose-50 text-rose-600 hover:bg-rose-100 flex items-center justify-center text-xs" title="Lihat & Cetak PDF">
                                        <i class="fa-solid fa-file-pdf"></i>
                                    </a>
                                    <a href="{{ route('admin.laporan-perkembangan.edit', $rpt->id) }}" class="w-7 h-7 rounded-lg bg-sky-50 text-sky-600 hover:bg-sky-100 flex items-center justify-center text-xs" title="Edit">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form action="{{ route('admin.laporan-perkembangan.destroy', $rpt->id) }}" method="POST" onsubmit="return confirm('Hapus laporan ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="w-7 h-7 rounded-lg bg-rose-50 text-rose-500 hover:bg-rose-100 flex items-center justify-center text-xs" title="Hapus">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="px-5 py-10 text-center text-slate-400 text-sm">Belum ada laporan perkembangan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
