<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin') — Bright Kids</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] },
                }
            }
        }
    </script>

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        /* Custom Scrollbar Global */
        * {
            scrollbar-width: thin;
            scrollbar-color: #0284c7 #0f172a;
        }

        /* WebKit Custom Scrollbar (Chrome, Edge, Safari) */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: #0f172a;
        }
        ::-webkit-scrollbar-thumb {
            background: #0284c7;
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #38bdf8;
        }
        ::-webkit-scrollbar-button {
            display: none !important;
            width: 0 !important;
            height: 0 !important;
        }

        /* Sidebar Navigation Custom Scrollbar */
        #sidebar nav {
            scrollbar-width: thin;
            scrollbar-color: #0284c7 #0f172a;
        }
        #sidebar nav::-webkit-scrollbar {
            width: 5px;
        }
        #sidebar nav::-webkit-scrollbar-track {
            background: #0f172a;
        }
        #sidebar nav::-webkit-scrollbar-thumb {
            background: #0284c7;
            border-radius: 9999px;
        }
        #sidebar nav::-webkit-scrollbar-thumb:hover {
            background: #38bdf8;
        }
        #sidebar nav::-webkit-scrollbar-button {
            display: none !important;
            width: 0 !important;
            height: 0 !important;
        }

        /* Main Content Scrollbar */
        main::-webkit-scrollbar {
            width: 7px;
        }
        main::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        main::-webkit-scrollbar-thumb {
            background: #94a3b8;
            border-radius: 9999px;
        }
        main::-webkit-scrollbar-thumb:hover {
            background: #0284c7;
        }
        main::-webkit-scrollbar-button {
            display: none !important;
            width: 0 !important;
            height: 0 !important;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-slate-100 text-slate-800 antialiased" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen overflow-hidden">

        <!-- ===== SIDEBAR ===== -->
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-72 bg-slate-900 text-slate-200 flex flex-col transition-transform duration-300 -translate-x-full lg:translate-x-0 lg:static lg:inset-auto shadow-2xl">

            <!-- Logo & Brand Header -->
            <div class="flex items-center gap-3.5 px-6 py-5 border-b border-slate-800 flex-shrink-0 bg-slate-950/40">
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-tr from-sky-600 to-indigo-500 flex items-center justify-center text-white text-xl shadow-lg shadow-sky-500/30 flex-shrink-0">
                    <i class="fa-solid fa-child-reaching"></i>
                </div>
                <div>
                    <span class="text-white text-lg font-extrabold tracking-tight block">Bright Kids</span>
                    <span class="block text-xs text-sky-400 font-semibold uppercase tracking-wider">Panel Admin</span>
                </div>
            </div>

            <!-- Navigation Links -->
            <nav class="flex-1 overflow-y-auto px-4 py-5 space-y-6">

                <!-- Section: Utama -->
                <div>
                    <p class="px-3 text-[11px] font-bold uppercase tracking-widest text-slate-400 mb-2">Menu Utama</p>
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-bold transition-all group {{ request()->routeIs('admin.dashboard') ? 'bg-sky-500 text-white shadow-lg shadow-sky-500/25' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <span class="w-8 h-8 rounded-lg flex items-center justify-center text-sm flex-shrink-0 transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-white/20 text-white' : 'bg-slate-800 text-slate-400 group-hover:bg-slate-700 group-hover:text-white' }}">
                            <i class="fa-solid fa-gauge-high"></i>
                        </span>
                        <span>Dashboard Utama</span>
                    </a>
                </div>

                <!-- Section: Pengelolaan -->
                <div>
                    <p class="px-3 text-[11px] font-bold uppercase tracking-widest text-slate-400 mb-2">Pengelolaan</p>
                    <div class="space-y-1">

                        <a href="{{ route('admin.jadwal.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-bold transition-all group {{ request()->routeIs('admin.jadwal.*') ? 'bg-sky-500 text-white shadow-lg shadow-sky-500/25' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                            <span class="w-8 h-8 rounded-lg flex items-center justify-center text-sm flex-shrink-0 transition-colors {{ request()->routeIs('admin.jadwal.*') ? 'bg-white/20 text-white' : 'bg-slate-800 text-slate-400 group-hover:bg-slate-700 group-hover:text-white' }}">
                                <i class="fa-solid fa-calendar-days"></i>
                            </span>
                            <span>Jadwal Sesi Belajar</span>
                        </a>

                        <a href="{{ route('admin.pendaftaran.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-bold transition-all group {{ request()->routeIs('admin.pendaftaran.*') ? 'bg-sky-500 text-white shadow-lg shadow-sky-500/25' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                            <span class="w-8 h-8 rounded-lg flex items-center justify-center text-sm flex-shrink-0 transition-colors {{ request()->routeIs('admin.pendaftaran.*') ? 'bg-white/20 text-white' : 'bg-slate-800 text-slate-400 group-hover:bg-slate-700 group-hover:text-white' }}">
                                <i class="fa-solid fa-file-pen"></i>
                            </span>
                            <span class="flex-1">Pendaftaran</span>
                            @php $pending = \App\Models\Registration::where('status','menunggu_verifikasi')->count(); @endphp
                            @if($pending > 0)
                                <span class="bg-amber-400 text-slate-950 text-xs font-black px-2 py-0.5 rounded-full shadow-sm">{{ $pending }}</span>
                            @endif
                        </a>

                        <a href="{{ route('admin.siswa.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-bold transition-all group {{ request()->routeIs('admin.siswa.*') ? 'bg-sky-500 text-white shadow-lg shadow-sky-500/25' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                            <span class="w-8 h-8 rounded-lg flex items-center justify-center text-sm flex-shrink-0 transition-colors {{ request()->routeIs('admin.siswa.*') ? 'bg-white/20 text-white' : 'bg-slate-800 text-slate-400 group-hover:bg-slate-700 group-hover:text-white' }}">
                                <i class="fa-solid fa-children"></i>
                            </span>
                            <span>Data Anak & Wali</span>
                        </a>

                        <a href="{{ route('admin.absensi.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-bold transition-all group {{ request()->routeIs('admin.absensi.*') ? 'bg-sky-500 text-white shadow-lg shadow-sky-500/25' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                            <span class="w-8 h-8 rounded-lg flex items-center justify-center text-sm flex-shrink-0 transition-colors {{ request()->routeIs('admin.absensi.*') ? 'bg-white/20 text-white' : 'bg-slate-800 text-slate-400 group-hover:bg-slate-700 group-hover:text-white' }}">
                                <i class="fa-solid fa-clipboard-check"></i>
                            </span>
                            <span>Absensi Pertemuan</span>
                        </a>

                        <a href="{{ route('admin.laporan-perkembangan.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-bold transition-all group {{ request()->routeIs('admin.laporan-perkembangan.*') ? 'bg-sky-500 text-white shadow-lg shadow-sky-500/25' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                            <span class="w-8 h-8 rounded-lg flex items-center justify-center text-sm flex-shrink-0 transition-colors {{ request()->routeIs('admin.laporan-perkembangan.*') ? 'bg-white/20 text-white' : 'bg-slate-800 text-slate-400 group-hover:bg-slate-700 group-hover:text-white' }}">
                                <i class="fa-solid fa-chart-line"></i>
                            </span>
                            <span>Laporan Perkembangan</span>
                        </a>

                        <a href="{{ route('admin.pembayaran.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-bold transition-all group {{ request()->routeIs('admin.pembayaran.*') ? 'bg-sky-500 text-white shadow-lg shadow-sky-500/25' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                            <span class="w-8 h-8 rounded-lg flex items-center justify-center text-sm flex-shrink-0 transition-colors {{ request()->routeIs('admin.pembayaran.*') ? 'bg-white/20 text-white' : 'bg-slate-800 text-slate-400 group-hover:bg-slate-700 group-hover:text-white' }}">
                                <i class="fa-solid fa-money-bill-trend-up"></i>
                            </span>
                            <span class="flex-1">Pembayaran</span>
                            @php $pendingPay = \App\Models\Payment::where('status','pending')->count(); @endphp
                            @if($pendingPay > 0)
                                <span class="bg-rose-500 text-white text-xs font-black px-2 py-0.5 rounded-full shadow-sm">{{ $pendingPay }}</span>
                            @endif
                        </a>

                    </div>
                </div>

                <!-- Section: Konfigurasi -->
                <div>
                    <p class="px-3 text-[11px] font-bold uppercase tracking-widest text-slate-400 mb-2">Konfigurasi</p>
                    <a href="{{ route('admin.pengaturan.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-sm font-bold transition-all group {{ request()->routeIs('admin.pengaturan.*') ? 'bg-sky-500 text-white shadow-lg shadow-sky-500/25' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
                        <span class="w-8 h-8 rounded-lg flex items-center justify-center text-sm flex-shrink-0 transition-colors {{ request()->routeIs('admin.pengaturan.*') ? 'bg-white/20 text-white' : 'bg-slate-800 text-slate-400 group-hover:bg-slate-700 group-hover:text-white' }}">
                            <i class="fa-solid fa-gear"></i>
                        </span>
                        <span>Pengaturan Website</span>
                    </a>
                </div>

            </nav>

            <!-- Sidebar Footer: Profile & Web View Link -->
            <div class="p-4 border-t border-slate-800 bg-slate-950/40 space-y-2 flex-shrink-0">
                <div class="flex items-center gap-3 p-2.5 rounded-xl bg-slate-800/80 border border-slate-700/50">
                    <div class="w-9 h-9 rounded-xl bg-sky-500/20 text-sky-400 flex items-center justify-center font-bold text-sm flex-shrink-0">
                        <i class="fa-solid fa-user-shield"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <span class="block text-xs font-bold text-white truncate">{{ auth()->user()->name ?? 'Barijanti, S.Pd.' }}</span>
                        <span class="block text-[11px] text-slate-400 truncate">{{ auth()->user()->email ?? 'admin@brightkids.com' }}</span>
                    </div>
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="text-slate-400 hover:text-rose-400 transition-colors p-1.5 rounded-lg hover:bg-slate-700" title="Keluar">
                            <i class="fa-solid fa-right-from-bracket text-sm"></i>
                        </button>
                    </form>
                </div>

                <a href="{{ route('home') }}" target="_blank" class="flex items-center justify-center gap-2 px-3 py-2 rounded-xl text-xs font-bold text-slate-400 hover:text-sky-300 hover:bg-slate-800/80 transition-all border border-slate-800">
                    <i class="fa-solid fa-arrow-up-right-from-square text-[11px]"></i> Lihat Halaman Dashboard 
                </a>
            </div>
        </aside>

        <!-- Mobile Sidebar Overlay -->
        <div id="sidebar-overlay" class="fixed inset-0 bg-slate-950/60 backdrop-blur-sm z-40 hidden lg:hidden" onclick="toggleSidebar()"></div>

        <!-- ===== MAIN CONTENT AREA ===== -->
        <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

            <!-- Top Header Bar -->
            <header class="flex-shrink-0 bg-white border-b border-slate-200/80 h-16 flex items-center justify-between px-4 sm:px-6 shadow-sm z-30">
                <div class="flex items-center gap-4">
                    <button onclick="toggleSidebar()" class="lg:hidden p-2 rounded-xl text-slate-600 hover:bg-slate-100 transition-colors">
                        <i class="fa-solid fa-bars text-lg"></i>
                    </button>
                    <div>
                        <h1 class="text-base sm:text-lg font-extrabold text-slate-900 tracking-tight">@yield('page-title', 'Dashboard Admin')</h1>
                        <p class="text-xs text-slate-500 hidden sm:block font-medium">@yield('page-subtitle', 'Selamat datang di Panel Admin Bright Kids')</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <span class="hidden sm:inline-flex items-center gap-1.5 text-xs font-bold text-slate-600 bg-slate-100 px-3 py-1.5 rounded-xl border border-slate-200/60">
                        <i class="fa-regular fa-calendar-check text-sky-600"></i>
                        {{ \Carbon\Carbon::now('Asia/Jakarta')->isoFormat('dddd, D MMMM Y') }}
                    </span>
                </div>
            </header>

            <!-- Flash Notifications -->
            <div class="px-4 sm:px-6 pt-4">
                @if(session('success'))
                    <div class="flex items-center gap-3 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-900 text-sm font-bold shadow-sm">
                        <i class="fa-solid fa-circle-check text-xl text-emerald-600 flex-shrink-0"></i>
                        <span class="flex-1">{{ session('success') }}</span>
                        <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 p-1"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="flex items-center gap-3 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-900 text-sm font-bold shadow-sm">
                        <i class="fa-solid fa-circle-exclamation text-xl text-rose-600 flex-shrink-0"></i>
                        <span class="flex-1">{{ session('error') }}</span>
                        <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700 p-1"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                @endif
                @if(session('info'))
                    <div class="flex items-center gap-3 p-4 rounded-2xl bg-sky-50 border border-sky-200 text-sky-900 text-sm font-bold shadow-sm">
                        <i class="fa-solid fa-circle-info text-xl text-sky-600 flex-shrink-0"></i>
                        <span class="flex-1">{{ session('info') }}</span>
                        <button onclick="this.parentElement.remove()" class="text-sky-500 hover:text-sky-700 p-1"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                @endif
            </div>

            <!-- Page Main Content -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6">
                @yield('content')
            </main>

        </div>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
    </script>
    @stack('scripts')
</body>
</html>
