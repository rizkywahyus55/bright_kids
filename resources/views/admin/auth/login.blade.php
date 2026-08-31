<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — Bright Kids</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        /* Sembunyikan ikon mata bawaan browser (Microsoft Edge / Windows) */
        input[type="password"]::-ms-reveal,
        input[type="password"]::-ms-clear {
            display: none;
        }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-900 via-slate-800 to-sky-900 flex items-center justify-center p-4 antialiased">

    <!-- Background Grid Pattern -->
    <div class="absolute inset-0 opacity-10" style="background-image: url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='60' height='60'%3E%3Cpath d='M54 54H6V6h48z' fill='none' stroke='%23ffffff' stroke-width='0.5'/%3E%3C/svg%3E\");"></div>

    <div class="relative w-full max-w-sm">

        <!-- Card -->
        <div class="bg-white rounded-3xl p-8 shadow-2xl">

            <!-- Logo -->
            <div class="text-center mb-8">
                <div class="w-20 h-20 mx-auto rounded-3xl bg-gradient-to-tr from-sky-500 via-blue-600 to-indigo-600 flex items-center justify-center text-white text-4xl shadow-lg shadow-sky-500/30 mb-4">
                    <i class="fa-solid fa-child-reaching"></i>
                </div>
                <h1 class="text-2xl font-extrabold text-slate-900">Bright Kids</h1>
                <p class="text-sm text-slate-500 mt-1">Panel Admin Bimbingan Belajar</p>
            </div>

            @if($errors->any())
                <div class="mb-5 p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-semibold flex items-center gap-2">
                    <i class="fa-solid fa-circle-exclamation flex-shrink-0"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            @if(session('info'))
                <div class="mb-5 p-3.5 rounded-xl bg-sky-50 border border-sky-200 text-sky-700 text-xs font-semibold flex items-center gap-2">
                    <i class="fa-solid fa-circle-info flex-shrink-0"></i>
                    <span>{{ session('info') }}</span>
                </div>
            @endif

            <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Email Admin</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none"><i class="fa-regular fa-envelope"></i></span>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email', 'Barijanti@gmail.com') }}"
                            required
                            autofocus
                            autocomplete="email"
                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 focus:border-sky-500 focus:ring-2 focus:ring-sky-200 outline-none text-sm transition-all"
                            placeholder="Barijanti@gmail.com"
                        >
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center text-slate-400 pointer-events-none"><i class="fa-solid fa-lock"></i></span>
                        <input
                            id="password"
                            type="password"
                            name="password"
                            required
                            autocomplete="current-password"
                            class="w-full pl-10 pr-12 py-3 rounded-xl border border-slate-200 focus:border-sky-500 focus:ring-2 focus:ring-sky-200 outline-none text-sm transition-all"
                            placeholder="••••••••"
                        >
                        <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-slate-400 hover:text-slate-600 transition-colors">
                            <i id="eye-icon" class="fa-regular fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 text-sm text-slate-600 cursor-pointer">
                        <input type="checkbox" name="remember" class="rounded border-slate-300 text-sky-600 focus:ring-sky-200">
                        <span>Ingat Saya</span>
                    </label>
                </div>

                <button type="submit" id="login-btn" class="w-full py-3.5 rounded-xl font-bold text-white bg-gradient-to-r from-sky-500 to-blue-600 hover:from-sky-600 hover:to-blue-700 shadow-lg shadow-sky-500/25 hover:shadow-xl transition-all flex items-center justify-center gap-2">
                    <i class="fa-solid fa-right-to-bracket"></i>
                    Masuk ke Dashboard Admin
                </button>
            </form>

            <div class="mt-6 pt-5 border-t border-slate-100 text-center">
                <a href="{{ route('home') }}" class="text-xs text-slate-400 hover:text-sky-600 transition-colors">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Kembali ke Halaman Utama
                </a>
            </div>
        </div>

        <p class="text-center text-xs text-slate-500/70 mt-6">
            © {{ date('Y') }} Bright Kids — Pra-UKK SMKN 8 Semarang
        </p>
    </div>

    <script>
        function togglePassword() {
            const pw = document.getElementById('password');
            const icon = document.getElementById('eye-icon');
            if (pw.type === 'password') {
                pw.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                pw.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
</body>
</html>
