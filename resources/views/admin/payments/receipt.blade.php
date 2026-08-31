<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kwitansi Pembayaran #{{ $payment->payment_code }} — {{ $settings['site_title'] }}</title>
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

    <!-- Top Action Bar (Hide when printing) -->
    <div class="max-w-3xl mx-auto mb-6 flex items-center justify-between no-print">
        <a href="{{ route('admin.pembayaran.index') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-white border border-slate-200 text-slate-700 text-sm font-semibold hover:bg-slate-50 transition-all shadow-sm">
            <i class="fa-solid fa-arrow-left text-xs"></i> Kembali ke Daftar Pembayaran
        </a>
        <button onclick="window.print()" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-sky-600 hover:bg-sky-700 text-white text-sm font-bold shadow-md shadow-sky-600/20 transition-all">
            <i class="fa-solid fa-print"></i> Cetak Kwitansi / Simpan PDF
        </button>
    </div>

    <!-- Kwitansi Main Card -->
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
                    <span class="block text-[10px] uppercase font-bold tracking-widest text-sky-200">No. Kwitansi</span>
                    <span class="text-base font-black text-white tracking-wider">#{{ $payment->payment_code }}</span>
                </div>
            </div>
        </div>

        <!-- Kwitansi Body -->
        <div class="p-6 sm:p-8 space-y-6">

            <!-- Title & Status -->
            <div class="flex flex-wrap items-center justify-between pb-6 border-b border-slate-100 gap-4">
                <div>
                    <h2 class="text-xl font-bold text-slate-900 uppercase tracking-wide">Kwitansi Bukti Pembayaran</h2>
                    <p class="text-xs text-slate-500 mt-0.5">
                        Tanggal Cetak: 
                        <span id="payment-timestamp" class="font-semibold text-slate-700">
                            {{ $payment->paid_at ? \Carbon\Carbon::parse($payment->paid_at)->setTimezone('Asia/Jakarta')->locale('id')->isoFormat('D MMMM Y, HH:mm') . ' WIB' : \Carbon\Carbon::parse($payment->created_at)->setTimezone('Asia/Jakarta')->locale('id')->isoFormat('D MMMM Y, HH:mm') . ' WIB' }}
                        </span>
                    </p>
                </div>
                <div>
                    @if($payment->status === 'lunas')
                        <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-emerald-100 text-emerald-800 text-xs font-black uppercase tracking-wider border border-emerald-200">
                            <i class="fa-solid fa-circle-check text-emerald-600"></i> LUNAS
                        </span>
                    @elseif($payment->status === 'pending')
                        <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-amber-100 text-amber-800 text-xs font-black uppercase tracking-wider border border-amber-200">
                            <i class="fa-solid fa-clock text-amber-600"></i> MENUNGGU PEMBAYARAN
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full bg-rose-100 text-rose-800 text-xs font-black uppercase tracking-wider border border-rose-200">
                            <i class="fa-solid fa-circle-xmark text-rose-600"></i> GAGAL
                        </span>
                    @endif
                </div>
            </div>

            <!-- Detail Information Table -->
            <div class="bg-slate-50 rounded-2xl p-5 border border-slate-100 space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 py-1 border-b border-slate-200/60">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Sudah Diterima Dari</span>
                    <span class="sm:col-span-2 text-sm font-bold text-slate-900">
                        {{ $payment->registration?->parent?->full_name ?? $payment->registration?->student?->full_name ?? '-' }}
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 py-1 border-b border-slate-200/60">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Murid</span>
                    <span class="sm:col-span-2 text-sm font-semibold text-slate-800">
                        {{ $payment->registration?->student?->full_name ?? '-' }}
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 py-1 border-b border-slate-200/60">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Jenjang & Sesi Belajar</span>
                    <span class="sm:col-span-2 text-sm font-medium text-slate-700">
                        {{ $payment->registration?->student?->class_level_label ?? '-' }} — {{ $payment->registration?->schedule?->session_name ?? '-' }}
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 py-1 border-b border-slate-200/60">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Metode Pembayaran</span>
                    <span class="sm:col-span-2 text-sm font-semibold text-slate-800 flex items-center gap-2">
                        @if(in_array(strtolower($payment->method), ['online', 'midtrans']))
                            <span class="px-2.5 py-0.5 rounded-md bg-blue-100 text-blue-700 text-xs font-bold">Online</span>
                        @else
                            <span class="px-2.5 py-0.5 rounded-md bg-emerald-100 text-emerald-700 text-xs font-bold">Tunai</span>
                        @endif
                    </span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-2 py-1">
                    <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Untuk Pembayaran</span>
                    <span class="sm:col-span-2 text-sm font-medium text-slate-700">
                        {{ $payment->notes ?? 'Pendaftaran & Biaya Bimbingan Belajar Membaca-Menulis Bright Kids' }}
                    </span>
                </div>
            </div>

            <!-- Amount Highlight Box -->
            <div class="bg-gradient-to-r from-sky-50 to-blue-50 rounded-2xl p-6 border border-sky-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div>
                    <span class="block text-xs font-extrabold text-sky-800 uppercase tracking-wider">Jumlah Pembayaran</span>
                    <span class="text-xs text-slate-500">Terbilang sah & tercatat resmi di sistem Bright Kids</span>
                </div>
                <div class="text-2xl sm:text-3xl font-black text-sky-600 bg-white px-6 py-2.5 rounded-2xl shadow-sm border border-sky-100">
                    Rp {{ number_format((float)$payment->amount, 0, ',', '.') }}
                </div>
            </div>

            <!-- Footer & Signatures -->
            <div class="pt-8 grid grid-cols-2 gap-8 items-end border-t border-slate-100">
                <div class="text-left text-xs text-slate-500 space-y-1">
                    <p class="font-bold text-slate-700">Lokasi Bimbingan Belajar:</p>
                    <p>{{ $settings['address'] }}</p>
                    <p>WhatsApp: {{ $settings['whatsapp_number'] }}</p>
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

            const elPay = document.getElementById('payment-timestamp');
            if (elPay) {
                elPay.textContent = fullDateTime;
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
