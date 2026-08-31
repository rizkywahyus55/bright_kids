@extends('layouts.admin')
@section('title', 'Pengaturan Website')
@section('page-title', 'Pengaturan Website')
@section('page-subtitle', 'Konfigurasi konten yang tampil di halaman publik')

@section('content')
<div class="max-w-3xl mx-auto">
<div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8">
    <form action="{{ route('admin.pengaturan.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <h3 class="font-bold text-slate-900 mb-4 pb-3 border-b border-slate-100 flex items-center gap-2">
                <span class="w-7 h-7 rounded-lg bg-sky-500 text-white text-xs font-bold flex items-center justify-center">1</span>
                Informasi Bimbel
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Nama Bimbel</label>
                    <input type="text" name="school_name" value="{{ $settings['school_name'] ?? 'Bright Kids' }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Tagline / Slogan</label>
                    <input type="text" name="tagline" value="{{ $settings['tagline'] ?? '' }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Alamat Lengkap</label>
                    <input type="text" name="address" value="{{ $settings['address'] ?? '' }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">
                        Embed Code / URL Google Maps
                    </label>
                    <div class="relative">
                        <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">
                            <i class="fa-solid fa-location-dot text-sm"></i>
                        </span>
                        <input type="text" name="maps_iframe" id="maps_iframe"
                            value="{{ $settings['maps_iframe'] ?? ($settings['maps_embed_url'] ?? '') }}"
                            placeholder="https://www.google.com/maps/embed?... atau <iframe...>"
                            class="w-full pl-9 pr-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm">
                    </div>

                    {{-- Preview Peta --}}
                    @if(!empty($settings['maps_iframe']))
                    <div class="mt-3 rounded-xl overflow-hidden border border-slate-200 shadow-sm h-48 map-preview-box">
                        <style>
                            .map-preview-box iframe {
                                width: 100% !important;
                                height: 100% !important;
                                border: 0 !important;
                            }
                        </style>
                        @php
                            $previewContent = trim($settings['maps_iframe']);
                            if (filter_var($previewContent, FILTER_VALIDATE_URL) || (str_starts_with($previewContent, 'http') && !str_contains($previewContent, '<iframe'))) {
                                $previewContent = '<iframe src="' . e($previewContent) . '" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>';
                            }
                        @endphp
                        {!! $previewContent !!}
                    </div>
                    @else
                    <div id="map-preview-placeholder" class="mt-3 rounded-xl border border-dashed border-slate-200 bg-slate-50 h-36 flex flex-col items-center justify-center text-slate-400 text-sm gap-1">
                        <i class="fa-solid fa-map text-2xl mb-1"></i>
                        Preview peta akan muncul setelah disimpan
                    </div>
                    @endif
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Nomor WhatsApp (Utama)</label>
                    <input type="text" name="whatsapp" value="{{ $settings['whatsapp'] ?? '' }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm" placeholder="628123456789">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Email Kontak</label>
                    <input type="email" name="email" value="{{ $settings['email'] ?? '' }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm">
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Template Pesan Chat WA</label>
                    <textarea name="wa_template" rows="2" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm" placeholder="Halo, saya ingin konsultasi perihal bimbel Bright Kids.">{{ $settings['wa_template'] ?? 'Halo, saya ingin konsultasi perihal bimbel Bright Kids.' }}</textarea>
                    <p class="text-[11px] text-slate-400 mt-1">Pesan ini akan muncul otomatis saat orang tua menekan tombol <strong>Chat WA</strong> di halaman publik.</p>
                </div>
            </div>
        </div>

        <div>
            <h3 class="font-bold text-slate-900 mb-4 pb-3 border-b border-slate-100 flex items-center gap-2">
                <span class="w-7 h-7 rounded-lg bg-sky-500 text-white text-xs font-bold flex items-center justify-center">2</span>
                Tarif Bimbingan Belajar
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 max-w-2xl">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Biaya Awal Bimbel (Rp)</label>
                    <input type="number" name="registration_fee" value="{{ $settings['registration_fee'] ?? 50000 }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm font-semibold text-slate-800">
                    <p class="text-[11px] text-slate-400 mt-1">Biaya yang dibayarkan saat pertama kali mendaftar.</p>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Biaya Bulanan (Rp)</label>
                    <input type="number" name="monthly_fee" value="{{ $settings['monthly_fee'] ?? 150000 }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm font-semibold text-slate-800">
                    <p class="text-[11px] text-slate-400 mt-1">Biaya bimbingan belajar rutin setiap bulan.</p>
                </div>
            </div>
        </div>

        <div>
            <h3 class="font-bold text-slate-900 mb-4 pb-3 border-b border-slate-100 flex items-center gap-2">
                <span class="w-7 h-7 rounded-lg bg-sky-500 text-white text-xs font-bold flex items-center justify-center">3</span>
                Konten Landing Page
            </h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Kalimat Hero (Heading Utama)</label>
                    <input type="text" name="hero_heading" value="{{ $settings['hero_heading'] ?? 'Membangun Fondasi Baca-Tulis Anak yang Kuat' }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Sub Kalimat Hero</label>
                    <textarea name="hero_subheading" rows="2" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm">{{ $settings['hero_subheading'] ?? '' }}</textarea>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Deskripsi Tentang Kami</label>
                    <textarea name="about_text" rows="3" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm">{{ $settings['about_text'] ?? '' }}</textarea>
                </div>
            </div>
        </div>

        <div>
            <h3 class="font-bold text-slate-900 mb-4 pb-3 border-b border-slate-100 flex items-center gap-2">
                <span class="w-7 h-7 rounded-lg bg-sky-500 text-white text-xs font-bold flex items-center justify-center">4</span>
                Profil Pengajar / Guru
            </h3>
            <div class="space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Nama Lengkap Pengajar</label>
                        <input type="text" name="teacher_name" value="{{ $settings['teacher_name'] ?? 'Barijanti, S.Pd.' }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Gelar / Jabatan Pengajar</label>
                        <input type="text" name="teacher_role" value="{{ $settings['teacher_role'] ?? 'Guru TK PGRI 105 Semarang' }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Judul Utama Profil</label>
                    <input type="text" name="teacher_title" value="{{ $settings['teacher_title'] ?? 'Pendampingan Penuh Kasih & Kesabaran' }}" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Biografi / Deskripsi Pengajar</label>
                    <textarea name="teacher_bio" rows="3" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 outline-none text-sm">{{ $settings['teacher_bio'] ?? '' }}</textarea>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Statistik 1 (Nilai & Label)</label>
                        <div class="grid grid-cols-2 gap-2">
                            <input type="text" name="teacher_stat1_val" value="{{ $settings['teacher_stat1_val'] ?? '10+ thn' }}" placeholder="10+ thn" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm">
                            <input type="text" name="teacher_stat1_lbl" value="{{ $settings['teacher_stat1_lbl'] ?? 'Pengalaman Mengajar' }}" placeholder="Pengalaman" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-1.5">Statistik 2 (Nilai & Label)</label>
                        <div class="grid grid-cols-2 gap-2">
                            <input type="text" name="teacher_stat2_val" value="{{ $settings['teacher_stat2_val'] ?? '100%' }}" placeholder="100%" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm">
                            <input type="text" name="teacher_stat2_lbl" value="{{ $settings['teacher_stat2_lbl'] ?? 'Pendekatan Ramah Anak' }}" placeholder="Pendekatan" class="w-full px-3 py-2.5 rounded-xl border border-slate-200 text-sm">
                        </div>
                    </div>
                </div>
                <!-- Foto Pengajar -->
                <div class="pt-2 border-t border-slate-100">
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Foto Profil Pengajar</label>
                    <div class="flex flex-col sm:flex-row items-center gap-5 p-4 rounded-2xl bg-slate-50 border border-slate-200">
                        <div class="relative w-28 h-28 flex-shrink-0">
                            <div class="w-full h-full rounded-full bg-gradient-to-tr from-sky-400 to-indigo-600 p-1 shadow-md overflow-hidden flex items-center justify-center">
                                <div class="w-full h-full rounded-full bg-white flex items-center justify-center overflow-hidden">
                                    @php
                                        $hasPhoto = !empty($settings['teacher_photo']) && \Illuminate\Support\Facades\Storage::disk('public')->exists($settings['teacher_photo']);
                                    @endphp
                                    <img id="teacher-photo-preview"
                                         src="{{ $hasPhoto ? asset('storage/' . $settings['teacher_photo']) : '' }}"
                                         alt="Preview Foto"
                                         class="w-full h-full object-cover {{ $hasPhoto ? '' : 'hidden' }}">
                                    <div id="teacher-photo-placeholder" class="text-slate-400 flex flex-col items-center justify-center {{ $hasPhoto ? 'hidden' : '' }}">
                                        <i class="fa-solid fa-user-graduate text-4xl text-sky-500"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex-grow space-y-2 text-center sm:text-left">
                            <input type="file" name="teacher_photo" id="teacher_photo_input" accept="image/jpeg,image/png,image/jpg,image/webp" class="hidden" onchange="previewTeacherPhoto(this)">
                            <div class="flex flex-wrap items-center justify-center sm:justify-start gap-2">
                                <label for="teacher_photo_input" class="cursor-pointer px-4 py-2 rounded-xl bg-sky-600 hover:bg-sky-700 text-white text-xs font-bold transition-colors inline-flex items-center gap-1.5 shadow-sm">
                                    <i class="fa-solid fa-cloud-arrow-up"></i>
                                    <span>Unggah Foto Baru</span>
                                </label>
                                @if($hasPhoto)
                                    <label class="cursor-pointer px-3 py-2 rounded-xl bg-rose-50 text-rose-600 hover:bg-rose-100 text-xs font-bold transition-colors inline-flex items-center gap-1.5 border border-rose-200">
                                        <input type="checkbox" name="remove_teacher_photo" value="1" class="rounded border-rose-300 text-rose-600 focus:ring-rose-200" onchange="toggleRemovePhoto(this)">
                                        <span>Hapus Foto</span>
                                    </label>
                                @endif
                            </div>
                            <p class="text-[11px] text-slate-400 leading-relaxed">
                                Format didukung: JPG, JPEG, PNG, WEBP. Maksimal ukuran file <strong>2 MB</strong>. Foto akan otomatis dipotong bulat rapi.
                            </p>
                            @error('teacher_photo')
                                <p class="text-rose-500 text-xs font-semibold mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="px-8 py-3 rounded-xl bg-sky-600 hover:bg-sky-700 text-white text-sm font-bold shadow-md">
                <i class="fa-solid fa-floppy-disk mr-1.5"></i> Simpan Pengaturan
            </button>
        </div>
    </form>
</div>
</div>
@endsection

@push('scripts')
<script>
    function previewTeacherPhoto(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('teacher-photo-preview');
                const placeholder = document.getElementById('teacher-photo-placeholder');
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function toggleRemovePhoto(checkbox) {
        const preview = document.getElementById('teacher-photo-preview');
        const placeholder = document.getElementById('teacher-photo-placeholder');
        if (checkbox.checked) {
            preview.classList.add('hidden');
            placeholder.classList.remove('hidden');
        } else {
            preview.classList.remove('hidden');
            placeholder.classList.add('hidden');
        }
    }
</script>
@endpush

