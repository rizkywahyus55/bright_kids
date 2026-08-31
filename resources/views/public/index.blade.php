@extends('layouts.app')

@section('title', 'Bright Kids - Bimbingan Belajar Membaca & Menulis Anak Usia Dini')

@section('content')

    <!-- SECTION 1: HERO / BERANDA -->
    <section id="beranda" class="relative pt-12 pb-20 md:pt-20 md:pb-28 overflow-hidden bg-gradient-to-b from-sky-50/70 via-white to-slate-50">
        <!-- Subtle Glow Orbs -->
        <div class="absolute top-1/4 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-sky-200/40 rounded-full blur-3xl -z-10 pointer-events-none"></div>
        <div class="absolute top-10 right-10 w-72 h-72 bg-amber-100/50 rounded-full blur-3xl -z-10 pointer-events-none"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                
                <!-- Hero Text -->
                <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold text-slate-900 tracking-tight leading-[1.15]">
                        {{ $settings['hero_heading'] ?? 'Belajar Membaca & Menulis Tanpa Mengeja' }}
                    </h1>

                    <p class="text-lg text-slate-600 leading-relaxed max-w-2xl mx-auto lg:mx-0">
                        {{ $settings['hero_subheading'] ?? 'Metode belajar menyenangkan, ramah anak, dan terbukti efektif untuk anak usia dini TK hingga SD Kelas 3.' }}
                    </p>

                    <!-- Features Pills -->
                    <div class="flex flex-wrap items-center justify-center lg:justify-start gap-4 text-sm font-semibold text-slate-700">
                        <div class="flex items-center gap-2 bg-white px-3.5 py-2 rounded-xl shadow-sm border border-slate-100">
                            <i class="fa-solid fa-circle-check text-emerald-500 text-base"></i> Tanpa Metode Mengeja
                        </div>
                        <div class="flex items-center gap-2 bg-white px-3.5 py-2 rounded-xl shadow-sm border border-slate-100">
                            <i class="fa-solid fa-circle-check text-emerald-500 text-base"></i> Pengajar Berpengalaman
                        </div>
                        <div class="flex items-center gap-2 bg-white px-3.5 py-2 rounded-xl shadow-sm border border-slate-100">
                            <i class="fa-solid fa-circle-check text-emerald-500 text-base"></i> Laporan Cetak PDF
                        </div>
                    </div>

                    <!-- Hero CTA Buttons -->
                    <div class="pt-4 flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                        <a href="#pendaftaran" class="w-full sm:w-auto px-8 py-4 rounded-2xl text-base font-bold text-white bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 shadow-xl shadow-sky-500/25 hover:shadow-2xl hover:shadow-sky-500/35 transition-all text-center">
                            <i class="fa-solid fa-paper-plane mr-2"></i> Daftar Murid Baru
                        </a>
                        <a href="{{ route('pendaftaran.status') }}" class="w-full sm:w-auto px-7 py-4 rounded-2xl text-base font-semibold text-slate-700 bg-white hover:bg-slate-50 border border-slate-200 shadow-sm transition-all text-center">
                            <i class="fa-solid fa-magnifying-glass text-sky-600 mr-2"></i> Cek Status Pendaftaran
                        </a>
                    </div>
                </div>

                <!-- Hero Graphic Illustration -->
                <div class="lg:col-span-5 relative">
                    <div class="relative mx-auto max-w-md lg:max-w-none">
                        <div class="aspect-square rounded-3xl bg-gradient-to-tr from-sky-400 via-blue-500 to-indigo-600 p-3 shadow-2xl shadow-sky-500/30 transform hover:-rotate-1 transition-transform">
                            <div class="w-full h-full rounded-2xl bg-white p-8 flex flex-col justify-between relative overflow-hidden">
                                
                                <div class="space-y-4">
                                    <div class="w-14 h-14 rounded-2xl bg-sky-100 text-sky-600 flex items-center justify-center text-3xl font-extrabold">
                                        <i class="fa-solid fa-book-open-reader"></i>
                                    </div>
                                    <h3 class="text-2xl font-black text-slate-900 leading-tight">Metode Bright Kids</h3>
                                    <p class="text-sm text-slate-600">Progresif dari pengenalan suku kata vokal (ba, ca, da) langsung membaca kata & kalimat lengkap tanpa beban mengeja.</p>
                                </div>

                                <div class="space-y-2.5">
                                    <!-- Biaya Awal Bimbel -->
                                    <div class="p-3.5 rounded-2xl bg-amber-50/80 border border-amber-200/80 flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-xl bg-amber-500 text-white flex items-center justify-center font-bold text-sm">
                                                <i class="fa-solid fa-tag"></i>
                                            </div>
                                            <div>
                                                <span class="block text-[11px] font-bold text-amber-800 uppercase tracking-wider">Biaya Awal Bimbel</span>
                                                <span class="text-base font-black text-amber-900">Rp {{ number_format((float)($settings['registration_fee'] ?? 50000), 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                        <span class="px-2.5 py-1 rounded-full bg-amber-200/80 text-amber-900 text-xs font-bold">Buka</span>
                                    </div>

                                    <!-- Status Kuota -->
                                    <div class="p-3.5 rounded-2xl bg-sky-50 border border-sky-100 flex items-center justify-between">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-xl bg-emerald-500 text-white flex items-center justify-center font-bold text-sm">
                                                <i class="fa-solid fa-graduation-cap"></i>
                                            </div>
                                            <div>
                                                <span class="block text-[11px] font-bold text-slate-400 uppercase tracking-wider">Status Kuota</span>
                                                <span class="text-xs sm:text-sm font-bold text-slate-800">Maks 4 Murid / Sesi (Total 12 Murid)</span>
                                            </div>
                                        </div>
                                        <span class="px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold">Buka</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- SECTION 2: TENTANG BRIGHT KIDS -->
    <section id="tentang" class="py-16 md:py-24 bg-white border-y border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
                <span class="px-3.5 py-1 rounded-full bg-sky-100 text-sky-700 text-xs font-bold uppercase tracking-wider">Keunggulan Bright Kids</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900">Solusi Pembelajaran Membaca & Menulis Anak Usia Dini</h2>
                <p class="text-slate-600 leading-relaxed">{{ $settings['about_text'] ?? 'Bright Kids adalah bimbingan belajar khusus membaca dan menulis tanpa mengeja untuk anak usia dini.' }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="p-8 rounded-3xl bg-slate-50 border border-slate-100 hover:shadow-xl transition-all group">
                    <div class="w-14 h-14 rounded-2xl bg-sky-500 text-white flex items-center justify-center text-2xl font-bold mb-6 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-brain"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Metode Tanpa Dieja</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        Anak langsung diajak mengenali bentuk suku kata dan pola kata secara utuh, sehingga kemampuan membaca berkembang 3x lebih cepat tanpa ketergantungan ejaan per huruf.
                    </p>
                </div>

                <div class="p-8 rounded-3xl bg-slate-50 border border-slate-100 hover:shadow-xl transition-all group">
                    <div class="w-14 h-14 rounded-2xl bg-amber-500 text-white flex items-center justify-center text-2xl font-bold mb-6 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-face-smile-beam"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Suasana Fun Learning</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        Pendekatan ramah anak dengan jumlah murid dibatasi maksimal 4 anak per sesi (total 12 murid di semua sesi), memastikan tiap anak mendapatkan perhatian intensif dan bimbingan penuh dari guru.
                    </p>
                </div>

                <div class="p-8 rounded-3xl bg-slate-50 border border-slate-100 hover:shadow-xl transition-all group">
                    <div class="w-14 h-14 rounded-2xl bg-indigo-600 text-white flex items-center justify-center text-2xl font-bold mb-6 group-hover:scale-110 transition-transform">
                        <i class="fa-solid fa-file-pdf"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 mb-3">Laporan Perkembangan Digital</h3>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        Setiap perkembangan membaca dan kehadiran murid dicatat secara digital dan dapat diunduh orang tua dalam bentuk Laporan PDF resmi berkala.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 3: PROGRAM BELAJAR (KURIKULUM TAHAPAN) -->
    <section id="program" class="py-16 md:py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
                <span class="px-3.5 py-1 rounded-full bg-sky-100 text-sky-700 text-xs font-bold uppercase tracking-wider">Kurikulum Progresif</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900">Program Belajar Sesuai Jenjang Usia</h2>
                <p class="text-slate-600">Materi disusun secara bertahap (step-by-step) untuk jenjang TK Kecil, TK Besar, hingga SD Kelas 1–3.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                
                <!-- Jenjang TK -->
                <div class="bg-white rounded-3xl p-8 border border-slate-200/80 shadow-md">
                    <div class="flex items-center gap-4 mb-6 pb-4 border-b border-slate-100">
                        <div class="w-12 h-12 rounded-2xl bg-sky-100 text-sky-600 flex items-center justify-center text-xl font-bold">
                            <i class="fa-solid fa-shapes"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-slate-900">Jenjang TK Kecil & TK Besar</h3>
                            <p class="text-xs font-semibold text-slate-400">Fokus: Pondasi Membaca Lancar & Menulis Rapi</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-start gap-4 p-3.5 rounded-2xl bg-sky-50/50">
                            <span class="w-8 h-8 rounded-xl bg-sky-500 text-white font-bold text-sm flex items-center justify-center flex-shrink-0">1</span>
                            <div>
                                <h4 class="font-bold text-slate-900 text-sm">Tahap 1: Suku Kata Berakhiran Vokal</h4>
                                <p class="text-xs text-slate-600">Pengenalan bunyi suku kata awal (ba, ca, da, fa, ga, dan seterusnya).</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 p-3.5 rounded-2xl bg-sky-50/50">
                            <span class="w-8 h-8 rounded-xl bg-sky-500 text-white font-bold text-sm flex items-center justify-center flex-shrink-0">2</span>
                            <div>
                                <h4 class="font-bold text-slate-900 text-sm">Tahap 2: Membaca Tanpa Dieja</h4>
                                <p class="text-xs text-slate-600">Penggabungan antar suku kata secara langsung tanpa mengeja huruf satu per satu.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 p-3.5 rounded-2xl bg-sky-50/50">
                            <span class="w-8 h-8 rounded-xl bg-sky-500 text-white font-bold text-sm flex items-center justify-center flex-shrink-0">3</span>
                            <div>
                                <h4 class="font-bold text-slate-900 text-sm">Tahap 3: Membaca Kata Utuh</h4>
                                <p class="text-xs text-slate-600">Membaca kata variatif berstruktur 2-3 suku kata (contoh: bola, sapu, kemeja).</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 p-3.5 rounded-2xl bg-sky-50/50">
                            <span class="w-8 h-8 rounded-xl bg-sky-500 text-white font-bold text-sm flex items-center justify-center flex-shrink-0">4</span>
                            <div>
                                <h4 class="font-bold text-slate-900 text-sm">Tahap 4: Membaca Kalimat Sederhana</h4>
                                <p class="text-xs text-slate-600">Membaca rangkaian kata dalam kalimat pendek (contoh: "ibu beli soto di pasar").</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 p-3.5 rounded-2xl bg-sky-50/50">
                            <span class="w-8 h-8 rounded-xl bg-sky-500 text-white font-bold text-sm flex items-center justify-center flex-shrink-0">5</span>
                            <div>
                                <h4 class="font-bold text-slate-900 text-sm">Tahap 5: Menulis Rapi & Tepat</h4>
                                <p class="text-xs text-slate-600">Latihan motorik menulis garis, huruf cetak, dan mendikte kata dengan rapi.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Jenjang SD -->
                <div class="bg-white rounded-3xl p-8 border border-slate-200/80 shadow-md">
                    <div class="flex items-center gap-4 mb-6 pb-4 border-b border-slate-100">
                        <div class="w-12 h-12 rounded-2xl bg-indigo-100 text-indigo-600 flex items-center justify-center text-xl font-bold">
                            <i class="fa-solid fa-school"></i>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-slate-900">Jenjang SD Kelas 1–3</h3>
                            <p class="text-xs font-semibold text-slate-400">Fokus: Kelancaran Pemahaman & Pendampingan Tugas</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-start gap-4 p-3.5 rounded-2xl bg-indigo-50/50">
                            <span class="w-8 h-8 rounded-xl bg-indigo-600 text-white font-bold text-sm flex items-center justify-center flex-shrink-0">1</span>
                            <div>
                                <h4 class="font-bold text-slate-900 text-sm">Tahap 1: Membaca Lancar</h4>
                                <p class="text-xs text-slate-600">Meningkatkan intonasi dan kecepatan membaca cerita pendek atau teks bacaan sekolah.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 p-3.5 rounded-2xl bg-indigo-50/50">
                            <span class="w-8 h-8 rounded-xl bg-indigo-600 text-white font-bold text-sm flex items-center justify-center flex-shrink-0">2</span>
                            <div>
                                <h4 class="font-bold text-slate-900 text-sm">Tahap 2: Memahami Makna Kalimat</h4>
                                <p class="text-xs text-slate-600">Melatih pemahaman isi bacaan, ide pokok, dan kosa kata baru.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 p-3.5 rounded-2xl bg-indigo-50/50">
                            <span class="w-8 h-8 rounded-xl bg-indigo-600 text-white font-bold text-sm flex items-center justify-center flex-shrink-0">3</span>
                            <div>
                                <h4 class="font-bold text-slate-900 text-sm">Tahap 3: Menjawab Pertanyaan Bacaan</h4>
                                <p class="text-xs text-slate-600">Latihan menjawab soal esai pendek berdasarkan teks cerita yang dibaca.</p>
                            </div>
                        </div>

                        <div class="flex items-start gap-4 p-3.5 rounded-2xl bg-indigo-50/50">
                            <span class="w-8 h-8 rounded-xl bg-indigo-600 text-white font-bold text-sm flex items-center justify-center flex-shrink-0">4</span>
                            <div>
                                <h4 class="font-bold text-slate-900 text-sm">Tahap 4: Pendampingan Tugas Sekolah</h4>
                                <p class="text-xs text-slate-600">Bimbingan menyelesaikan PR/tugas membaca dan menulis dari sekolah asal murid.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- SECTION 4: JADWAL BELAJAR (DINAMIS DARI DATABASE) -->
    <section id="jadwal" class="py-16 md:py-24 bg-white border-y border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
                <span class="px-3.5 py-1 rounded-full bg-sky-100 text-sky-700 text-xs font-bold uppercase tracking-wider">Jadwal Sesi Fleksibel</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900">Jadwal Bimbingan Belajar Aktif</h2>
                <p class="text-slate-600">Bimbingan dilaksanakan setiap hari <strong>Senin sampai Kamis</strong>. Pilihan sesi dapat dipilih saat pengisian formulir pendaftaran.</p>
            </div>

            <div class="max-w-4xl mx-auto bg-slate-50 rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-sm">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-200 text-xs font-bold uppercase tracking-wider text-slate-400">
                                <th class="py-3.5 px-4">Nama Sesi</th>
                                <th class="py-3.5 px-4">Hari Bimbingan</th>
                                <th class="py-3.5 px-4">Jam Sesi</th>
                                <th class="py-3.5 px-4 text-center">Kapasitas</th>
                                <th class="py-3.5 px-4 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-200/60 font-medium text-sm text-slate-700">
                            @forelse($schedules as $s)
                                <tr class="hover:bg-white transition-colors">
                                    <td class="py-4 px-4 font-bold text-slate-900">
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-lg bg-sky-100 text-sky-600 flex items-center justify-center font-bold text-xs">
                                                <i class="fa-solid fa-clock"></i>
                                            </div>
                                            {{ $s->session_name }}
                                        </div>
                                    </td>
                                    <td class="py-4 px-4 text-slate-600">{{ $s->day }}</td>
                                    <td class="py-4 px-4 font-bold text-sky-700">
                                        {{ $s->formatted_time }}
                                    </td>
                                    <td class="py-4 px-4 text-center text-slate-600 font-medium">
                                        Maks {{ $s->quota ?? 4 }} Murid / Sesi
                                    </td>
                                    <td class="py-4 px-4 text-center">
                                         @if($s->is_active)
                                             <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold">
                                                 <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> Aktif
                                             </span>
                                         @else
                                             <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-slate-200 text-slate-600 text-xs font-bold">
                                                 <span class="w-2 h-2 rounded-full bg-slate-400"></span> Nonaktif
                                             </span>
                                         @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-8 text-center text-slate-400">
                                        Belum ada jadwal sesi aktif yang diinput oleh Admin.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <p class="mt-4 text-xs text-slate-400 text-center italic">
                    * Total kuota murid yang diampu oleh pengajar maksimal 12 murid di seluruh sesi belajar (masing-masing 4 murid per sesi).
                </p>
            </div>
        </div>
    </section>

    <!-- SECTION 5: TENTANG GURU / PENGAJAR -->
    <section id="guru" class="py-16 md:py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-3xl p-8 md:p-12 border border-slate-200/80 shadow-xl max-w-5xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-center">
                    
                    <!-- Avatar/Foto Guru -->
                    <div class="md:col-span-4 text-center">
                        <div class="w-44 h-44 mx-auto rounded-full bg-gradient-to-tr from-sky-400 via-blue-500 to-indigo-600 p-1.5 shadow-xl shadow-sky-500/20">
                            <div class="w-full h-full rounded-full bg-slate-100 flex items-center justify-center overflow-hidden text-slate-400">
                                @if(!empty($settings['teacher_photo']) && \Illuminate\Support\Facades\Storage::disk('public')->exists($settings['teacher_photo']))
                                    <img src="{{ asset('storage/' . $settings['teacher_photo']) }}" alt="{{ $settings['teacher_name'] ?? 'Foto Pengajar' }}" class="w-full h-full object-cover rounded-full">
                                @elseif(!empty($settings['teacher_photo']) && file_exists(public_path($settings['teacher_photo'])))
                                    <img src="{{ asset($settings['teacher_photo']) }}" alt="{{ $settings['teacher_name'] ?? 'Foto Pengajar' }}" class="w-full h-full object-cover rounded-full">
                                @else
                                    <i class="fa-solid fa-user-graduate text-7xl text-sky-500"></i>
                                @endif
                            </div>
                        </div>
                        <div class="mt-4">
                            <h3 class="text-xl font-bold text-slate-900">{{ $settings['teacher_name'] ?? 'Barijanti, S.Pd.' }}</h3>
                            <span class="text-xs font-bold text-sky-600 bg-sky-50 px-3 py-1 rounded-full border border-sky-100 inline-block mt-1">
                                {{ $settings['teacher_role'] ?? 'Guru TK PGRI 105 Semarang' }}
                            </span>
                        </div>
                    </div>

                    <!-- Teacher Bio Content -->
                    <div class="md:col-span-8 space-y-4">
                        <span class="px-3 py-1 rounded-full bg-amber-100 text-amber-800 text-xs font-bold uppercase tracking-wider">Profil Pengajar</span>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900">{{ $settings['teacher_title'] ?? 'Pendampingan Penuh Kasih & Kesabaran' }}</h2>
                        <p class="text-slate-600 leading-relaxed text-sm">
                            {{ $settings['teacher_bio'] ?? 'Pengajar berpengalaman di TK PGRI 105 Semarang dengan pendekatan belajar yang menyenangkan (fun learning), ramah anak, dan tanpa metode mengeja.' }}
                        </p>
                        
                        <div class="grid grid-cols-2 gap-4 pt-2">
                            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100">
                                <span class="block text-2xl font-black text-sky-600">{{ $settings['teacher_stat1_val'] ?? '10+ th' }}</span>
                                <span class="text-xs font-semibold text-slate-500">{{ $settings['teacher_stat1_lbl'] ?? 'Pengalaman Mengajar' }}</span>
                            </div>
                            <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-100">
                                <span class="block text-2xl font-black text-amber-500">{{ $settings['teacher_stat2_val'] ?? '100%' }}</span>
                                <span class="text-xs font-semibold text-slate-500">{{ $settings['teacher_stat2_lbl'] ?? 'Pendekatan Ramah Anak' }}</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 6: KONTAK & LOKASI PETA -->
    <section id="kontak" class="py-16 md:py-24 bg-white border-y border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16 space-y-3">
                <span class="px-3.5 py-1 rounded-full bg-sky-100 text-sky-700 text-xs font-bold uppercase tracking-wider">Lokasi & Biaya</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900">Hubungi Kami & Peta Lokasi Bimbel</h2>
                <p class="text-slate-600">Bagi orang tua yang memilih opsi pembayaran tunai, silakan datang ke lokasi bimbingan belajar.</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-stretch">
                
                <!-- Contact Info -->
                <div class="lg:col-span-5 bg-slate-900 text-white rounded-3xl p-8 flex flex-col justify-between shadow-xl">
                    <div class="space-y-6">
                        <h3 class="text-2xl font-bold tracking-tight">Informasi Kontak</h3>
                        <p class="text-slate-400 text-sm leading-relaxed">
                            Kami siap menjawab pertanyaan Anda mengenai pendaftaran, kurikulum, dan jadwal sesi belajar.
                        </p>

                        <div class="space-y-4 pt-2">
                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-xl bg-sky-500 text-white flex items-center justify-center font-bold flex-shrink-0">
                                    <i class="fa-brands fa-whatsapp text-xl"></i>
                                </div>
                                <div>
                                    <span class="block text-xs font-bold text-slate-400 uppercase">WhatsApp Admin</span>
                                    <span class="text-base font-bold text-sky-400">{{ $settings['whatsapp_number'] }}</span>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <div class="w-10 h-10 rounded-xl bg-amber-500 text-white flex items-center justify-center font-bold flex-shrink-0">
                                    <i class="fa-solid fa-location-dot text-xl"></i>
                                </div>
                                <div>
                                    <span class="block text-xs font-bold text-slate-400 uppercase">Alamat Bimbel</span>
                                    <p class="text-sm text-slate-200 font-medium leading-relaxed">
                                        {{ $settings['address'] }}
                                    </p>
                                </div>
                            </div>

                            @if(!empty($settings['contact_email']))
                                <div class="flex items-start gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-indigo-500 text-white flex items-center justify-center font-bold flex-shrink-0">
                                        <i class="fa-solid fa-envelope text-xl"></i>
                                    </div>
                                    <div>
                                        <span class="block text-xs font-bold text-slate-400 uppercase">Email Kontak</span>
                                        <span class="text-sm font-bold text-sky-400">{{ $settings['contact_email'] }}</span>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-8 pt-6 border-t border-slate-800 flex flex-wrap sm:flex-nowrap items-center justify-between gap-4">
                        <div class="space-y-0.5">
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-wider">Biaya Bulanan</span>
                            <div class="flex items-baseline gap-1.5">
                                <span class="text-xl sm:text-2xl font-extrabold text-amber-400">Rp {{ number_format((float)$settings['monthly_fee'], 0, ',', '.') }}</span>
                                <span class="text-xs font-semibold text-slate-400">/ bulan</span>
                            </div>
                        </div>
                        @php
                            $waNumber = preg_replace('/[^0-9]/', '', $settings['whatsapp_number']);
                            if (str_starts_with($waNumber, '0')) {
                                $waNumber = '62' . substr($waNumber, 1);
                            }
                            $waTemplate = $settings['wa_template'] ?? 'Halo, saya ingin konsultasi perihal bimbel Bright Kids.';
                        @endphp
                        <button
                            type="button"
                            id="btn-chat-wa"
                            onclick="openWhatsApp('{{ $waNumber }}', '{{ addslashes($waTemplate) }}')"
                            class="px-4 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white text-xs sm:text-sm font-bold shadow-lg shadow-emerald-950/40 hover:shadow-emerald-900/60 transition-all flex items-center gap-2 flex-shrink-0 cursor-pointer border-0 outline-none">
                            <span>Chat WA</span>
                            <i class="fa-brands fa-whatsapp text-base"></i>
                        </button>
                    </div>
                </div>

                <!-- Google Maps Embed -->
                <div class="lg:col-span-7 bg-slate-100 rounded-3xl p-3 border border-slate-200 shadow-sm flex flex-col min-h-[400px]">
                    @if(!empty($settings['maps_iframe']))
                        @php
                            $mapsContent = trim($settings['maps_iframe']);
                            if (filter_var($mapsContent, FILTER_VALIDATE_URL) || (str_starts_with($mapsContent, 'http') && !str_contains($mapsContent, '<iframe'))) {
                                $mapsContent = '<iframe src="' . e($mapsContent) . '" allowfullscreen="" loading="lazy" referrerpolicy="strict-origin-when-cross-origin"></iframe>';
                            }
                        @endphp
                        <div class="w-full h-full min-h-[380px] rounded-2xl overflow-hidden shadow-inner flex-grow flex flex-col map-embed-container">
                            <style>
                                .map-embed-container iframe {
                                    width: 100% !important;
                                    height: 100% !important;
                                    min-height: 380px !important;
                                    border: 0 !important;
                                    display: block !important;
                                    flex-grow: 1 !important;
                                }
                            </style>
                            {!! $mapsContent !!}
                        </div>
                    @else
                        <div class="w-full h-full min-h-[380px] rounded-2xl bg-slate-200 flex flex-col items-center justify-center p-6 text-center text-slate-500">
                            <i class="fa-solid fa-map-location-dot text-5xl mb-3 text-slate-400"></i>
                            <p class="font-bold text-slate-700">Peta Google Maps</p>
                            <p class="text-xs">{{ $settings['address'] }}</p>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </section>

    <!-- SECTION 7: FORMULIR PENDAFTARAN SISWA BARU -->
    <section id="pendaftaran" class="py-16 md:py-24 bg-gradient-to-b from-slate-50 to-sky-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center mb-12 space-y-3">
                <span class="px-3.5 py-1 rounded-full bg-sky-500 text-white text-xs font-bold uppercase tracking-wider shadow-md shadow-sky-500/20">Pendaftaran Online</span>
                <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900">Formulir Pendaftaran Murid Baru</h2>
                <p class="text-slate-600">Isi formulir berikut untuk mendaftarkan putra-putri Anda. Tidak memerlukan akun/login.</p>
            </div>

            @if(session('success'))
                <div class="mb-8 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-2xl text-emerald-500"></i>
                    <div>
                        <h4 class="font-bold text-sm">Pendaftaran Berhasil!</h4>
                        <p class="text-xs">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <div class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200 shadow-xl">
                <form action="{{ route('pendaftaran.store') }}" method="POST" class="space-y-8">
                    @csrf

                    <!-- Kelompok 1: Data Anak -->
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 pb-3 border-b border-slate-100 flex items-center gap-2 mb-6">
                            <span class="w-7 h-7 rounded-lg bg-sky-500 text-white text-xs font-bold flex items-center justify-center">1</span>
                            Data Murid
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Lengkap Murid <span class="text-rose-500">*</span></label>
                                <input type="text" name="full_name" value="{{ old('full_name') }}" required placeholder="Contoh: Ananda Bintang Pratama" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 focus:ring-2 focus:ring-sky-200 outline-none text-sm transition-all">
                                @error('full_name') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tanggal Lahir <span class="text-rose-500">*</span></label>
                                <input type="date" name="date_of_birth" value="{{ old('date_of_birth') }}" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 focus:ring-2 focus:ring-sky-200 outline-none text-sm transition-all bg-white text-slate-800">
                                @error('date_of_birth') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Jenjang / Kelas <span class="text-rose-500">*</span></label>
                                <select name="class_level" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 focus:ring-2 focus:ring-sky-200 outline-none text-sm transition-all bg-white">
                                    <option value="" disabled {{ old('class_level') ? '' : 'selected' }} hidden></option>
                                    <option value="tk_kecil" {{ old('class_level') == 'tk_kecil' ? 'selected' : '' }}>TK Kecil</option>
                                    <option value="tk_besar" {{ old('class_level') == 'tk_besar' ? 'selected' : '' }}>TK Besar</option>
                                    <option value="sd_1" {{ old('class_level') == 'sd_1' ? 'selected' : '' }}>SD Kelas 1</option>
                                    <option value="sd_2" {{ old('class_level') == 'sd_2' ? 'selected' : '' }}>SD Kelas 2</option>
                                    <option value="sd_3" {{ old('class_level') == 'sd_3' ? 'selected' : '' }}>SD Kelas 3</option>
                                </select>
                                @error('class_level') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Asal Sekolah <span class="text-rose-500">*</span></label>
                                <input type="text" name="school_origin" value="{{ old('school_origin') }}" required placeholder="Contoh: TK PGRI 105 Semarang" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 focus:ring-2 focus:ring-sky-200 outline-none text-sm transition-all">
                                @error('school_origin') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Kelompok 2: Data Orang Tua -->
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 pb-3 border-b border-slate-100 flex items-center gap-2 mb-6">
                            <span class="w-7 h-7 rounded-lg bg-sky-500 text-white text-xs font-bold flex items-center justify-center">2</span>
                            Data Orang Tua / Wali
                        </h3>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nama Orang Tua / Wali <span class="text-rose-500">*</span></label>
                                <input type="text" name="parent_name" value="{{ old('parent_name') }}" required placeholder="Contoh: Budi Santoso" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 focus:ring-2 focus:ring-sky-200 outline-none text-sm transition-all">
                                @error('parent_name') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nomor WhatsApp <span class="text-rose-500">*</span></label>
                                <input type="text" name="whatsapp_number" value="{{ old('whatsapp_number') }}" required placeholder="Contoh: 081234567890" class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 focus:ring-2 focus:ring-sky-200 outline-none text-sm transition-all">
                                @error('whatsapp_number') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div class="sm:col-span-2">
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Alamat Lengkap <span class="text-rose-500">*</span></label>
                                <textarea name="address" rows="3" required placeholder="Masukkan alamat domisili lengkap..." class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 focus:ring-2 focus:ring-sky-200 outline-none text-sm transition-all">{{ old('address') }}</textarea>
                                @error('address') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Kelompok 3: Preferensi Jadwal -->
                    <div>
                        <h3 class="text-lg font-bold text-slate-900 pb-3 border-b border-slate-100 flex items-center gap-2 mb-6">
                            <span class="w-7 h-7 rounded-lg bg-sky-500 text-white text-xs font-bold flex items-center justify-center">3</span>
                            Pilihan Jadwal Belajar
                        </h3>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Pilih Sesi Belajar <span class="text-rose-500">*</span></label>
                            <select name="schedule_id" required class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 focus:ring-2 focus:ring-sky-200 outline-none text-sm transition-all bg-white font-semibold text-slate-800">
                                <option value="" disabled {{ old('schedule_id') ? '' : 'selected' }} hidden></option>
                                @foreach($schedules as $s)
                                    @if($s->is_active)
                                        <option value="{{ $s->id }}" {{ old('schedule_id') == $s->id ? 'selected' : '' }}>
                                            {{ $s->session_name }} ({{ $s->day }}, {{ $s->formatted_time }})
                                        </option>
                                    @else
                                        <option value="{{ $s->id }}" disabled class="text-slate-400 bg-slate-100">
                                            {{ $s->session_name }} ({{ $s->day }}, {{ $s->formatted_time }}) — [Sesi Nonaktif]
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                            @error('schedule_id') <span class="text-xs text-rose-500 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4">
                        <button type="submit" class="w-full py-4 rounded-2xl text-base font-bold text-white bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 shadow-xl shadow-sky-500/30 hover:shadow-2xl transition-all">
                            Kirim Pendaftaran Sekarang <i class="fa-solid fa-arrow-right ml-2"></i>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
<script>
    /**
     * Membuka WhatsApp dengan nomor pengajar dan pesan template konsultasi.
     * Menggunakan window.open (bukan hyperlink) sesuai persyaratan Pra-UKK.
     *
     * @param {string} number  - Nomor WA dalam format internasional (e.g. 6282137690701)
     * @param {string} message - Template pesan yang akan dikirim
     */
    function openWhatsApp(number, message) {
        var encodedMessage = encodeURIComponent(message);
        var url = 'https://wa.me/' + number + '?text=' + encodedMessage;
        window.open(url, '_blank', 'noopener,noreferrer');
    }
</script>
@endpush
