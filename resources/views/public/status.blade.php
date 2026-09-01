@extends('layouts.app')

@section('title', 'Status Pendaftaran & Pembayaran - Bright Kids')

@section('content')

    <section class="py-12 md:py-20 bg-slate-50 min-h-[80vh]">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center max-w-2xl mx-auto mb-10 space-y-3">
                <div class="flex justify-center mb-1">
                    <a href="{{ route('home') }}" class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white border border-slate-200 text-slate-600 hover:text-sky-600 hover:border-sky-300 text-xs font-bold transition-all shadow-sm">
                        <i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda
                    </a>
                </div>
                <span class="px-3 py-1 rounded-full bg-sky-100 text-sky-700 text-xs font-bold uppercase tracking-wider">Pencarian Pendaftaran</span>
                <h1 class="text-3xl font-extrabold text-slate-900">Cek Status Pendaftaran & Pembayaran</h1>
                <p class="text-slate-600 text-sm">Masukkan Kode Pendaftaran, Nama Anak, atau Nomor WhatsApp yang didaftarkan.</p>
            </div>

            <!-- Search Form -->
            <div class="bg-white rounded-2xl p-4 sm:p-6 border border-slate-200 shadow-md mb-10">
                <form action="{{ route('pendaftaran.status') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                    <input type="text" name="query" value="{{ $searchCode }}" placeholder="Contoh: BK-2026-0001 atau 081234567890" required class="flex-grow px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 focus:ring-2 focus:ring-sky-200 outline-none text-sm transition-all">
                    <button type="submit" class="px-7 py-3 rounded-xl font-bold text-white bg-sky-600 hover:bg-sky-700 shadow-md transition-all flex items-center justify-center gap-2">
                        <i class="fa-solid fa-magnifying-glass"></i> Cari Data
                    </button>
                </form>
            </div>

            @if(session('success'))
                <div class="mb-8 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-2xl text-emerald-500"></i>
                    <div>
                        <h4 class="font-bold text-sm">Pendaftaran Diterima!</h4>
                        <p class="text-xs">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            @if($searchCode && !$registration)
                <div class="bg-white rounded-3xl p-12 text-center border border-slate-200 shadow-sm space-y-4">
                    <div class="w-16 h-16 rounded-full bg-amber-100 text-amber-600 flex items-center justify-center text-3xl mx-auto">
                        <i class="fa-solid fa-folder-open"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800">Data Pendaftaran Tidak Ditemukan</h3>
                    <p class="text-sm text-slate-500 max-w-md mx-auto">
                        Pencarian untuk "<strong>{{ $searchCode }}</strong>" tidak cocok dengan data pendaftaran mana pun. Pastikan penulisan kode atau nomor telepon WhatsApp sudah benar.
                    </p>
                    <a href="{{ route('home') }}#pendaftaran" class="inline-block px-6 py-2.5 rounded-xl text-sm font-bold text-sky-700 bg-sky-50 border border-sky-200 hover:bg-sky-100">
                        Isi Form Pendaftaran Baru
                    </a>
                </div>
            @endif

            @if($registration)
                <div class="bg-white rounded-3xl border border-slate-200 shadow-xl overflow-hidden">
                    
                    <!-- Status Header Banner -->
                    <div class="p-6 sm:p-8 bg-gradient-to-r from-slate-900 to-sky-900 text-white flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                        <div>
                            <span class="text-xs font-bold text-sky-300 uppercase tracking-wider">Kode Pendaftaran</span>
                            <h2 class="text-3xl font-black text-white tracking-tight">{{ $registration->registration_code }}</h2>
                            <p class="text-xs text-slate-300 mt-1">Terdaftar pada: {{ $registration->registered_at ? \Carbon\Carbon::parse($registration->registered_at)->locale('id')->translatedFormat('d F Y, H:i') . ' WIB' : '-' }}</p>
                        </div>

                        <div>
                            @if($registration->status === 'terverifikasi')
                                <span class="px-4 py-2 rounded-xl bg-emerald-500 text-white font-bold text-xs uppercase tracking-wider flex items-center gap-1.5 shadow-md">
                                    <i class="fa-solid fa-circle-check"></i> {{ $registration->status_label }}
                                </span>
                            @elseif($registration->status === 'menunggu_verifikasi')
                                <span class="px-4 py-2 rounded-xl bg-amber-500 text-white font-bold text-xs uppercase tracking-wider flex items-center gap-1.5 shadow-md">
                                    <i class="fa-solid fa-clock"></i> {{ $registration->status_label }}
                                </span>
                            @else
                                <span class="px-4 py-2 rounded-xl bg-rose-500 text-white font-bold text-xs uppercase tracking-wider flex items-center gap-1.5 shadow-md">
                                    {{ $registration->status_label }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Details Body -->
                    <div class="p-6 sm:p-8 space-y-8">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            
                            <!-- Student & Parent Details -->
                            <div class="space-y-4">
                                <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider pb-2 border-b border-slate-100">
                                    Informasi Siswa & Orang Tua
                                </h3>

                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-slate-500">Nama Siswa:</span>
                                        <span class="font-bold text-slate-900">{{ $registration->student->full_name }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-slate-500">Jenjang / Kelas:</span>
                                        <span class="font-semibold text-slate-800">{{ $registration->student->class_level_label }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-slate-500">Asal Sekolah:</span>
                                        <span class="text-slate-800">{{ $registration->student->school_origin }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-slate-500">Orang Tua / Wali:</span>
                                        <span class="font-semibold text-slate-900">{{ $registration->parent->full_name }}</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-slate-500">No. WhatsApp:</span>
                                        <span class="font-bold text-sky-600">{{ $registration->parent->whatsapp_number }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Schedule & Session -->
                            <div class="space-y-4">
                                <h3 class="text-sm font-bold text-slate-400 uppercase tracking-wider pb-2 border-b border-slate-100">
                                    Jadwal Sesi Belajar
                                </h3>

                                <div class="p-4 rounded-2xl bg-sky-50 border border-sky-100 space-y-2 text-sm">
                                    <div class="font-bold text-sky-900 text-base">
                                        {{ $registration->schedule->session_name ?? 'Sesi Belajar' }}
                                    </div>
                                    <div class="text-slate-700 font-medium">
                                        <i class="fa-regular fa-calendar mr-1 text-sky-600"></i> Hari: {{ $registration->schedule->day ?? '-' }}
                                    </div>
                                    <div class="text-slate-700 font-medium">
                                        <i class="fa-regular fa-clock mr-1 text-sky-600"></i> Jam: {{ $registration->schedule->formatted_time ?? '-' }}
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Payment Section -->
                        <div class="pt-6 border-t border-slate-200">
                            <h3 class="text-base font-bold text-slate-900 mb-4 flex items-center gap-2">
                                <i class="fa-solid fa-credit-card text-sky-600"></i> Status Pembayaran Biaya Bimbingan
                            </h3>

                            @php
                                $payment = $registration->latest_payment;
                            @endphp

                            <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/80 space-y-6">
                                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 pb-4 border-b border-slate-200">
                                    <div>
                                        <span class="text-xs font-bold text-slate-400 uppercase">Nominal {{ $payment ? $payment->notes : 'Biaya Awal Bimbel' }}</span>
                                        <div class="text-3xl font-black text-slate-900">
                                            Rp {{ number_format($payment ? $payment->amount : 50000, 0, ',', '.') }}
                                        </div>
                                    </div>

                                    <div>
                                        @if($payment && $payment->status === 'lunas')
                                            <span class="px-4 py-2 rounded-xl bg-emerald-100 text-emerald-800 font-bold text-xs uppercase tracking-wider flex items-center gap-1.5">
                                                <i class="fa-solid fa-check-circle text-emerald-600"></i> Pembayaran Lunas
                                            </span>
                                        @else
                                            <span class="px-4 py-2 rounded-xl bg-amber-100 text-amber-800 font-bold text-xs uppercase tracking-wider flex items-center gap-1.5">
                                                <i class="fa-solid fa-clock"></i> Belum Dibayar
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                @if(!$payment || $payment->status !== 'lunas')
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2">
                                        
                                        <!-- Opsi 1: Pembayaran Online -->
                                        <div class="bg-white p-6 rounded-2xl border border-sky-100 shadow-sm space-y-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-xl bg-sky-500 text-white flex items-center justify-center font-bold">
                                                    <i class="fa-solid fa-bolt"></i>
                                                </div>
                                                <div>
                                                    <h4 class="font-bold text-slate-900 text-sm">Pembayaran Online</h4>
                                                    <p class="text-xs text-slate-500">Virtual Account (BRI, BCA, Mandiri, BNI, QRIS)</p>
                                                </div>
                                            </div>

                                            <button id="pay-button" class="w-full py-3.5 rounded-xl font-bold text-white bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 shadow-md shadow-sky-500/20 transition-all flex items-center justify-center gap-2">
                                                <i class="fa-solid fa-lock"></i> Bayar Online Sekarang
                                            </button>
                                        </div>

                                        <!-- Opsi 2: Pembayaran Tunai -->
                                        <div class="bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-3">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-xl bg-amber-500 text-white flex items-center justify-center font-bold">
                                                    <i class="fa-solid fa-money-bill-wave"></i>
                                                </div>
                                                <div>
                                                    <h4 class="font-bold text-slate-900 text-sm">Pembayaran Tunai</h4>
                                                    <p class="text-xs text-slate-500">Bayar langsung saat pertama kali datang bimbingan</p>
                                                </div>
                                            </div>

                                            <p class="text-xs text-slate-600 leading-relaxed pt-1">
                                                Silakan datang langsung ke alamat rumah Ibu Pengajar di: <br>
                                                <strong class="text-slate-800">{{ $settings['address'] }}</strong>
                                            </p>
                                        </div>

                                    </div>
                                @else
                                    <div class="p-4 rounded-2xl bg-emerald-50 text-emerald-800 text-xs font-semibold flex items-center gap-3">
                                        <i class="fa-solid fa-circle-check text-xl text-emerald-600"></i>
                                        <div>
                                            Terima kasih! <strong>{{ $payment->notes ?? 'Pembayaran' }}</strong> telah terkonfirmasi <strong>LUNAS</strong> pada {{ $payment->paid_at ? \Carbon\Carbon::parse($payment->paid_at)->locale('id')->translatedFormat('d F Y, H:i') . ' WIB' : '-' }}.
                                        </div>
                                    </div>

                                    {{-- Formulir Bayar Biaya Bulanan Online --}}
                                    <div class="p-5 rounded-2xl bg-white border border-emerald-200 shadow-sm space-y-4">
                                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 pb-3 border-b border-slate-100">
                                            <div class="flex items-center gap-3">
                                                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-emerald-500 to-teal-600 text-white flex items-center justify-center font-bold text-base shadow-sm">
                                                    <i class="fa-solid fa-calendar-check"></i>
                                                </div>
                                                <div>
                                                    <h4 class="font-bold text-slate-900 text-sm">Bayar Biaya Bulanan Online</h4>
                                                    <p class="text-xs text-slate-500">Bisa bayar dari rumah via Virtual Account (Mandiri, BCA, BRI, BNI) / QRIS</p>
                                                </div>
                                            </div>
                                            <div class="text-left sm:text-right">
                                                <span class="text-[11px] text-slate-400 font-semibold block uppercase">Tarif Bulanan</span>
                                                <span class="text-base sm:text-lg font-black text-emerald-600">Rp 150.000</span>
                                            </div>
                                        </div>

                                        @php
                                            $monthsList = [
                                                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                                                5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                                                9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                                            ];
                                            $currentYear = now()->year;
                                            $currentMonthNum = now()->month;
                                        @endphp

                                        <div class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-end pt-1">
                                            <div class="sm:col-span-4">
                                                <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Pilih Bulan</label>
                                                <select id="monthly-month-select" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 outline-none text-sm font-semibold text-slate-800 bg-white">
                                                    @foreach($monthsList as $num => $mName)
                                                        <option value="{{ $mName }}" {{ $num == $currentMonthNum ? 'selected' : '' }}>
                                                            {{ $mName }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="sm:col-span-3">
                                                <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Tahun</label>
                                                <select id="monthly-year-select" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 outline-none text-sm font-semibold text-slate-800 bg-white">
                                                    <option value="{{ $currentYear }}" selected>{{ $currentYear }}</option>
                                                    <option value="{{ $currentYear + 1 }}">{{ $currentYear + 1 }}</option>
                                                </select>
                                            </div>
                                            <div class="sm:col-span-5">
                                                <button type="button" id="pay-monthly-button" class="w-full py-2.5 px-4 rounded-xl font-bold text-white bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 shadow-md shadow-emerald-500/20 transition-all flex items-center justify-center gap-2 text-sm">
                                                    <i class="fa-solid fa-credit-card"></i>
                                                    <span>Bayar Biaya Bulanan</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                {{-- Riwayat Semua Pembayaran --}}
                                @if($registration->payments && $registration->payments->count() > 0)
                                    <div class="pt-4 border-t border-slate-200/80">
                                        <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-3 flex items-center gap-2">
                                            <i class="fa-solid fa-receipt text-sky-600"></i> Riwayat Pembayaran Bimbingan
                                        </h4>
                                        <div class="overflow-x-auto rounded-2xl border border-slate-200 bg-white">
                                            <table class="w-full text-left text-xs">
                                                <thead>
                                                    <tr class="bg-slate-50 text-slate-400 font-bold uppercase tracking-wider border-b border-slate-100">
                                                        <th class="px-4 py-3">Kode Bayar</th>
                                                        <th class="px-4 py-3">Keterangan</th>
                                                        <th class="px-4 py-3">Nominal</th>
                                                        <th class="px-4 py-3">Metode</th>
                                                        <th class="px-4 py-3">Tanggal Bayar</th>
                                                        <th class="px-4 py-3 text-center">Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-slate-100">
                                                    @foreach($registration->payments as $p)
                                                        <tr class="hover:bg-slate-50/60 transition-colors">
                                                            <td class="px-4 py-3 font-mono font-bold text-slate-800">{{ $p->payment_code }}</td>
                                                            <td class="px-4 py-3 font-semibold text-slate-800">{{ $p->notes ?? 'Pembayaran Bimbel' }}</td>
                                                            <td class="px-4 py-3 font-black text-slate-900">Rp {{ number_format($p->amount, 0, ',', '.') }}</td>
                                                            <td class="px-4 py-3 capitalize text-slate-600">
                                                                <span class="px-2 py-0.5 rounded-md bg-slate-100 text-slate-700 font-semibold">{{ $p->method }}</span>
                                                            </td>
                                                            <td class="px-4 py-3 text-slate-500">
                                                                {{ $p->paid_at ? \Carbon\Carbon::parse($p->paid_at)->locale('id')->translatedFormat('d M Y, H:i') . ' WIB' : '-' }}
                                                            </td>
                                                            <td class="px-4 py-3 text-center">
                                                                @if($p->status === 'lunas')
                                                                    <span class="px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-800 font-bold text-[11px]">
                                                                        <i class="fa-solid fa-check mr-0.5"></i> Lunas
                                                                    </span>
                                                                @else
                                                                    <span class="px-2.5 py-1 rounded-full bg-amber-100 text-amber-800 font-bold text-[11px]">
                                                                        <i class="fa-solid fa-clock mr-0.5"></i> Pending
                                                                    </span>
                                                                @endif
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                @endif
                            </div>

                        </div>

                        {{-- Laporan Perkembangan Belajar Murid --}}
                        @php
                            $reports = $registration->student ? $registration->student->progressReports->sortByDesc('created_at') : collect();
                        @endphp
                        <div class="p-6 rounded-3xl bg-slate-50 border border-slate-200/80 space-y-5">
                            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 pb-4 border-b border-slate-200">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-amber-500 to-orange-500 text-white flex items-center justify-center font-bold text-base shadow-sm">
                                        <i class="fa-solid fa-graduation-cap"></i>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-slate-900 text-base">Laporan Perkembangan Belajar Murid</h3>
                                        <p class="text-xs text-slate-500">Evaluasi membaca, menulis, dan perkembangan ananda selama bimbingan belajar</p>
                                    </div>
                                </div>
                                @if($reports->isNotEmpty())
                                    <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-800 text-xs font-bold">
                                        {{ $reports->count() }} Laporan Tersedia
                                    </span>
                                @endif
                            </div>

                            @if($reports->isNotEmpty())
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach($reports as $rpt)
                                        <div class="p-5 rounded-2xl border border-slate-200 bg-white shadow-sm flex flex-col justify-between space-y-4 hover:border-amber-300 transition-all">
                                            <div class="space-y-3">
                                                <div class="flex items-center justify-between">
                                                    <span class="px-2.5 py-1 rounded-lg bg-amber-50 border border-amber-200 text-amber-800 text-xs font-bold">
                                                        <i class="fa-solid fa-calendar-check mr-1"></i> Periode: {{ $rpt->report_period ?: \Carbon\Carbon::parse($rpt->created_at)->locale('id')->translatedFormat('F Y') }}
                                                    </span>
                                                    <span class="text-[11px] text-slate-400 font-medium">
                                                        {{ \Carbon\Carbon::parse($rpt->created_at)->locale('id')->translatedFormat('d M Y') }}
                                                    </span>
                                                </div>

                                                <div class="grid grid-cols-2 gap-2 text-xs pt-1">
                                                    <div class="bg-slate-50 p-2.5 rounded-xl border border-slate-100">
                                                        <span class="text-slate-400 block text-[10px] uppercase font-bold">Mengenal Huruf</span>
                                                        <span class="font-bold text-slate-800 capitalize">{{ str_replace('_', ' ', $rpt->letter_recognition) }}</span>
                                                    </div>
                                                    <div class="bg-slate-50 p-2.5 rounded-xl border border-slate-100">
                                                        <span class="text-slate-400 block text-[10px] uppercase font-bold">Membaca Kata</span>
                                                        <span class="font-bold text-slate-800 capitalize">{{ str_replace('_', ' ', $rpt->word_reading) }}</span>
                                                    </div>
                                                    <div class="bg-slate-50 p-2.5 rounded-xl border border-slate-100">
                                                        <span class="text-slate-400 block text-[10px] uppercase font-bold">Menulis & Motorik</span>
                                                        <span class="font-bold text-slate-800 capitalize">{{ str_replace('_', ' ', $rpt->writing_motoric) }}</span>
                                                    </div>
                                                    <div class="bg-slate-50 p-2.5 rounded-xl border border-slate-100">
                                                        <span class="text-slate-400 block text-[10px] uppercase font-bold">Keaktifan / Sikap</span>
                                                        <span class="font-bold text-slate-800 capitalize">{{ str_replace('_', ' ', $rpt->behavior_attitude) }}</span>
                                                    </div>
                                                </div>

                                                @if($rpt->progress_narrative)
                                                    <div class="p-3 rounded-xl bg-slate-50 border border-slate-100">
                                                        <span class="text-[10px] uppercase font-bold text-slate-400 block mb-1">Catatan Evaluasi:</span>
                                                        <p class="text-xs text-slate-700 leading-relaxed italic">
                                                            "{{ Str::limit($rpt->progress_narrative, 140) }}"
                                                        </p>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="pt-2">
                                                <a href="{{ route('laporan.public-pdf', $rpt->id) }}" target="_blank" class="w-full py-2.5 px-4 rounded-xl bg-gradient-to-r from-amber-500 to-orange-500 hover:from-amber-600 hover:to-orange-600 text-white font-bold text-xs flex items-center justify-center gap-2 shadow-md shadow-amber-500/20 transition-all">
                                                    <i class="fa-solid fa-file-pdf"></i>
                                                    <span>Lihat & Unduh Laporan PDF</span>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="p-8 text-center text-slate-400 bg-white rounded-2xl border border-dashed border-slate-200">
                                    <i class="fa-solid fa-file-circle-check text-4xl mb-2 text-slate-300 block"></i>
                                    <p class="font-semibold text-slate-600 text-sm">Belum ada laporan perkembangan yang diterbitkan</p>
                                    <p class="text-xs text-slate-400 mt-1">Laporan evaluasi membaca dan menulis ananda akan diterbitkan secara berkala oleh Ibu Pengajar di sini.</p>
                                </div>
                            @endif
                        </div>

                    </div>

                </div>
            @endif

        </div>
    </section>

@endsection

@push('scripts')
    @if($registration)
        <!-- Midtrans Snap JS -->
        <script src="{{ $settings['midtrans_is_production'] == '1' ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js' }}" data-client-key="{{ $settings['midtrans_client_key'] }}"></script>

        <script>
            // Handler: Bayar Biaya Awal Bimbel
            const payButton = document.getElementById('pay-button');
            if (payButton) {
                payButton.addEventListener('click', function () {
                    payButton.disabled = true;
                    payButton.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Memproses Token...';

                    fetch("{{ route('pembayaran.snap', ['code' => $registration->registration_code]) }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            payment_type: 'biaya_awal'
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        payButton.disabled = false;
                        payButton.innerHTML = '<i class="fa-solid fa-lock"></i> Bayar Online Sekarang';

                        if (data.status === 'success' && data.snap_token) {
                            window.snap.pay(data.snap_token, {
                                onSuccess: function (result) {
                                    alert("Pembayaran berhasil!");
                                    window.location.reload();
                                },
                                onPending: function (result) {
                                    alert("Menunggu pembayaran Anda via Virtual Account / QRIS.");
                                    window.location.reload();
                                },
                                onError: function (result) {
                                    alert("Pembayaran gagal atau dibatalkan.");
                                },
                                onClose: function () {
                                    console.log('Customer closed payment popup without finishing payment.');
                                }
                            });
                        } else {
                            alert(data.message || "Gagal membuat sesi pembayaran Midtrans.");
                        }
                    })
                    .catch(error => {
                        payButton.disabled = false;
                        payButton.innerHTML = '<i class="fa-solid fa-lock"></i> Bayar Online Sekarang';
                        alert("Terjadi kesalahan sistem saat menghubungi gateway Midtrans.");
                    });
                });
            }

            // Handler: Bayar Biaya Bulanan
            const payMonthlyButton = document.getElementById('pay-monthly-button');
            const monthSelect = document.getElementById('monthly-month-select');
            const yearSelect = document.getElementById('monthly-year-select');
            if (payMonthlyButton) {
                payMonthlyButton.addEventListener('click', function () {
                    const selectedMonth = (monthSelect ? monthSelect.value : '') + ' ' + (yearSelect ? yearSelect.value : '');
                    payMonthlyButton.disabled = true;
                    payMonthlyButton.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Memproses Token...';

                    fetch("{{ route('pembayaran.snap', ['code' => $registration->registration_code]) }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            payment_type: 'biaya_bulanan',
                            month: selectedMonth
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        payMonthlyButton.disabled = false;
                        payMonthlyButton.innerHTML = '<i class="fa-solid fa-credit-card"></i> <span>Bayar Biaya Bulanan</span>';

                        if (data.status === 'success' && data.snap_token) {
                            window.snap.pay(data.snap_token, {
                                onSuccess: function (result) {
                                    alert("Pembayaran Biaya Bulanan (" + selectedMonth + ") berhasil!");
                                    window.location.reload();
                                },
                                onPending: function (result) {
                                    alert("Menunggu pembayaran Biaya Bulanan (" + selectedMonth + ") Anda via Virtual Account / QRIS.");
                                    window.location.reload();
                                },
                                onError: function (result) {
                                    alert("Pembayaran gagal atau dibatalkan.");
                                },
                                onClose: function () {
                                    console.log('Customer closed payment popup.');
                                }
                            });
                        } else {
                            alert(data.message || "Gagal membuat sesi pembayaran Midtrans.");
                        }
                    })
                    .catch(error => {
                        payMonthlyButton.disabled = false;
                        payMonthlyButton.innerHTML = '<i class="fa-solid fa-credit-card"></i> <span>Bayar Biaya Bulanan</span>';
                        alert("Terjadi kesalahan sistem saat menghubungi gateway Midtrans.");
                    });
                });
            }
        </script>
    @endif
@endpush
