@extends('layouts.admin')
@section('title', 'Pendaftaran Offline')
@section('page-title', 'Pendaftaran Murid Offline')
@section('page-subtitle', 'Input data murid yang mendaftar langsung di lokasi')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
        <form action="{{ route('admin.pendaftaran.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <h3 class="font-bold text-slate-900 mb-4 pb-3 border-b border-slate-100 flex items-center gap-2">
                    <span class="w-7 h-7 rounded-lg bg-sky-500 text-white text-xs font-bold flex items-center justify-center">1</span>
                    Data Anak / Murid
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Nama Lengkap Anak *</label>
                        <input type="text" name="full_name" value="{{ old('full_name') }}" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm">
                        @error('full_name') <p class="text-xs text-rose-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Tanggal Lahir *</label>
                        <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Jenjang / Kelas *</label>
                        <select name="class_level" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm bg-white">
                            <option value="tk_kecil" {{ old('class_level') === 'tk_kecil' ? 'selected' : '' }}>TK Kecil</option>
                            <option value="tk_besar" {{ old('class_level') === 'tk_besar' ? 'selected' : '' }}>TK Besar</option>
                            <option value="sd_1" {{ old('class_level') === 'sd_1' ? 'selected' : '' }}>SD Kelas 1</option>
                            <option value="sd_2" {{ old('class_level') === 'sd_2' ? 'selected' : '' }}>SD Kelas 2</option>
                            <option value="sd_3" {{ old('class_level') === 'sd_3' ? 'selected' : '' }}>SD Kelas 3</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Asal Sekolah *</label>
                        <input type="text" name="school_origin" value="{{ old('school_origin') }}" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm">
                    </div>
                </div>
            </div>

            <div>
                <h3 class="font-bold text-slate-900 mb-4 pb-3 border-b border-slate-100 flex items-center gap-2">
                    <span class="w-7 h-7 rounded-lg bg-sky-500 text-white text-xs font-bold flex items-center justify-center">2</span>
                    Data Orang Tua / Wali
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Nama Orang Tua / Wali *</label>
                        <input type="text" name="parent_name" value="{{ old('parent_name') }}" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Nomor WhatsApp *</label>
                        <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number') }}" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Alamat Lengkap *</label>
                        <textarea name="address" rows="2" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm">{{ old('address') }}</textarea>
                    </div>
                </div>
            </div>

            <div>
                <h3 class="font-bold text-slate-900 mb-4 pb-3 border-b border-slate-100 flex items-center gap-2">
                    <span class="w-7 h-7 rounded-lg bg-sky-500 text-white text-xs font-bold flex items-center justify-center">3</span>
                    Jadwal & Status Awal
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Pilih Sesi Jadwal *</label>
                        <select name="schedule_id" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm bg-white">
                            @foreach($schedules as $s)
                                <option value="{{ $s->id }}" {{ old('schedule_id') == $s->id ? 'selected' : '' }}>
                                    {{ $s->session_name }} ({{ $s->formatted_time }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Status Pendaftaran *</label>
                        <select name="status" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm bg-white">
                            <option value="menunggu_verifikasi">Menunggu Verifikasi</option>
                            <option value="terverifikasi">Langsung Terverifikasi (Bayar Tunai Sudah Diterima)</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="flex gap-3 pt-2">
                <a href="{{ route('admin.pendaftaran.index') }}" class="flex-1 py-3 rounded-xl border border-slate-200 text-sm font-bold text-slate-700 text-center hover:bg-slate-50">Batal</a>
                <button type="submit" class="flex-1 py-3 rounded-xl bg-sky-600 hover:bg-sky-700 text-white text-sm font-bold shadow-md">Simpan Data Pendaftaran</button>
            </div>
        </form>
    </div>
</div>
@endsection
