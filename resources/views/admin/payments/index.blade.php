@extends('layouts.admin')
@section('title', 'Manajemen Pembayaran')
@section('page-title', 'Manajemen Pembayaran')
@section('page-subtitle', 'Pantau dan kelola seluruh transaksi pembayaran murid')

@section('content')

    <div class="flex flex-col sm:flex-row gap-3 mb-6">
        <form action="{{ route('admin.pembayaran.index') }}" method="GET" class="flex gap-2 flex-1">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama murid, kode bayar..." class="flex-1 px-4 py-2.5 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm">
            <select name="status" onchange="this.form.submit()" class="px-3 py-2.5 rounded-xl border border-slate-200 outline-none text-sm bg-white font-semibold text-slate-700">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="lunas" {{ request('status') === 'lunas' ? 'selected' : '' }}>Lunas</option>
                <option value="gagal" {{ request('status') === 'gagal' ? 'selected' : '' }}>Gagal</option>
            </select>
            <button type="submit" class="px-4 py-2.5 rounded-xl bg-slate-800 text-white text-sm font-bold"><i class="fa-solid fa-magnifying-glass"></i></button>
            @if(request()->hasAny(['search','status'])) <a href="{{ route('admin.pembayaran.index') }}" class="px-3 py-2.5 rounded-xl border text-sm text-slate-600"><i class="fa-solid fa-xmark"></i></a> @endif
        </form>
        <a href="{{ route('admin.pembayaran.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold shadow-md shadow-emerald-600/20 transition-all flex-shrink-0">
            <i class="fa-solid fa-plus"></i> Catat Pembayaran Baru
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead>
                    <tr class="text-xs font-bold uppercase tracking-wider text-slate-400 bg-slate-50/70 border-b border-slate-100">
                        <th class="px-5 py-3.5">Kode</th>
                        <th class="px-5 py-3.5">Murid</th>
                        <th class="px-5 py-3.5">Metode</th>
                        <th class="px-5 py-3.5">Nominal</th>
                        <th class="px-5 py-3.5">Jenis</th>
                        <th class="px-5 py-3.5">Tanggal</th>
                        <th class="px-5 py-3.5 text-center">Status</th>
                        <th class="px-5 py-3.5 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100/80">
                    @forelse($payments as $pay)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-5 py-4">
                                <span class="text-xs font-black text-emerald-700 bg-emerald-50 px-2 py-1 rounded-lg">{{ $pay->payment_code }}</span>
                            </td>
                            <td class="px-5 py-4">
                                <div class="font-bold text-slate-900">{{ $pay->registration->student->full_name ?? '-' }}</div>
                                <div class="text-xs text-slate-400">Kode Daftar: {{ $pay->registration->registration_code ?? '-' }}</div>
                            </td>
                            <td class="px-5 py-4">
                                @if(in_array(strtolower($pay->method), ['online', 'midtrans']))
                                    <span class="px-2.5 py-1 rounded-lg bg-blue-100 text-blue-700 text-xs font-bold">Online</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-lg bg-emerald-100 text-emerald-700 text-xs font-bold">Tunai</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 font-bold text-slate-900">
                                Rp {{ number_format($pay->amount, 0, ',', '.') }}
                            </td>
                            <td class="px-5 py-4 text-xs text-slate-600 font-semibold">
                                {{ $pay->notes ?? 'Pendaftaran & Bimbingan' }}
                            </td>
                            <td class="px-5 py-4 text-xs text-slate-500">
                                {{ $pay->paid_at ? $pay->paid_at->setTimezone('Asia/Jakarta')->format('d/m/Y H:i') : ($pay->created_at ? $pay->created_at->setTimezone('Asia/Jakarta')->format('d/m/Y H:i') : '-') }}
                            </td>
                            <td class="px-5 py-4 text-center">
                                @if($pay->status === 'lunas')
                                    <span class="px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold">Lunas</span>
                                @elseif($pay->status === 'pending')
                                    <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-700 text-xs font-bold">Pending</span>
                                @else
                                    <span class="px-3 py-1 rounded-full bg-rose-100 text-rose-700 text-xs font-bold">Gagal</span>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    @if($pay->status === 'pending')
                                        <!-- Mark as Lunas (Tunai) -->
                                        <form action="{{ route('admin.pembayaran.confirm', $pay->id) }}" method="POST">
                                            @csrf @method('PUT')
                                            <button type="submit" class="flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-emerald-500 hover:bg-emerald-600 text-white text-xs font-bold transition-colors">
                                                <i class="fa-solid fa-check text-xs"></i> Konfirmasi Lunas
                                            </button>
                                        </form>
                                    @endif
                                    <a href="{{ route('admin.pembayaran.receipt', $pay->id) }}" target="_blank" class="w-8 h-8 rounded-lg bg-slate-50 text-slate-600 hover:bg-slate-100 flex items-center justify-center" title="Cetak Bukti">
                                        <i class="fa-solid fa-receipt text-xs"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="px-5 py-12 text-center text-slate-400 text-sm">Belum ada data pembayaran.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-5 py-4 border-t border-slate-100">{{ $payments->withQueryString()->links() }}</div>
    </div>

@endsection
