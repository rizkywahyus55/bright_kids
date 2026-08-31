@extends('layouts.admin')
@section('title', 'Manajemen Pendaftaran')
@section('page-title', 'Manajemen Pendaftaran Murid')
@section('page-subtitle', 'Verifikasi, kelola, dan cari data pendaftaran masuk')

@section('content')

    <!-- Filter & Search Bar -->
    <div class="flex flex-col sm:flex-row gap-3 mb-6">
        <form action="{{ route('admin.pendaftaran.index') }}" method="GET" class="flex gap-2 flex-1">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama anak, ortu, atau No. WA..." class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm">
            <select name="status" onchange="this.form.submit()" class="px-3 py-2.5 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm bg-white font-semibold text-slate-700">
                <option value="">Semua Status</option>
                <option value="menunggu_verifikasi" {{ request('status') === 'menunggu_verifikasi' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                <option value="terverifikasi" {{ request('status') === 'terverifikasi' ? 'selected' : '' }}>Terverifikasi</option>
                <option value="ditolak" {{ request('status') === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                <option value="nonaktif" {{ request('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
            </select>
            <button type="submit" class="px-4 py-2.5 rounded-xl bg-slate-800 text-white text-sm font-bold"><i class="fa-solid fa-magnifying-glass"></i></button>
            @if(request()->hasAny(['search','status'])) <a href="{{ route('admin.pendaftaran.index') }}" class="px-3 py-2.5 rounded-xl border border-slate-200 text-sm text-slate-600"><i class="fa-solid fa-xmark"></i></a> @endif
        </form>
        <a href="{{ route('admin.pendaftaran.create') }}" class="flex items-center gap-2 px-5 py-2.5 rounded-xl bg-sky-600 hover:bg-sky-700 text-white text-sm font-bold shadow-md">
            <i class="fa-solid fa-user-plus"></i> Daftarkan Offline
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="text-xs font-bold uppercase tracking-wider text-slate-400 border-b border-slate-100 bg-slate-50/70">
                        <th class="px-5 py-3.5">Kode</th>
                        <th class="px-5 py-3.5">Nama Murid</th>
                        <th class="px-5 py-3.5">Orang Tua / WA</th>
                        <th class="px-5 py-3.5">Jadwal</th>
                        <th class="px-5 py-3.5 text-center">Pembayaran</th>
                        <th class="px-5 py-3.5 text-center">Status</th>
                        <th class="px-5 py-3.5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100/80">
                    @forelse($registrations as $reg)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-5 py-4">
                                <span class="text-xs font-black text-sky-700 bg-sky-50 px-2 py-1 rounded-lg">{{ $reg->registration_code }}</span>
                                <div class="text-xs text-slate-400 mt-1">{{ $reg->registered_at->format('d/m/Y') }}</div>
                            </td>
                            <td class="px-5 py-4">
                                <div class="font-bold text-slate-900">{{ $reg->student->full_name }}</div>
                                <div class="text-xs text-slate-400">{{ $reg->student->class_level_label }}</div>
                            </td>
                            <td class="px-5 py-4">
                                <div class="text-sm font-semibold text-slate-800">{{ $reg->parent->full_name }}</div>
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $reg->parent->whatsapp_number) }}" target="_blank" class="text-xs text-emerald-600 hover:underline font-semibold">
                                    <i class="fa-brands fa-whatsapp mr-0.5"></i> {{ $reg->parent->whatsapp_number }}
                                </a>
                            </td>
                            <td class="px-5 py-4 text-xs text-slate-600">
                                <div class="font-semibold text-slate-800">{{ $reg->schedule->session_name ?? '-' }}</div>
                                <div class="text-slate-400">{{ $reg->schedule->formatted_time ?? '' }}</div>
                            </td>
                            <td class="px-5 py-4 text-center">
                                @php $pay = $reg->latest_payment; @endphp
                                @if($pay && $pay->status === 'lunas')
                                    <span class="px-2 py-1 rounded-lg bg-emerald-100 text-emerald-700 text-xs font-bold">Lunas</span>
                                @else
                                    <span class="px-2 py-1 rounded-lg bg-amber-100 text-amber-700 text-xs font-bold">Pending</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-center">
                                @if($reg->status === 'terverifikasi')
                                    <span class="px-2 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold">Aktif</span>
                                @elseif($reg->status === 'menunggu_verifikasi')
                                    <span class="px-2 py-1 rounded-full bg-amber-100 text-amber-700 text-xs font-bold">Menunggu</span>
                                @elseif($reg->status === 'ditolak')
                                    <span class="px-2 py-1 rounded-full bg-rose-100 text-rose-700 text-xs font-bold">Ditolak</span>
                                @else
                                    <span class="px-2 py-1 rounded-full bg-slate-100 text-slate-500 text-xs font-bold">Nonaktif</span>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    <a href="{{ route('admin.pendaftaran.show', $reg->id) }}" class="w-8 h-8 rounded-lg bg-slate-50 text-slate-600 hover:bg-slate-100 flex items-center justify-center" title="Detail"><i class="fa-solid fa-eye text-xs"></i></a>

                                    @if($reg->status === 'menunggu_verifikasi')
                                        <form action="{{ route('admin.pendaftaran.update-status', $reg->id) }}" method="POST">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="status" value="terverifikasi">
                                            <button type="submit" class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 hover:bg-emerald-100 flex items-center justify-center" title="Verifikasi"><i class="fa-solid fa-check text-xs"></i></button>
                                        </form>
                                        <form action="{{ route('admin.pendaftaran.update-status', $reg->id) }}" method="POST">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="status" value="ditolak">
                                            <button type="submit" onclick="return confirm('Tolak pendaftaran ini?')" class="w-8 h-8 rounded-lg bg-rose-50 text-rose-500 hover:bg-rose-100 flex items-center justify-center" title="Tolak"><i class="fa-solid fa-xmark text-xs"></i></button>
                                        </form>
                                    @endif

                                    <form action="{{ route('admin.pendaftaran.destroy', $reg->id) }}" method="POST" onsubmit="return confirm('Hapus data pendaftaran ini secara permanen?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="w-8 h-8 rounded-lg bg-rose-50 text-rose-500 hover:bg-rose-100 flex items-center justify-center" title="Hapus"><i class="fa-solid fa-trash-can text-xs"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="px-5 py-12 text-center text-slate-400 text-sm">Belum ada data pendaftaran yang ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-4 border-t border-slate-100">{{ $registrations->withQueryString()->links() }}</div>
    </div>

@endsection
