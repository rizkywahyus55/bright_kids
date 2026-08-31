@extends('layouts.admin')
@section('title', 'Catat Pembayaran Baru')
@section('page-title', 'Catat Pembayaran')
@section('page-subtitle', 'Input data pembayaran murid secara manual')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">

    {{-- Back --}}
    <a href="{{ route('admin.pembayaran.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-sky-600 transition-colors">
        <i class="fa-solid fa-arrow-left text-xs"></i> Kembali ke Manajemen Pembayaran
    </a>

    @if($errors->any())
        <div class="bg-rose-50 border border-rose-200 text-rose-700 rounded-xl px-5 py-4 text-sm">
            <p class="font-bold mb-1">Periksa kembali isian form:</p>
            <ul class="list-disc list-inside space-y-0.5">
                @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.pembayaran.store') }}" method="POST" id="payment-form">
        @csrf

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 space-y-5">

            <h2 class="font-extrabold text-slate-900 text-lg flex items-center gap-2">
                <span class="w-8 h-8 rounded-xl bg-emerald-500 text-white flex items-center justify-center text-sm">
                    <i class="fa-solid fa-money-bill-wave"></i>
                </span>
                Data Pembayaran
            </h2>

            {{-- Pilih Murid / Pendaftaran --}}
            <div>
                <label for="registration_id" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Murid / Pendaftaran <span class="text-rose-500">*</span></label>
                <select name="registration_id" id="registration_id" required
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-sky-500 focus:ring-2 focus:ring-sky-100 outline-none text-sm text-slate-800 bg-white">
                    @foreach($registrations as $reg)
                        <option value="{{ $reg->id }}" {{ old('registration_id') == $reg->id ? 'selected' : '' }}>
                            {{ $reg->student->full_name ?? '-' }}
                            ({{ $reg->registration_code }})
                            — {{ $reg->schedule->session_name ?? '-' }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Jenis Pembayaran --}}
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Jenis Pembayaran <span class="text-rose-500">*</span></label>
                <div class="grid grid-cols-2 gap-3">
                    <label id="label-biaya-awal" class="cursor-pointer">
                        <input type="radio" name="payment_type" value="biaya_awal" class="sr-only peer" {{ old('payment_type', 'biaya_awal') == 'biaya_awal' ? 'checked' : '' }}>
                        <div class="flex flex-col items-center gap-2 py-4 px-3 rounded-xl border-2 border-slate-200 text-center transition-all peer-checked:border-sky-500 peer-checked:bg-sky-50 peer-checked:text-sky-700 hover:border-sky-300">
                            <i class="fa-solid fa-id-card text-xl text-slate-400 peer-checked:text-sky-600"></i>
                            <div class="font-bold text-sm">Biaya Awal Bimbel</div>
                            <div class="text-xs font-semibold text-sky-600">Rp 50.000</div>
                            <div class="text-[11px] text-slate-400">Pendaftaran pertama kali</div>
                        </div>
                    </label>
                    <label id="label-biaya-bulanan" class="cursor-pointer">
                        <input type="radio" name="payment_type" value="biaya_bulanan" class="sr-only peer" {{ old('payment_type') == 'biaya_bulanan' ? 'checked' : '' }}>
                        <div class="flex flex-col items-center gap-2 py-4 px-3 rounded-xl border-2 border-slate-200 text-center transition-all peer-checked:border-emerald-500 peer-checked:bg-emerald-50 peer-checked:text-emerald-700 hover:border-emerald-300">
                            <i class="fa-solid fa-calendar-day text-xl text-slate-400 peer-checked:text-emerald-600"></i>
                            <div class="font-bold text-sm">Biaya Bulanan</div>
                            <div class="text-xs font-semibold text-emerald-600">Rp 150.000</div>
                            <div class="text-[11px] text-slate-400">Pembayaran rutin tiap bulan</div>
                        </div>
                    </label>
                </div>
            </div>

            {{-- Pilih Bulan (muncul jika Biaya Bulanan dipilih) --}}
            <div id="spp-month-section" class="{{ old('payment_type') == 'biaya_bulanan' ? '' : 'hidden' }}">
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Bulan Pembayaran <span class="text-rose-500">*</span></label>
                @php
                    $monthsList = [
                        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
                        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
                        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                    ];
                    $currentYear = now()->year;
                    $currentMonthNum = now()->month;
                @endphp
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <select id="select_month_name"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 outline-none text-sm text-slate-800 bg-white">
                            @foreach($monthsList as $num => $mName)
                                <option value="{{ $mName }}" {{ $num == $currentMonthNum ? 'selected' : '' }}>
                                    {{ $mName }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <select id="select_year_num"
                            class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 outline-none text-sm text-slate-800 bg-white">
                            @for($y = $currentYear - 1; $y <= $currentYear + 2; $y++)
                                <option value="{{ $y }}" {{ $y == $currentYear ? 'selected' : '' }}>
                                    {{ $y }}
                                </option>
                            @endfor
                        </select>
                    </div>
                </div>
                <input type="hidden" name="spp_month" id="spp_month" value="{{ old('spp_month', $monthsList[$currentMonthNum] . ' ' . $currentYear) }}">
                <p class="text-xs text-slate-400 mt-1.5">Pilih bulan dan tahun bimbingan belajar yang dibayarkan.</p>
            </div>

            {{-- Nominal --}}
            <div>
                <label for="amount" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Nominal Pembayaran <span class="text-rose-500">*</span></label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 font-bold text-sm">Rp</span>
                    <input type="number" name="amount" id="amount" min="1000" step="500"
                        value="{{ old('amount', '50000') }}" required placeholder="0"
                        class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-200 focus:border-sky-500 focus:ring-2 focus:ring-sky-100 outline-none text-sm font-bold text-slate-800">
                </div>
            </div>

            {{-- Catatan Tambahan (opsional) --}}
            <div>
                <label for="notes" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Catatan Tambahan <span class="text-slate-400 font-normal">(Opsional)</span></label>
                <input type="text" name="notes" id="notes" maxlength="200"
                    value="{{ old('notes') }}" placeholder="Contoh: Titip lewat wali murid..."
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-sky-500 focus:ring-2 focus:ring-sky-100 outline-none text-sm text-slate-800">
            </div>

            {{-- Preview Jenis --}}
            <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Preview Keterangan Jenis</p>
                <p id="jenis-preview" class="text-sm font-semibold text-slate-800">Biaya Awal Bimbel</p>
            </div>

        </div>

        {{-- Submit --}}
        <div class="flex justify-end gap-3">
            <a href="{{ route('admin.pembayaran.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 text-slate-600 text-sm font-semibold hover:bg-slate-50 transition-colors">
                Batal
            </a>
            <button type="submit" class="px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold shadow-md shadow-emerald-600/20 transition-all flex items-center gap-2">
                <i class="fa-solid fa-check"></i> Catat Pembayaran Lunas
            </button>
        </div>

    </form>
</div>

<script>
    const radioInputs = document.querySelectorAll('input[name="payment_type"]');
    const sppSection = document.getElementById('spp-month-section');
    const monthSelect = document.getElementById('select_month_name');
    const yearSelect = document.getElementById('select_year_num');
    const sppMonthHidden = document.getElementById('spp_month');
    const amountInput = document.getElementById('amount');
    const notesInput = document.getElementById('notes');
    const preview = document.getElementById('jenis-preview');

    function syncSppMonth() {
        if (monthSelect && yearSelect && sppMonthHidden) {
            sppMonthHidden.value = monthSelect.value + ' ' + yearSelect.value;
        }
        updatePreview();
    }

    function updatePreview() {
        const type = document.querySelector('input[name="payment_type"]:checked')?.value;
        const month = sppMonthHidden ? sppMonthHidden.value : '';
        const notes = notesInput.value.trim();

        let text = '';
        if (type === 'biaya_awal' || type === 'pendaftaran') {
            text = 'Biaya Awal Bimbel';
        } else if (type === 'biaya_bulanan' || type === 'spp') {
            text = 'Biaya Bulanan ' + month;
        }
        if (notes) text += ' – ' + notes;
        preview.textContent = text || '—';
    }

    function toggleSppSection(isUserAction = false) {
        const type = document.querySelector('input[name="payment_type"]:checked')?.value;
        if (type === 'biaya_bulanan' || type === 'spp') {
            sppSection.classList.remove('hidden');
            if (isUserAction) {
                amountInput.value = '150000';
            }
        } else {
            sppSection.classList.add('hidden');
            if (isUserAction) {
                amountInput.value = '50000';
            }
        }
        syncSppMonth();
    }

    radioInputs.forEach(r => r.addEventListener('change', () => toggleSppSection(true)));
    if (monthSelect) monthSelect.addEventListener('change', syncSppMonth);
    if (yearSelect) yearSelect.addEventListener('change', syncSppMonth);
    notesInput.addEventListener('input', updatePreview);

    // Init
    toggleSppSection(false);
</script>
@endsection
