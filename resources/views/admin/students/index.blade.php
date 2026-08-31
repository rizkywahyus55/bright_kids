@extends('layouts.admin')
@section('title', 'Data Murid & Wali')
@section('page-title', 'Data Murid & Wali Murid')
@section('page-subtitle', 'Daftar seluruh murid aktif beserta data orang tua')

@section('content')

    <div class="flex flex-col sm:flex-row gap-3 mb-6">
        <form action="{{ route('admin.siswa.index') }}" method="GET" class="flex gap-2 flex-1">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama murid, wali, atau kelas..." class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm">
            <select name="class_level" onchange="this.form.submit()" class="px-3 py-2.5 rounded-xl border border-slate-200 outline-none text-sm bg-white font-semibold text-slate-700">
                <option value="">Semua Jenjang</option>
                <option value="tk_kecil" {{ request('class_level') === 'tk_kecil' ? 'selected' : '' }}>TK Kecil</option>
                <option value="tk_besar" {{ request('class_level') === 'tk_besar' ? 'selected' : '' }}>TK Besar</option>
                <option value="sd_1" {{ request('class_level') === 'sd_1' ? 'selected' : '' }}>SD Kelas 1</option>
                <option value="sd_2" {{ request('class_level') === 'sd_2' ? 'selected' : '' }}>SD Kelas 2</option>
                <option value="sd_3" {{ request('class_level') === 'sd_3' ? 'selected' : '' }}>SD Kelas 3</option>
            </select>
            <button type="submit" class="px-4 py-2.5 rounded-xl bg-slate-800 text-white text-sm font-bold"><i class="fa-solid fa-magnifying-glass"></i></button>
            @if(request()->hasAny(['search','class_level'])) <a href="{{ route('admin.siswa.index') }}" class="px-3 py-2.5 rounded-xl border text-sm text-slate-600"><i class="fa-solid fa-xmark"></i></a> @endif
        </form>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="text-xs font-bold uppercase tracking-wider text-slate-400 bg-slate-50/70 border-b border-slate-100">
                        <th class="px-5 py-3.5">No</th>
                        <th class="px-5 py-3.5">Nama Murid</th>
                        <th class="px-5 py-3.5">Jenjang</th>
                        <th class="px-5 py-3.5">Asal Sekolah</th>
                        <th class="px-5 py-3.5">Orang Tua / Wali</th>
                        <th class="px-5 py-3.5">WhatsApp</th>
                        <th class="px-5 py-3.5">Sesi Aktif</th>
                        <th class="px-5 py-3.5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100/80">
                    @forelse($students as $i => $st)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-5 py-4 text-xs font-bold text-slate-400">{{ $students->firstItem() + $i }}</td>
                            <td class="px-5 py-4">
                                <a href="{{ route('admin.siswa.show', $st) }}" class="font-bold text-slate-900 hover:text-sky-600 transition-colors block">
                                    {{ $st->full_name }}
                                </a>
                                <div class="text-xs text-slate-400">{{ $st->date_of_birth ? \Carbon\Carbon::parse($st->date_of_birth)->age . ' tahun' : '-' }}</div>
                            </td>
                            <td class="px-5 py-4">
                                <span class="px-2.5 py-1 rounded-full bg-sky-50 text-sky-700 text-xs font-bold">{{ $st->class_level_label }}</span>
                            </td>
                            <td class="px-5 py-4 text-xs text-slate-600">{{ $st->school_origin }}</td>
                            <td class="px-5 py-4 font-semibold text-slate-800 text-sm">{{ $st->parent->full_name ?? '-' }}</td>
                            <td class="px-5 py-4">
                                @if($st->parent?->whatsapp_number)
                                    <span class="text-xs text-emerald-600 font-semibold">
                                        <i class="fa-brands fa-whatsapp mr-0.5"></i> {{ $st->parent->whatsapp_number }}
                                    </span>
                                @else
                                    <span class="text-xs text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-xs text-slate-600">
                                {{ $st->activeRegistration?->schedule->session_name ?? '-' }}
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-center gap-1.5">
                                    <a href="{{ route('admin.siswa.show', $st) }}" class="w-8 h-8 rounded-lg bg-sky-50 text-sky-600 hover:bg-sky-100 flex items-center justify-center transition-colors" title="Lihat Profil">
                                        <i class="fa-solid fa-eye text-xs"></i>
                                    </a>
                                    <a href="{{ route('admin.siswa.edit', $st) }}" class="w-8 h-8 rounded-lg bg-slate-100 text-slate-600 hover:bg-slate-200 flex items-center justify-center transition-colors" title="Edit Data">
                                        <i class="fa-solid fa-pen text-xs"></i>
                                    </a>
                                    <a href="{{ route('admin.laporan-perkembangan.create') }}?student_id={{ $st->id }}" class="w-8 h-8 rounded-lg bg-amber-50 text-amber-700 hover:bg-amber-100 flex items-center justify-center transition-colors" title="Buat Laporan Perkembangan">
                                        <i class="fa-solid fa-chart-line text-xs"></i>
                                    </a>
                                    <form action="{{ route('admin.siswa.destroy', $st) }}" method="POST" onsubmit="return confirm('Hapus data murid ini beserta seluruh pendaftaran & riwayatnya secara permanen?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="w-8 h-8 rounded-lg bg-rose-50 text-rose-500 hover:bg-rose-100 flex items-center justify-center transition-colors" title="Hapus Murid">
                                            <i class="fa-solid fa-trash-can text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="px-5 py-12 text-center text-slate-400 text-sm">Belum ada data murid.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-4 border-t border-slate-100">{{ $students->withQueryString()->links() }}</div>
    </div>

@endsection
