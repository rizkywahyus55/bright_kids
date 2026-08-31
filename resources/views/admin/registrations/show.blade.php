@extends('layouts.admin')
@section('title', 'Detail Pendaftaran – ' . $pendaftaran->registration_code)
@section('page-title', 'Detail Pendaftaran')
@section('page-subtitle', 'Informasi lengkap data pendaftaran murid')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    {{-- Back & Action Bar --}}
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.pendaftaran.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-sky-600 transition-colors">
            <i class="fa-solid fa-arrow-left text-xs"></i> Kembali ke Daftar
        </a>
        <div class="flex items-center gap-2">
            @if($pendaftaran->status === 'menunggu_verifikasi')
                <form action="{{ route('admin.pendaftaran.update-status', $pendaftaran->id) }}" method="POST">
                    @csrf @method('PUT')
                    <input type="hidden" name="status" value="terverifikasi">
                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold shadow-md transition-all">
                        <i class="fa-solid fa-check"></i> Verifikasi Pendaftaran
                    </button>
                </form>
                <form action="{{ route('admin.pendaftaran.update-status', $pendaftaran->id) }}" method="POST">
                    @csrf @method('PUT')
                    <input type="hidden" name="status" value="ditolak">
                    <button type="submit" onclick="return confirm('Tolak pendaftaran ini?')" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-rose-100 hover:bg-rose-200 text-rose-700 text-sm font-bold transition-all">
                        <i class="fa-solid fa-xmark"></i> Tolak
                    </button>
                </form>
            @elseif($pendaftaran->status === 'terverifikasi')
                <form action="{{ route('admin.pendaftaran.update-status', $pendaftaran->id) }}" method="POST">
                    @csrf @method('PUT')
                    <input type="hidden" name="status" value="nonaktif">
                    <button type="submit" onclick="return confirm('Nonaktifkan pendaftaran ini?')" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-bold transition-all">
                        <i class="fa-solid fa-ban"></i> Nonaktifkan
                    </button>
                </form>
            @endif
        </div>
    </div>

    {{-- Header Card --}}
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 flex flex-col sm:flex-row sm:items-center gap-4">
        <div class="w-16 h-16 rounded-2xl bg-sky-100 flex items-center justify-center flex-shrink-0">
            <i class="fa-solid fa-child-reaching text-sky-600 text-2xl"></i>
        </div>
        <div class="flex-1">
            <div class="flex flex-wrap items-center gap-3 mb-1">
                <h2 class="text-xl font-extrabold text-slate-900">{{ $pendaftaran->student->full_name }}</h2>
                <span class="px-2.5 py-1 rounded-full bg-sky-50 text-sky-700 text-xs font-bold">{{ $pendaftaran->student->class_level_label }}</span>
                @if($pendaftaran->status === 'terverifikasi')
                    <span class="px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold"><i class="fa-solid fa-circle-check mr-1"></i>Aktif</span>
                @elseif($pendaftaran->status === 'menunggu_verifikasi')
                    <span class="px-2.5 py-1 rounded-full bg-amber-100 text-amber-700 text-xs font-bold"><i class="fa-solid fa-clock mr-1"></i>Menunggu Verifikasi</span>
                @elseif($pendaftaran->status === 'ditolak')
                    <span class="px-2.5 py-1 rounded-full bg-rose-100 text-rose-700 text-xs font-bold"><i class="fa-solid fa-xmark-circle mr-1"></i>Ditolak</span>
                @else
                    <span class="px-2.5 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-bold">Nonaktif</span>
                @endif
            </div>
            <div class="text-sm text-slate-500">
                Kode Pendaftaran: <span class="font-black text-sky-700">{{ $pendaftaran->registration_code }}</span>
                &nbsp;·&nbsp; Didaftarkan: {{ $pendaftaran->registered_at->format('d F Y, H:i') }}
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- Data Murid --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <h3 class="font-bold text-slate-900 mb-4 flex items-center gap-2">
                <span class="w-7 h-7 rounded-lg bg-sky-500 text-white text-xs font-bold flex items-center justify-center">1</span>
                Data Murid
            </h3>
            <dl class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <dt class="text-slate-500 font-semibold">Nama Lengkap</dt>
                    <dd class="text-slate-900 font-bold">{{ $pendaftaran->student->full_name }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-slate-500 font-semibold">Tanggal Lahir</dt>
                    <dd class="text-slate-900">{{ $pendaftaran->student->date_of_birth->format('d F Y') }} ({{ $pendaftaran->student->date_of_birth->age }} tahun)</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-slate-500 font-semibold">Jenjang</dt>
                    <dd class="text-slate-900">{{ $pendaftaran->student->class_level_label }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-slate-500 font-semibold">Asal Sekolah</dt>
                    <dd class="text-slate-900">{{ $pendaftaran->student->school_origin ?? '-' }}</dd>
                </div>
            </dl>
        </div>

        {{-- Data Orang Tua --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <h3 class="font-bold text-slate-900 mb-4 flex items-center gap-2">
                <span class="w-7 h-7 rounded-lg bg-indigo-500 text-white text-xs font-bold flex items-center justify-center">2</span>
                Data Orang Tua / Wali
            </h3>
            <dl class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <dt class="text-slate-500 font-semibold">Nama Wali</dt>
                    <dd class="text-slate-900 font-bold">{{ $pendaftaran->parent->full_name }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-slate-500 font-semibold">WhatsApp</dt>
                    <dd>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pendaftaran->parent->whatsapp_number) }}" target="_blank" class="text-emerald-600 hover:underline font-semibold">
                            <i class="fa-brands fa-whatsapp mr-1"></i>{{ $pendaftaran->parent->whatsapp_number }}
                        </a>
                    </dd>
                </div>
                <div>
                    <dt class="text-slate-500 font-semibold mb-1">Alamat</dt>
                    <dd class="text-slate-900 leading-relaxed">{{ $pendaftaran->parent->address ?? '-' }}</dd>
                </div>
            </dl>
        </div>

        {{-- Jadwal Belajar --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <h3 class="font-bold text-slate-900 mb-4 flex items-center gap-2">
                <span class="w-7 h-7 rounded-lg bg-amber-500 text-white text-xs font-bold flex items-center justify-center">3</span>
                Jadwal Belajar
            </h3>
            @if($pendaftaran->schedule)
                <dl class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <dt class="text-slate-500 font-semibold">Sesi</dt>
                        <dd class="text-slate-900 font-bold">{{ $pendaftaran->schedule->session_name }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-slate-500 font-semibold">Hari</dt>
                        <dd class="text-slate-900">{{ $pendaftaran->schedule->day }}</dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-slate-500 font-semibold">Waktu</dt>
                        <dd class="text-slate-900">
                            {{ \Carbon\Carbon::parse($pendaftaran->schedule->start_time)->format('H:i') }}
                            – {{ \Carbon\Carbon::parse($pendaftaran->schedule->end_time)->format('H:i') }} WIB
                        </dd>
                    </div>
                    <div class="flex justify-between">
                        <dt class="text-slate-500 font-semibold">Kuota</dt>
                        <dd class="text-slate-900">{{ $pendaftaran->schedule->quota ?? '-' }} murid</dd>
                    </div>
                </dl>
            @else
                <p class="text-slate-400 text-sm">Jadwal tidak tersedia.</p>
            @endif
        </div>

        {{-- Riwayat Pembayaran --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6">
            <h3 class="font-bold text-slate-900 mb-4 flex items-center gap-2">
                <span class="w-7 h-7 rounded-lg bg-emerald-500 text-white text-xs font-bold flex items-center justify-center">4</span>
                Riwayat Pembayaran
            </h3>
            @forelse($pendaftaran->payments as $pay)
                <div class="flex items-center justify-between py-2.5 border-b border-slate-100 last:border-0 text-sm">
                    <div>
                        <div class="font-bold text-slate-800">{{ $pay->payment_code }}</div>
                        <div class="text-xs text-slate-400">
                            {{ $pay->method_label }} · {{ $pay->created_at->format('d/m/Y') }}
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="font-bold text-slate-900">Rp {{ number_format($pay->amount, 0, ',', '.') }}</div>
                        @if($pay->status === 'lunas')
                            <span class="text-xs font-bold text-emerald-600"><i class="fa-solid fa-check-circle mr-0.5"></i>Lunas</span>
                        @elseif($pay->status === 'pending')
                            <span class="text-xs font-bold text-amber-600">Menunggu</span>
                        @else
                            <span class="text-xs font-bold text-rose-500">{{ ucfirst($pay->status) }}</span>
                        @endif
                    </div>
                </div>
            @empty
                <p class="text-slate-400 text-sm text-center py-4">Belum ada riwayat pembayaran.</p>
            @endforelse
        </div>
    </div>

    {{-- Quick Actions --}}
    <div class="bg-slate-50 rounded-2xl border border-slate-200 p-5">
        <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3">Tindakan Cepat</p>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('admin.laporan-perkembangan.create') }}?student_id={{ $pendaftaran->student->id }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-amber-50 text-amber-700 hover:bg-amber-100 text-sm font-bold border border-amber-200 transition-colors">
                <i class="fa-solid fa-chart-line"></i> Buat Laporan Perkembangan
            </a>
            <a href="{{ route('admin.absensi.create') }}?schedule_id={{ $pendaftaran->schedule_id }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-sky-50 text-sky-700 hover:bg-sky-100 text-sm font-bold border border-sky-200 transition-colors">
                <i class="fa-solid fa-calendar-check"></i> Input Absensi Hari Ini
            </a>
            <a href="{{ route('admin.pembayaran.index') }}?search={{ urlencode($pendaftaran->student->full_name) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-emerald-50 text-emerald-700 hover:bg-emerald-100 text-sm font-bold border border-emerald-200 transition-colors">
                <i class="fa-solid fa-money-bill-wave"></i> Lihat Pembayaran
            </a>
            <form action="{{ route('admin.pendaftaran.destroy', $pendaftaran->id) }}" method="POST" onsubmit="return confirm('Hapus data pendaftaran ini secara permanen?')" class="inline">
                @csrf @method('DELETE')
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-100 text-sm font-bold border border-rose-200 transition-colors">
                    <i class="fa-solid fa-trash-can"></i> Hapus Pendaftaran
                </button>
            </form>
        </div>
    </div>

</div>
@endsection
