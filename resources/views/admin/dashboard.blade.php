@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Utama')
@section('page-subtitle', 'Ringkasan aktivitas bimbingan belajar hari ini')

@section('content')

    <!-- Stat Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-xl bg-sky-100 text-sky-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-children"></i>
                </div>
                <span class="text-xs font-bold text-slate-400 uppercase">Murid Aktif</span>
            </div>
            <div class="text-3xl font-black text-slate-900">{{ $totalStudents }}</div>
            <p class="text-xs text-slate-500 mt-1">Total murid aktif</p>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </div>
                <span class="text-xs font-bold text-slate-400 uppercase">Menunggu</span>
            </div>
            <div class="text-3xl font-black text-slate-900">{{ $pendingRegistrations }}</div>
            <p class="text-xs text-slate-500 mt-1">Pendaftaran belum diverifikasi</p>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-money-bill-wave"></i>
                </div>
                <span class="text-xs font-bold text-slate-400 uppercase">Pembayaran</span>
            </div>
            <div class="text-3xl font-black text-slate-900">{{ $pendingPayments }}</div>
            <p class="text-xs text-slate-500 mt-1">Transaksi belum lunas</p>
        </div>

        <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-lg">
                    <i class="fa-solid fa-clipboard-check"></i>
                </div>
                <span class="text-xs font-bold text-slate-400 uppercase">Hadir Hari Ini</span>
            </div>
            <div class="text-3xl font-black text-slate-900">{{ $todayAttendanceCount }}</div>
            <p class="text-xs text-slate-500 mt-1">Murid hadir dari {{ $todayMeetingCount }} sesi aktif</p>
        </div>

    </div>

    <!-- Quick Action Buttons -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-6">
        <a href="{{ route('admin.absensi.create') }}" class="flex flex-col items-center gap-2 p-4 bg-sky-600 hover:bg-sky-700 rounded-2xl text-white text-sm font-bold text-center transition-all shadow-md shadow-sky-600/20">
            <i class="fa-solid fa-clipboard-list text-2xl"></i>
            Input Absensi Hari Ini
        </a>
        <a href="{{ route('admin.pendaftaran.create') }}" class="flex flex-col items-center gap-2 p-4 bg-indigo-600 hover:bg-indigo-700 rounded-2xl text-white text-sm font-bold text-center transition-all shadow-md shadow-indigo-600/20">
            <i class="fa-solid fa-user-plus text-2xl"></i>
            Pendaftaran Offline Murid
        </a>
        <a href="{{ route('admin.laporan-perkembangan.create') }}" class="flex flex-col items-center gap-2 p-4 bg-amber-500 hover:bg-amber-600 rounded-2xl text-white text-sm font-bold text-center transition-all shadow-md shadow-amber-500/20">
            <i class="fa-solid fa-chart-line text-2xl"></i>
            Buat Laporan Belajar
        </a>
        <a href="{{ route('admin.pembayaran.index') }}" class="flex flex-col items-center gap-2 p-4 bg-emerald-600 hover:bg-emerald-700 rounded-2xl text-white text-sm font-bold text-center transition-all shadow-md shadow-emerald-600/20">
            <i class="fa-solid fa-cash-register text-2xl"></i>
            Catat Bayar Tunai
        </a>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">

        <!-- Recent Registrations -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm">
            <div class="flex items-center justify-between p-5 border-b border-slate-100">
                <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-file-pen text-sky-500"></i> Pendaftaran Terbaru
                </h3>
                <a href="{{ route('admin.pendaftaran.index') }}" class="text-xs font-bold text-sky-600 hover:underline">Lihat Semua →</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="text-xs font-bold uppercase tracking-wider text-slate-400 border-b border-slate-100">
                            <th class="px-5 py-3">Nama Anak</th>
                            <th class="px-5 py-3">Jadwal</th>
                            <th class="px-5 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($recentRegistrations as $reg)
                            <tr class="hover:bg-slate-50/50">
                                <td class="px-5 py-3.5">
                                    <div class="font-bold text-slate-900 text-sm">{{ $reg->student->full_name }}</div>
                                    <div class="text-xs text-slate-400">{{ $reg->student->class_level_label }}</div>
                                </td>
                                <td class="px-5 py-3.5 text-xs text-slate-600">
                                    {{ $reg->schedule->session_name ?? '-' }}
                                </td>
                                <td class="px-5 py-3.5">
                                    @if($reg->status === 'terverifikasi')
                                        <span class="px-2 py-1 rounded-lg bg-emerald-100 text-emerald-700 text-xs font-bold">Aktif</span>
                                    @elseif($reg->status === 'menunggu_verifikasi')
                                        <span class="px-2 py-1 rounded-lg bg-amber-100 text-amber-700 text-xs font-bold">Menunggu</span>
                                    @else
                                        <span class="px-2 py-1 rounded-lg bg-slate-100 text-slate-600 text-xs font-bold">{{ $reg->status_label }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="px-5 py-8 text-center text-xs text-slate-400">Belum ada data pendaftaran.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Recent Payments -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm">
            <div class="flex items-center justify-between p-5 border-b border-slate-100">
                <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                    <i class="fa-solid fa-money-bill-trend-up text-emerald-500"></i> Transaksi Pembayaran Terbaru
                </h3>
                <a href="{{ route('admin.pembayaran.index') }}" class="text-xs font-bold text-sky-600 hover:underline">Lihat Semua →</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="text-xs font-bold uppercase tracking-wider text-slate-400 border-b border-slate-100">
                            <th class="px-5 py-3">Murid</th>
                            <th class="px-5 py-3">Nominal</th>
                            <th class="px-5 py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($recentPayments as $pay)
                            <tr class="hover:bg-slate-50/50">
                                <td class="px-5 py-3.5">
                                    <div class="font-bold text-slate-900 text-sm">{{ $pay->registration->student->full_name ?? '-' }}</div>
                                    <div class="text-xs text-slate-400">{{ $pay->payment_code }}</div>
                                </td>
                                <td class="px-5 py-3.5 font-bold text-slate-900 text-sm">
                                    Rp {{ number_format($pay->amount, 0, ',', '.') }}
                                </td>
                                <td class="px-5 py-3.5">
                                    @if($pay->status === 'lunas')
                                        <span class="px-2 py-1 rounded-lg bg-emerald-100 text-emerald-700 text-xs font-bold">Lunas</span>
                                    @elseif($pay->status === 'pending')
                                        <span class="px-2 py-1 rounded-lg bg-amber-100 text-amber-700 text-xs font-bold">Pending</span>
                                    @else
                                        <span class="px-2 py-1 rounded-lg bg-rose-100 text-rose-600 text-xs font-bold">{{ $pay->status }}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="px-5 py-8 text-center text-xs text-slate-400">Belum ada data pembayaran.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

@endsection
