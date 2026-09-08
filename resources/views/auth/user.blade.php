<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen User - SIMPATIK</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/background.css') }}">
    <link rel="stylesheet" href="{{ asset('css/gradient-background.css') }}">
    <style>
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
        .bg-sidebar-gradient {
            background: linear-gradient(180deg, var(--color-navy) 0%, #1E3A8A 55%, #1E1B4B 100%) !important;
            box-shadow: 4px 0 25px rgba(23, 37, 84, 0.18);
        }
        .bg-card-gradient {
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.96) 0%, rgba(239, 246, 255, 0.65) 50%, rgba(253, 242, 248, 0.65) 100%) !important;
            border: 1px solid rgba(147, 197, 253, 0.45);
            border-radius: 1.5rem;
            box-shadow: 0 10px 25px -5px rgba(23, 37, 84, 0.07), 0 4px 12px -2px rgba(23, 37, 84, 0.03);
        }
        .bg-header-gradient {
            background: linear-gradient(90deg, rgba(255, 255, 255, 0.94) 0%, rgba(255, 255, 255, 0.88) 100%) !important;
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(147, 197, 253, 0.35);
        }
    </style>
</head>
<body class="app-background font-sans antialiased text-slate-800">

    <div class="min-h-screen flex">
        <!-- Sidebar Navigation with Uniform Gradient -->
        <aside class="w-64 bg-sidebar-gradient text-white flex flex-col justify-between p-4 hidden md:flex">
            <div>
                <div class="flex items-center space-x-3 px-2 py-3 border-b border-blue-900/60">
                    <div class="w-10 h-10 rounded-full bg-blue-100 text-[#3B82F6] flex items-center justify-center shadow-md">
                        <i class="fa-solid fa-shield-halved text-lg"></i>
                    </div>
                    <div>
                        <h2 class="font-black text-base leading-tight text-white">Admin Panel</h2>
                        <span class="text-xs text-blue-200">Diskominfo Bonebol</span>
                    </div>
                </div>

                <!-- Navigation Links -->
                <nav class="mt-6 space-y-2">
                    <a href="{{ route('admin.aset') }}" class="flex items-center space-x-3 px-4 py-3 text-blue-100 hover:bg-blue-900/50 hover:text-white rounded-full font-medium transition">
                        <i class="fa-solid fa-boxes-stacked w-5"></i>
                        <span>Manajemen Aset</span>
                    </a>
                    <a href="{{ route('admin.magang') }}" class="flex items-center space-x-3 px-4 py-3 text-blue-100 hover:bg-blue-900/50 hover:text-white rounded-full font-medium transition">
                        <i class="fa-solid fa-user-graduate w-5"></i>
                        <span>Kelola Magang</span>
                    </a>
                    @if(Auth::user()->role === 'admin_master')
                    <a href="{{ route('admin.user') }}" class="flex items-center space-x-3 px-4 py-3 bg-[#3B82F6] text-white rounded-full font-bold shadow-md transition">
                        <i class="fa-solid fa-users w-5"></i>
                        <span>Manajemen User</span>
                    </a>
                    @endif
                </nav>
            </div>

            <div class="border-t border-blue-900/60 pt-4">
                <div class="flex items-center justify-between px-2">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-pink-100 text-[#EC4899] rounded-full flex items-center justify-center font-black shadow uppercase">
                            {{ substr(Auth::user()->nama ?? 'A', 0, 1) }}
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-white truncate max-w-[110px]">{{ Auth::user()->nama ?? 'Admin' }}</p>
                            <p class="text-xs text-blue-200">{{ Auth::user()->role === 'admin_master' ? 'Admin Master' : 'Administrator' }}</p>
                        </div>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" title="Logout" class="text-blue-200 hover:text-rose-400 p-2 transition">
                            <i class="fa-solid fa-right-from-bracket text-lg"></i>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 flex flex-col overflow-x-hidden">
            <header class="bg-header-gradient px-6 py-4 flex items-center justify-between shadow-sm">
                <h1 class="text-xl font-black text-[#172554] tracking-tight">Manajemen Pengguna Sistem</h1>
            </header>

            <div class="p-6 space-y-6 flex-1">

                @if(session('success'))
                    <div class="p-4 bg-emerald-100 border border-emerald-300 text-emerald-800 rounded-2xl text-sm flex items-center space-x-2 shadow-sm">
                        <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="p-4 bg-rose-100 border border-rose-300 text-rose-800 rounded-2xl text-sm flex items-center space-x-2 shadow-sm">
                        <i class="fa-solid fa-circle-exclamation text-rose-600 text-lg"></i>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                @endif

                <!-- Form Tambah User Baru (Khusus Admin Master) -->
                <div class="bg-card-gradient rounded-3xl p-6 space-y-4">
                    <h3 class="font-extrabold text-[#172554] text-base">Tambah Pengguna Baru</h3>
                    <form action="{{ route('admin.user.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-[#172554] mb-1.5 uppercase tracking-wider">Nama Lengkap</label>
                            <input type="text" name="nama" required placeholder="Nama lengkap..." class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-xs font-medium text-[#172554] focus:ring-2 focus:ring-[#3B82F6] focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-[#172554] mb-1.5 uppercase tracking-wider">Email Akun</label>
                            <input type="email" name="email" required placeholder="email@kominfo.go.id" class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-xs font-medium text-[#172554] focus:ring-2 focus:ring-[#3B82F6] focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-[#172554] mb-1.5 uppercase tracking-wider">Kata Sandi</label>
                            <input type="password" name="password" required placeholder="Minimal 6 karakter" class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-xs font-medium text-[#172554] focus:ring-2 focus:ring-[#3B82F6] focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-[#172554] mb-1.5 uppercase tracking-wider">Peran (Role)</label>
                            <select name="role" class="w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-xs font-medium text-[#172554] focus:ring-2 focus:ring-[#3B82F6] focus:outline-none">
                                <option value="admin_master">Admin Master</option>
                                <option value="admin">Admin Biasa</option>
                                <option value="pegawai">Pegawai</option>
                                <option value="mahasiswa">Mahasiswa Magang</option>
                            </select>
                        </div>
                        <div class="md:col-span-4 flex justify-end pt-2">
                            <button type="submit" class="bg-gradient-to-r from-[#3B82F6] to-[#2563EB] hover:from-blue-600 hover:to-blue-700 text-white text-xs font-bold py-2.5 px-6 rounded-full shadow-md transition">
                                <i class="fa-solid fa-user-plus mr-1.5"></i> Simpan Pengguna Baru
                            </button>
                        </div>
                    </form>
                </div>

                <div class="bg-card-gradient rounded-3xl p-6 space-y-4">
                    <h3 class="font-extrabold text-[#172554] text-base">Daftar Akun Pengguna Terdaftar</h3>

                    <div class="overflow-x-auto rounded-2xl border border-slate-200">
                        <table class="w-full text-left text-xs text-slate-600">
                            <thead class="bg-slate-100 text-[#172554] uppercase font-bold border-b border-slate-200">
                                <tr>
                                    <th class="px-4 py-3">No</th>
                                    <th class="px-4 py-3">Nama Pengguna</th>
                                    <th class="px-4 py-3">Email</th>
                                    <th class="px-4 py-3">Role</th>
                                    <th class="px-4 py-3">Terdaftar Pada</th>
                                    <th class="px-4 py-3 text-center">Aksi Hapus</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 bg-white">
                                @forelse($users as $index => $user)
                                @php
                                    $roleBadge = match($user->role) {
                                        'admin_master' => 'bg-amber-100 text-amber-800 border border-amber-300 font-extrabold',
                                        'admin' => 'bg-purple-100 text-purple-800 font-bold',
                                        'pegawai' => 'bg-pink-100 text-[#EC4899] font-bold',
                                        'mahasiswa' => 'bg-blue-100 text-[#3B82F6] font-bold',
                                        default => 'bg-slate-100 text-slate-700'
                                    };
                                @endphp
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="px-4 py-3 font-medium">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3 font-bold text-[#172554]">{{ $user->nama }}</td>
                                    <td class="px-4 py-3 font-mono text-slate-700">{{ $user->email }}</td>
                                    <td class="px-4 py-3">
                                        <span class="px-3 py-1 rounded-full text-xs capitalize {{ $roleBadge }}">
                                            {{ str_replace('_', ' ', $user->role) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-slate-500">{{ date('d M Y, H:i', strtotime($user->created_at)) }}</td>
                                    <td class="px-4 py-3 text-center">
                                        @if($user->id !== Auth::id())
                                            <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus user ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-rose-600 hover:text-rose-800 font-bold px-3 py-1 rounded-full hover:bg-rose-50 transition">
                                                    <i class="fa-solid fa-trash mr-1"></i>Hapus
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-slate-400 font-semibold italic">Akun Anda</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-8 text-center text-slate-400">Belum ada user terdaftar.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

</body>
</html>