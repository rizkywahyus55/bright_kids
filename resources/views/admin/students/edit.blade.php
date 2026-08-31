@extends('layouts.admin')
@section('title', 'Edit Data Anak – ' . $siswa->full_name)
@section('page-title', 'Edit Data Anak')
@section('page-subtitle', 'Perbarui data murid dan orang tua/wali')

@section('content')
<div class="max-w-2xl mx-auto">
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
    <form action="{{ route('admin.siswa.update', $siswa) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Data Murid --}}
        <div>
            <h3 class="font-bold text-slate-900 mb-4 pb-3 border-b border-slate-100 flex items-center gap-2">
                <span class="w-7 h-7 rounded-lg bg-sky-500 text-white text-xs font-bold flex items-center justify-center">1</span>
                Data Murid
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Nama Lengkap Murid *</label>
                    <input type="text" name="full_name" value="{{ old('full_name', $siswa->full_name) }}" required
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm">
                    @error('full_name')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Tanggal Lahir *</label>
                    <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $siswa->date_of_birth?->format('Y-m-d')) }}" required
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm">
                    @error('date_of_birth')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Jenjang *</label>
                    <select name="class_level" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm bg-white">
                        @foreach(['tk_kecil' => 'TK Kecil', 'tk_besar' => 'TK Besar', 'sd_1' => 'SD Kelas 1', 'sd_2' => 'SD Kelas 2', 'sd_3' => 'SD Kelas 3'] as $val => $label)
                            <option value="{{ $val }}" {{ old('class_level', $siswa->class_level) === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Asal Sekolah</label>
                    <input type="text" name="school_origin" value="{{ old('school_origin', $siswa->school_origin) }}"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm">
                </div>
            </div>
        </div>

        {{-- Data Orang Tua --}}
        @php $parent = $siswa->registration?->parent; @endphp
        <div>
            <h3 class="font-bold text-slate-900 mb-4 pb-3 border-b border-slate-100 flex items-center gap-2">
                <span class="w-7 h-7 rounded-lg bg-indigo-500 text-white text-xs font-bold flex items-center justify-center">2</span>
                Data Orang Tua / Wali
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Nama Orang Tua / Wali *</label>
                    <input type="text" name="parent_name" value="{{ old('parent_name', $parent?->full_name) }}" required
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm">
                    @error('parent_name')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">No. WhatsApp *</label>
                    <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number', $parent?->whatsapp_number) }}" required
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm" placeholder="628xxx">
                    @error('whatsapp_number')<p class="text-rose-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Alamat Rumah</label>
                    <textarea name="parent_address" rows="3"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm">{{ old('parent_address', $parent?->address) }}</textarea>
                </div>
            </div>
        </div>

        <div class="flex gap-3 pt-2">
            <a href="{{ route('admin.siswa.show', $siswa) }}" class="flex-1 py-3 rounded-xl border border-slate-200 text-sm font-bold text-slate-700 text-center hover:bg-slate-50 transition-colors">Batal</a>
            <button type="submit" class="flex-1 py-3 rounded-xl bg-sky-600 hover:bg-sky-700 text-white text-sm font-bold shadow-md transition-colors">
                <i class="fa-solid fa-floppy-disk mr-1.5"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>
</div>
@endsection
