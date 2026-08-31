<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Bright Kids - Bimbingan Belajar Membaca & Menulis Anak Usia Dini')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            500: '#0284c7',
                            600: '#0284c7',
                            700: '#0369a1',
                        },
                        amber: {
                            400: '#fbbf24',
                            500: '#f59e0b',
                        }
                    }
                }
            }
        }
    </script>

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-50 text-slate-800 antialiased selection:bg-sky-500 selection:text-white flex flex-col min-h-screen">

    <!-- Header / Navbar -->
    <header class="sticky top-0 z-50 bg-white/90 backdrop-blur-md border-b border-slate-100 shadow-sm transition-all">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-sky-500 via-blue-600 to-indigo-600 flex items-center justify-center text-white text-2xl font-black shadow-lg shadow-sky-500/25 group-hover:scale-105 transition-transform">
                        <i class="fa-solid fa-child-reaching"></i>
                    </div>
                    <div>
                        <span class="text-2xl font-extrabold bg-gradient-to-r from-sky-600 to-indigo-600 bg-clip-text text-transparent tracking-tight">Bright Kids</span>
                        <span class="block text-xs font-semibold text-slate-400 tracking-wider uppercase">Bimbel Membaca & Menulis</span>
                    </div>
                </a>

                <!-- Desktop Nav -->
                <nav class="hidden md:flex items-center gap-8 font-semibold text-sm text-slate-600">
                    <a href="{{ route('home') }}#beranda" class="hover:text-sky-600 transition-colors py-1">Beranda</a>
                    <a href="{{ route('home') }}#tentang" class="hover:text-sky-600 transition-colors py-1">Tentang</a>
                    <a href="{{ route('home') }}#program" class="hover:text-sky-600 transition-colors py-1">Program</a>
                    <a href="{{ route('home') }}#jadwal" class="hover:text-sky-600 transition-colors py-1">Jadwal</a>
                    <a href="{{ route('home') }}#guru" class="hover:text-sky-600 transition-colors py-1">Pengajar</a>
                    <a href="{{ route('home') }}#kontak" class="hover:text-sky-600 transition-colors py-1">Kontak</a>
                </nav>

                <!-- Actions -->
                <div class="hidden md:flex items-center gap-3">
                    <a href="{{ route('pendaftaran.status') }}" class="px-4 py-2.5 rounded-xl text-sm font-bold text-sky-700 bg-sky-50 hover:bg-sky-100 transition-all border border-sky-200/60 shadow-sm">
                        <i class="fa-solid fa-magnifying-glass mr-1.5"></i> Cek Status
                    </a>
                    <a href="{{ route('home') }}#pendaftaran" class="px-5 py-2.5 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 shadow-md shadow-sky-500/20 hover:shadow-lg transition-all scale-100 active:scale-95">
                        Daftar Sekarang <i class="fa-solid fa-arrow-right ml-1"></i>
                    </a>
                </div>

                <!-- Mobile menu button -->
                <button id="mobile-menu-btn" class="md:hidden p-2.5 rounded-xl text-slate-600 hover:bg-slate-100 focus:outline-none">
                    <i class="fa-solid fa-bars text-xl"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation Drawer -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-b border-slate-200 px-4 pt-2 pb-6 space-y-3">
            <a href="{{ route('home') }}#beranda" class="block px-3 py-2 rounded-lg font-semibold text-slate-700 hover:bg-sky-50 hover:text-sky-600">Beranda</a>
            <a href="{{ route('home') }}#tentang" class="block px-3 py-2 rounded-lg font-semibold text-slate-700 hover:bg-sky-50 hover:text-sky-600">Tentang</a>
            <a href="{{ route('home') }}#program" class="block px-3 py-2 rounded-lg font-semibold text-slate-700 hover:bg-sky-50 hover:text-sky-600">Program Belajar</a>
            <a href="{{ route('home') }}#jadwal" class="block px-3 py-2 rounded-lg font-semibold text-slate-700 hover:bg-sky-50 hover:text-sky-600">Jadwal Sesi</a>
            <a href="{{ route('home') }}#guru" class="block px-3 py-2 rounded-lg font-semibold text-slate-700 hover:bg-sky-50 hover:text-sky-600">Tentang Guru</a>
            <a href="{{ route('home') }}#kontak" class="block px-3 py-2 rounded-lg font-semibold text-slate-700 hover:bg-sky-50 hover:text-sky-600">Kontak & Peta</a>
            <div class="pt-2 flex flex-col gap-2">
                <a href="{{ route('pendaftaran.status') }}" class="w-full text-center px-4 py-2.5 rounded-xl font-bold text-sky-700 bg-sky-50 border border-sky-200">
                    <i class="fa-solid fa-magnifying-glass mr-1.5"></i> Cek Status Pendaftaran
                </a>
                <a href="{{ route('home') }}#pendaftaran" class="w-full text-center px-4 py-2.5 rounded-xl font-bold text-white bg-sky-600 shadow-md">
                    Daftar Sekarang
                </a>
            </div>
        </div>
    </header>

    <!-- Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-400 py-12 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div class="md:col-span-2">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl bg-sky-500 flex items-center justify-center text-white font-bold text-xl">
                            <i class="fa-solid fa-child-reaching"></i>
                        </div>
                        <span class="text-2xl font-bold text-white tracking-tight">Bright Kids</span>
                    </div>
                    <p class="text-slate-400 text-sm max-w-sm mb-4 leading-relaxed">
                        Platform bimbingan belajar membaca & menulis anak usia dini (TK Kecil, TK Besar, SD 1–3) dengan metode ramah anak tanpa mengeja.
                    </p>
                    <div class="flex items-center gap-3 text-slate-400 text-sm">
                        <span class="px-3 py-1 rounded-full bg-slate-800 border border-slate-700 text-xs font-semibold text-sky-400">
                            Pra-UKK PPLG SMKN 8 Semarang
                        </span>
                    </div>
                </div>

                <div>
                    <h4 class="text-white font-bold text-sm uppercase tracking-wider mb-4">Navigasi Cepat</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('home') }}#beranda" class="hover:text-white transition-colors">Beranda</a></li>
                        <li><a href="{{ route('home') }}#program" class="hover:text-white transition-colors">Program Kurikulum</a></li>
                        <li><a href="{{ route('home') }}#jadwal" class="hover:text-white transition-colors">Jadwal Sesi</a></li>
                        <li><a href="{{ route('home') }}#guru" class="hover:text-white transition-colors">Profil Pengajar</a></li>
                        <li><a href="{{ route('pendaftaran.status') }}" class="hover:text-white transition-colors">Cek Status Pendaftaran</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-white font-bold text-sm uppercase tracking-wider mb-4">Area Pengelola</h4>
                    <p class="text-xs text-slate-500 mb-3">Khusus Pengajar untuk mengelola jadwal, absensi, dan laporan perkembangan.</p>
                    <a href="{{ route('admin.login') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-200 text-xs font-semibold border border-slate-700 transition-all">
                        <i class="fa-solid fa-user-shield text-sky-400"></i> Login Dashboard Admin
                    </a>
                </div>
            </div>

            <div class="border-t border-slate-800 pt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-4">
                <p>&copy; {{ date('Y') }} Bright Kids. Disusun oleh Rizky Wahyu Saputra — XII PPLG 1 SMKN 8 Semarang.</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile Menu Toggle
        const menuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        if (menuBtn && mobileMenu) {
            menuBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });
        }
    </script>
    @stack('scripts')
</body>
</html>
