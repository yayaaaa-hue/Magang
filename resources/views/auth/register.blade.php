<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Akun - SIMPATIK</title>
    <!-- Plus Jakarta Sans Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/background.css') }}">
    <link rel="stylesheet" href="{{ asset('css/gradient-background.css') }}">
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
    </style>
</head>
<body class="app-background flex items-center justify-center min-h-screen py-10 font-sans px-4 antialiased">

    <div class="w-full max-w-xl bg-white/95 backdrop-blur-md p-8 sm:p-10 rounded-3xl shadow-2xl border border-slate-200/80 my-4" x-data="{ role: '{{ old('role', 'mahasiswa') }}', showPassword: false, showConfirmPassword: false }">
        <!-- Logo & Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-blue-100 text-[#3B82F6] shadow-inner mb-3">
                <i class="fa-solid fa-user-plus text-2xl"></i>
            </div>
            <h1 class="text-2xl sm:text-3xl font-black text-[#172554] tracking-tight">Pendaftaran Akun Baru</h1>
            <p class="text-xs sm:text-sm text-slate-500 mt-1 font-medium">Lengkapi formulir registrasi sesuai kategori Anda</p>
        </div>

        @if ($errors->any())
            <div class="mb-6 p-4 bg-rose-50 border border-rose-200 text-rose-800 text-xs rounded-2xl shadow-sm">
                <div class="font-bold flex items-center space-x-1.5 mb-1 text-rose-600">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span>Terdapat beberapa kesalahan pengisian:</span>
                </div>
                <ul class="list-disc pl-5 space-y-0.5 font-medium">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" class="space-y-5">
            @csrf

            <!-- 1. Selection Tab Categories (Role Selector) -->
            <div>
                <label class="block text-xs font-bold text-[#172554] mb-2 uppercase tracking-wider">Kategori Pendaftar</label>
                <div class="grid grid-cols-2 gap-3 p-1.5 bg-slate-100/80 rounded-2xl border border-slate-200">
                    <!-- Option Mahasiswa -->
                    <label @click="role = 'mahasiswa'" :class="role === 'mahasiswa' ? 'bg-white text-[#3B82F6] shadow-md border-blue-200' : 'text-slate-500 hover:text-slate-800 border-transparent'" class="cursor-pointer p-3 rounded-xl border flex flex-col items-center justify-center space-y-1 transition text-center">
                        <input type="radio" name="role" value="mahasiswa" x-model="role" class="sr-only">
                        <div :class="role === 'mahasiswa' ? 'bg-blue-100 text-[#3B82F6]' : 'bg-slate-200 text-slate-500'" class="w-10 h-10 rounded-full flex items-center justify-center transition">
                            <i class="fa-solid fa-user-graduate text-base"></i>
                        </div>
                        <span class="text-xs font-extrabold">Mahasiswa Magang</span>
                    </label>

                    <!-- Option Pegawai -->
                    <label @click="role = 'pegawai'" :class="role === 'pegawai' ? 'bg-white text-[#EC4899] shadow-md border-pink-200' : 'text-slate-500 hover:text-slate-800 border-transparent'" class="cursor-pointer p-3 rounded-xl border flex flex-col items-center justify-center space-y-1 transition text-center">
                        <input type="radio" name="role" value="pegawai" x-model="role" class="sr-only">
                        <div :class="role === 'pegawai' ? 'bg-pink-100 text-[#EC4899]' : 'bg-slate-200 text-slate-500'" class="w-10 h-10 rounded-full flex items-center justify-center transition">
                            <i class="fa-solid fa-briefcase text-base"></i>
                        </div>
                        <span class="text-xs font-extrabold">Pegawai Aset</span>
                    </label>
                </div>
            </div>

            <!-- 2. Informasi Akun Utama -->
            <div class="space-y-4 pt-2">
                <div>
                    <label class="block text-xs font-bold text-[#172554] mb-1">Nama Lengkap</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                            <i class="fa-solid fa-user text-xs"></i>
                        </span>
                        <input type="text" name="nama" value="{{ old('nama') }}" required placeholder="Contoh: Ahmad Rizky"
                            class="w-full pl-10 pr-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-[#3B82F6] focus:outline-none transition">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-[#172554] mb-1">Alamat Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 text-slate-400">
                            <i class="fa-solid fa-envelope text-xs"></i>
                        </span>
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="nama@domain.com"
                            class="w-full pl-10 pr-4 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-[#3B82F6] focus:outline-none transition">
                    </div>
                </div>
            </div>

            <!-- 3. Dynamic Fields based on Role -->
            <!-- DYNAMIC: MAHASISWA FIELDS -->
            <div x-show="role === 'mahasiswa'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" class="p-4 bg-blue-50/60 rounded-2xl border border-blue-100 space-y-3">
                <div class="flex items-center space-x-2 text-[#3B82F6] font-bold text-xs border-b border-blue-100 pb-2">
                    <div class="w-6 h-6 rounded-full bg-blue-100 flex items-center justify-center">
                        <i class="fa-solid fa-graduation-cap text-xs"></i>
                    </div>
                    <span>Detail Data Mahasiswa Magang</span>
                </div>

                <div>
                    <label class="block text-xs font-bold text-[#172554] mb-1">NIM <span class="text-rose-500">*</span></label>
                    <input type="text" name="nim" value="{{ old('nim') }}" :required="role === 'mahasiswa'" placeholder="Contoh: 531420001"
                        class="w-full px-3.5 py-2 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-[#3B82F6] bg-white">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-[#172554] mb-1">Asal Perguruan Tinggi / Kampus <span class="text-rose-500">*</span></label>
                        <input type="text" name="universitas" value="{{ old('universitas') }}" :required="role === 'mahasiswa'" placeholder="Contoh: Universitas Negeri Gorontalo"
                            class="w-full px-3.5 py-2 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-[#3B82F6] bg-white">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#172554] mb-1">Jurusan <span class="text-rose-500">*</span></label>
                        <input type="text" name="jurusan" value="{{ old('jurusan') }}" :required="role === 'mahasiswa'" placeholder="Contoh: Sistem Informasi"
                            class="w-full px-3.5 py-2 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-[#3B82F6] bg-white">
                    </div>
                </div>
            </div>

            <!-- DYNAMIC: PEGAWAI FIELDS -->
            <div x-show="role === 'pegawai'" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" class="p-4 bg-pink-50/60 rounded-2xl border border-pink-100 space-y-3">
                <div class="flex items-center space-x-2 text-[#EC4899] font-bold text-xs border-b border-pink-100 pb-2">
                    <div class="w-6 h-6 rounded-full bg-pink-100 flex items-center justify-center">
                        <i class="fa-solid fa-id-badge text-xs"></i>
                    </div>
                    <span>Detail Data Pegawai</span>
                </div>

                <div>
                    <label class="block text-xs font-bold text-[#172554] mb-1">NIP / Identitas Pegawai <span class="text-rose-500">*</span></label>
                    <input type="text" name="nip" value="{{ old('nip') }}" :required="role === 'pegawai'" placeholder="Contoh: 199201012020121001"
                        class="w-full px-3.5 py-2 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-[#EC4899] bg-white">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    <div>
                        <label class="block text-xs font-bold text-[#172554] mb-1">Unit Kerja / Instansi / Bidang <span class="text-rose-500">*</span></label>
                        <input type="text" name="unit_kerja" value="{{ old('unit_kerja') }}" :required="role === 'pegawai'" placeholder="Contoh: Bidang E-Government"
                            class="w-full px-3.5 py-2 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-[#EC4899] bg-white">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-[#172554] mb-1">Jabatan <span class="text-rose-500">*</span></label>
                        <input type="text" name="jabatan" value="{{ old('jabatan') }}" :required="role === 'pegawai'" placeholder="Contoh: Pranata Komputer"
                            class="w-full px-3.5 py-2 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-[#EC4899] bg-white">
                    </div>
                </div>
            </div>

            <!-- 4. Password Fields with Eye Toggle Icon -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-[#172554] mb-1">Password</label>
                    <div class="relative">
                        <input :type="showPassword ? 'text' : 'password'" name="password" required placeholder="••••••••"
                            class="w-full pl-3.5 pr-10 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-[#3B82F6] focus:outline-none transition">
                        <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-[#3B82F6] transition">
                            <i class="fa-solid" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-[#172554] mb-1">Konfirmasi Password</label>
                    <div class="relative">
                        <input :type="showConfirmPassword ? 'text' : 'password'" name="password_confirmation" required placeholder="••••••••"
                            class="w-full pl-3.5 pr-10 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-[#3B82F6] focus:outline-none transition">
                        <button type="button" @click="showConfirmPassword = !showConfirmPassword" class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-[#3B82F6] transition">
                            <i class="fa-solid" :class="showConfirmPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- 5. Submit Pill Gradient Button -->
            <button type="submit"
                class="w-full bg-gradient-to-r from-[#3B82F6] to-[#EC4899] hover:from-blue-600 hover:to-pink-600 text-white font-black py-3 px-6 rounded-full text-sm transition duration-300 shadow-lg shadow-blue-500/25 flex items-center justify-center space-x-2 transform hover:-translate-y-0.5 mt-4">
                <span>Daftar Akun Sekarang</span>
                <i class="fa-solid fa-arrow-right text-xs"></i>
            </button>
        </form>

        <p class="mt-6 text-center text-xs text-slate-600 font-medium">
            Sudah memiliki akun? 
            <a href="{{ route('login') }}" class="text-[#3B82F6] hover:underline font-extrabold">Masuk di sini</a>
        </p>
    </div>

</body>
</html>