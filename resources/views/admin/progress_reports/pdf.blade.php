<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Perkembangan — {{ $report->student?->full_name ?? 'Murid' }} — {{ $settings['site_title'] }}</title>
    <!-- FontAwesome Font & Google Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: #0f172a;
        }
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background-color: #ffffff !important;
                padding: 0 !important;
            }
            .print-card {
                box-shadow: none !important;
                border: 1px solid #cbd5e1 !important;
                margin: 0 auto !important;
                max-width: 100% !important;
            }
        }
    </style>
</head>
<body class="py-8 px-4 sm:px-6">

    @php
        $regCode = $report->student?->registration?->registration_code 
                   ?? $report->student?->registrations?->first()?->registration_code;
        $isPublic = request()->routeIs('laporan.public-pdf') || !auth('admin')->check();
    @endphp

    <!-- Top Action Bar (Hide when printing) -->
    <div class="max-w-3xl mx-auto mb-6 flex items-center justify-between no-print">
        @if(!$isPublic && auth('admin')->check() && request()->routeIs('admin.*'))
            <a href="{{ route('admin.laporan-perkembangan.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 text-sm font-semibold hover:bg-slate-50 transition-all shadow-sm">
                <i class="fa-solid fa-arrow-left text-xs"></i> Kembali ke Panel Admin
            </a>
        @else
            <a href="{{ $regCode ? route('pendaftaran.status', ['code' => $regCode]) : route('home') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 text-sm font-semibold hover:bg-slate-50 transition-all shadow-sm">
                <i class="fa-solid fa-arrow-left text-xs"></i> Kembali ke Status Murid
            </a>
        @endif
        <button onclick="window.print()" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-sky-600 hover:bg-sky-700 text-white text-sm font-bold shadow-md shadow-sky-600/20 transition-all">
            <i class="fa-solid fa-print"></i> Cetak Laporan / Simpan PDF
        </button>
    </div>

    <!-- Main Card -->
    <div class="max-w-3xl mx-auto bg-white rounded-3xl border border-slate-200 shadow-xl overflow-hidden print-card">
        
        <!-- Header Banner -->
        <div class="bg-gradient-to-r from-sky-500 via-blue-600 to-indigo-700 p-6 sm:p-8 text-white relative">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-2xl bg-white/20 backdrop-blur-md flex items-center justify-center text-white text-2xl font-black shadow-inner">
                        <i class="fa-solid fa-graduation-cap"></i>
                    </div>
                    <div>
                        <h1 class="text-2xl font-extrabold tracking-tight">{{ $settings['site_title'] }}</h1>
                        <p class="text-xs text-sky-100 font-medium">{{ $settings['site_tagline'] }}</p>
                    </div>
                </div>
                <div class="text-left sm:text-right bg-white/10 backdrop-blur-md px-4 py-2.5 rounded-2xl border border-white/20">
                    <span class="block text-[10px] uppercase font-bold tracking-widest text-sky-200">No. Laporan</span>
                    <span class="text-base font-black text-white tracking-wider">#LP-{{ str_pad($report->id, 5, '0', STR_PAD_LEFT) }}</span>
                </div>
            </div>
        </div>

        <!-- Body -->
        <div class="p-6 sm:p-8 space-y-6">

            <!-- Title & Period Badge -->
            <div class="flex flex-wrap items-center justify-between pb-6 border-b border-slate-100 gap-4">
                <div>
                    <h2 class="text-xl font-bold text-slate-900 uppercase tracking-wide">Laporan Perkembangan Belajar Murid</h2>
                    <p class="text-xs text-slate-500 mt-0.5">
                        Tanggal Laporan: 
                        <span id="report-timestamp" class="font-semibold text-slate-700">
                            {{ \Carbon\Carbon::parse($report->created_at)->setTimezone('Asia/Jakarta')->locale('id')->isoFormat('D MMMM Y, HH:mm') . ' WIB' }}
                        </span>
                    </p>
                </div>
                <div>
                    <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-sky-100 text-sky-800 text-xs font-black uppercase tracking-wider border border-sky-200">
                        <i class="fa-solid fa-calendar-check text-sky-600"></i> PERIODE: {{ $report->period }}
                    </span>
                </div>
            </div>

            <!-- Detail Information Table -->
            <div class="bg-slate-50 rounded-2xl p-5 border border-slate-100 space-y-3">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 py-1 border-b border-slate-200/60">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Lengkap Murid</span>
                    <span class="sm:col-span-2 text-sm font-bold text-slate-900">
                        {{ $report->student?->full_name ?? '-' }}
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 py-1 border-b border-slate-200/60">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Jenjang & Asal Sekolah</span>
                    <span class="sm:col-span-2 text-sm font-semibold text-slate-800">
                        {{ $report->student?->class_level_label ?? '-' }} — {{ $report->student?->school_origin ?? '-' }}
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 py-1 border-b border-slate-200/60">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Orang Tua / Wali</span>
                    <span class="sm:col-span-2 text-sm font-medium text-slate-700">
                        {{ $report->student?->parent?->full_name ?? '-' }}
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 py-1 border-b border-slate-200/60">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Sesi Bimbingan</span>
                    <span class="sm:col-span-2 text-sm font-medium text-slate-700">
                        {{ $report->student?->activeRegistration?->schedule?->session_name ?? $report->student?->registration?->schedule?->session_name ?? '-' }} ({{ $report->student?->activeRegistration?->schedule?->day ?? $report->student?->registration?->schedule?->day ?? 'Senin – Kamis' }})
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 py-1 border-b border-slate-200/60">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Tahap Pembelajaran</span>
                    <span class="sm:col-span-2 text-sm font-bold text-sky-700">
                        {{ $report->current_stage }}
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 py-1">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Rekap Kehadiran</span>
                    <span class="sm:col-span-2 text-sm font-medium text-slate-700">
                        {{ $report->attendance_summary ?? 'Hadir teratur mengikuti sesi belajar' }}
                    </span>
                </div>
            </div>

            <!-- Penilaian Kemampuan Dasar Cards -->
            <div>
                <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-500 mb-3">Penilaian Kemampuan Dasar</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    
                    <!-- Kemampuan Membaca -->
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 flex items-center justify-between">
                        <div>
                            <span class="block text-xs font-bold text-slate-500 uppercase">Kemampuan Membaca</span>
                            <span class="text-sm font-extrabold text-slate-900">{{ $report->reading_skill ?? '-' }}</span>
                        </div>
                        <div>
                            @if($report->reading_skill === 'Berkembang Sangat Baik')
                                <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold">BSB</span>
                            @elseif($report->reading_skill === 'Berkembang Sesuai Harapan')
                                <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-800 text-xs font-bold">BSH</span>
                            @elseif($report->reading_skill === 'Mulai Berkembang')
                                <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-800 text-xs font-bold">MB</span>
                            @else
                                <span class="px-3 py-1 rounded-full bg-rose-100 text-rose-800 text-xs font-bold">BB</span>
                            @endif
                        </div>
                    </div>

                    <!-- Kemampuan Menulis -->
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 flex items-center justify-between">
                        <div>
                            <span class="block text-xs font-bold text-slate-500 uppercase">Kemampuan Menulis</span>
                            <span class="text-sm font-extrabold text-slate-900">{{ $report->writing_skill ?? '-' }}</span>
                        </div>
                        <div>
                            @if($report->writing_skill === 'Berkembang Sangat Baik')
                                <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold">BSB</span>
                            @elseif($report->writing_skill === 'Berkembang Sesuai Harapan')
                                <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-800 text-xs font-bold">BSH</span>
                            @elseif($report->writing_skill === 'Mulai Berkembang')
                                <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-800 text-xs font-bold">MB</span>
                            @else
                                <span class="px-3 py-1 rounded-full bg-rose-100 text-rose-800 text-xs font-bold">BB</span>
                            @endif
                        </div>
                    </div>

                </div>
            </div>

            <!-- Narasi Perkembangan Belajar -->
            <div class="space-y-2">
                <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-500">Narasi Perkembangan Belajar</h3>
                <div class="bg-gradient-to-r from-sky-50 to-blue-50/50 rounded-2xl p-5 border border-sky-100 text-sm text-slate-700 leading-relaxed">
                    {!! nl2br(e($report->progress_narrative)) !!}
                </div>
            </div>

            <!-- Catatan & Rekomendasi Orang Tua (Jika ada) -->
            @if($report->recommendations)
            <div class="space-y-2">
                <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-500">Catatan & Rekomendasi untuk Orang Tua</h3>
                <div class="bg-amber-50/70 rounded-2xl p-5 border border-amber-200/80 text-sm text-slate-700 leading-relaxed">
                    {!! nl2br(e($report->recommendations)) !!}
                </div>
            </div>
            @endif

            <!-- Footer & Signatures -->
            <div class="pt-8 grid grid-cols-2 gap-8 items-end border-t border-slate-100">
                <div class="text-center space-y-12">
                    <div>
                        <span class="block text-xs text-slate-500">Mengetahui,</span>
                        <span class="block text-xs font-bold text-slate-700 uppercase tracking-wider mt-0.5">Orang Tua / Wali Murid</span>
                    </div>
                    <div>
                        <span class="font-bold text-slate-900 border-b border-slate-900 pb-0.5 inline-block min-w-[160px]">
                            {{ $report->student?->parent?->full_name ?? '........................................' }}
                        </span>
                        <span class="block text-[11px] text-slate-500 mt-1">Orang Tua / Wali</span>
                    </div>
                </div>

                <div class="text-center space-y-12">
                    <div>
                        <span id="signature-date" class="block text-xs text-slate-500">Semarang, {{ \Carbon\Carbon::now('Asia/Jakarta')->locale('id')->isoFormat('D MMMM Y') }}</span>
                        <span class="block text-xs font-bold text-slate-700 uppercase tracking-wider mt-0.5">Pengajar / Pengelola Bimbel</span>
                    </div>
                    <div>
                        <span class="font-bold text-slate-900 border-b border-slate-900 pb-0.5 inline-block min-w-[160px]">
                            {{ $settings['teacher_name'] }}
                        </span>
                        <span class="block text-[11px] text-slate-500 mt-1">Bright Kids Semarang</span>
                    </div>
                </div>
            </div>

        </div>

        <!-- Footer Copyright -->
        <div class="bg-slate-50 px-8 py-3 border-t border-slate-100 text-center text-[11px] text-slate-400">
            Dicetak secara resmi melalui Sistem Informasi Bimbel Bright Kids pada <span id="print-timestamp" class="font-medium text-slate-500">{{ \Carbon\Carbon::now('Asia/Jakarta')->locale('id')->isoFormat('D MMMM Y, HH:mm') }} WIB</span>.
        </div>

    </div>

    <script>
        function updateTimestamps() {
            const now = new Date();
            const dateStr = now.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
            const timeStr = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', hour12: false }).replace(/\./g, ':');
            const fullDateTime = dateStr + ', ' + timeStr + ' WIB';

            const elReport = document.getElementById('report-timestamp');
            if (elReport) {
                elReport.textContent = fullDateTime;
            }

            const elPrint = document.getElementById('print-timestamp');
            if (elPrint) {
                elPrint.textContent = fullDateTime;
            }

            const elSig = document.getElementById('signature-date');
            if (elSig) {
                elSig.textContent = 'Semarang, ' + dateStr;
            }
        }
        updateTimestamps();
        window.onbeforeprint = updateTimestamps;
    </script>

</body>
</html>
