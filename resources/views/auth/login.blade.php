<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - SIMPATIK</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/background.css') }}">
    <link rel="stylesheet" href="{{ asset('css/gradient-background.css') }}">
    
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        [x-cloak] { display: none !important; }
        :root {
            --color-primary: #3B82F6;
            --color-blue-light: #93C5FD;
            --color-white: #FFFFFF;
            --color-pink: #EC4899;
            --color-pink-light: #F9A8D4;
            --color-navy: #172554;
        }
        body {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
        }
        .app-background, body.app-background {
            background: linear-gradient(135deg, rgba(147, 197, 253, 0.45) 0%, rgba(255, 255, 255, 0.95) 50%, rgba(249, 168, 212, 0.45) 100%) !important;
            background-attachment: fixed !important;
            min-height: 100vh;
        }
        .bg-card-gradient {
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.96) 0%, rgba(239, 246, 255, 0.65) 50%, rgba(253, 242, 248, 0.65) 100%) !important;
            border: 1px solid rgba(147, 197, 253, 0.45) !important;
            border-radius: 1.5rem !important;
            box-shadow: 0 10px 25px -5px rgba(23, 37, 84, 0.07), 0 4px 12px -2px rgba(23, 37, 84, 0.03);
        }
        .form-input {
            width: 100% !important;
            height: 2.625rem !important;
            box-sizing: border-box !important;
            padding: 0.625rem 0.875rem !important;
            font-size: 0.875rem !important;
            font-weight: 500 !important;
            color: #172554 !important;
            background-color: rgba(255, 255, 255, 0.95) !important;
            border: 1px solid #CBD5E1 !important;
            border-radius: 0.75rem !important;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
            transition: all 0.2s ease-in-out !important;
        }
        .form-input:focus {
            outline: none !important;
            border-color: #3B82F6 !important;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2) !important;
        }
        .form-label {
            display: block !important;
            font-size: 0.75rem !important;
            font-weight: 700 !important;
            color: #172554 !important;
            margin-bottom: 0.375rem !important;
            text-transform: uppercase !important;
            letter-spacing: 0.025em !important;
        }
        .btn-pill-primary {
            background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%) !important;
            color: #FFFFFF !important;
            border: none !important;
            border-radius: 9999px !important;
            font-weight: 700 !important;
            transition: all 0.3s ease !important;
            box-shadow: 0 4px 14px 0 rgba(59, 130, 246, 0.35) !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            cursor: pointer !important;
        }
        .btn-pill-primary:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 6px 20px 0 rgba(59, 130, 246, 0.45) !important;
            background: linear-gradient(135deg, #2563EB 0%, #1D4ED8 100%) !important;
        }
        .text-navy {
            color: var(--color-navy) !important;
        }
    </style>
</head>
<body class="app-background min-h-screen flex items-center justify-center p-4 antialiased">
    <div class="max-w-md w-full" x-data="{ showPassword: false }">
        <!-- Logo & Header (Tema Sinosip) -->
        <div class="text-center mb-8">
            <a href="/" class="inline-flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-white font-bold text-2xl shadow-lg shadow-blue-500/30" style="background: linear-gradient(135deg, #3B82F6 0%, #EC4899 100%);">
                    <i class="fa-solid fa-shield-halved text-xl"></i>
                </div>
                <span class="font-extrabold text-3xl tracking-tight text-navy">SIMPATIK</span>
            </a>
            <h2 class="mt-4 text-2xl font-bold text-navy">Masuk ke Akun Anda</h2>
            <p class="mt-1 text-sm text-slate-600 font-medium">Dinas Kominfo Bone Bolango</p>
        </div>

        <!-- Card Form Login Bergaya Sinosip -->
        <div class="bg-card-gradient p-8 sm:p-10 rounded-3xl shadow-xl shadow-blue-900/5 border border-blue-200/50 backdrop-blur-sm">
            @if(session('error'))
                <div class="mb-6 bg-red-50 text-red-600 p-4 rounded-xl text-sm border border-red-200 flex items-center gap-2">
                    <i class="fa-solid fa-circle-exclamation text-base shrink-0"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-6 bg-red-50 text-red-600 p-4 rounded-xl text-sm border border-red-200">
                    <ul class="list-disc pl-4 space-y-1 font-medium">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label for="email" class="form-label">Email / Nama Pengguna</label>
                    <div class="mt-1 relative">
                        <input id="email" name="email" type="email" autocomplete="username" required class="form-input" placeholder="nama@email.com" value="{{ old('email') }}">
                    </div>
                </div>

                <div>
                    <label for="password" class="form-label">Password</label>
                    <div class="mt-1 relative">
                        <input :type="showPassword ? 'text' : 'password'" id="password" name="password" autocomplete="current-password" required class="form-input pr-10" placeholder="••••••••">
                        <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-[#3B82F6] transition">
                            <i class="fa-solid text-xs" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                </div>

                <div class="flex justify-end text-xs">
                    <a href="#" onclick="alert('Silakan hubungi Administrator SIMPATIK Diskominfo untuk bantuan reset kata sandi.'); return false;" class="text-[#3B82F6] hover:text-blue-800 font-bold transition">
                        Lupa password?
                    </a>
                </div>

                <div class="pt-2">
                    <button type="submit" class="btn-pill-primary w-full py-3 px-4 text-sm font-bold shadow-lg">
                        Sign In &rarr;
                    </button>
                </div>
            </form>

            <div class="mt-6 pt-5 border-t border-blue-200/40 text-center text-xs text-slate-600 font-medium">
                Belum memiliki akun? 
                <a href="{{ route('register') }}" class="text-[#EC4899] hover:underline font-extrabold">Daftar Akun Baru</a>
            </div>
        </div>

        <div class="mt-6 text-center text-xs text-slate-500 font-medium">
            &copy; {{ date('Y') }} SIMPATIK &mdash; Dinas Kominfo Bone Bolango.
        </div>
    </div>
</body>
</html>