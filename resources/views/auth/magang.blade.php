<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Magang - SIMPATIK</title>
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
<body class="app-background font-sans antialiased text-slate-800" x-data="{ showModal: false, selectedItem: {} }">

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
                    <a href="{{ route('admin.magang') }}" class="flex items-center space-x-3 px-4 py-3 bg-[#3B82F6] text-white rounded-full font-bold shadow-md transition">
                        <i class="fa-solid fa-user-graduate w-5"></i>
                        <span>Kelola Magang</span>
                    </a>
                    @if(Auth::user()->role === 'admin_master')
                    <a href="{{ route('admin.user') }}" class="flex items-center space-x-3 px-4 py-3 text-blue-100 hover:bg-blue-900/50 hover:text-white rounded-full font-medium transition">
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
                <h1 class="text-xl font-black text-[#172554] tracking-tight">Kelola Pendaftaran Magang</h1>
            </header>

            <div class="p-6 space-y-6 flex-1">

                @if(session('success'))
                    <div class="p-4 bg-emerald-100 border border-emerald-300 text-emerald-800 rounded-2xl text-sm flex items-center space-x-2 shadow-sm">
                        <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                @endif

                <div class="bg-card-gradient rounded-3xl p-6 space-y-4">
                    <h3 class="font-extrabold text-[#172554] text-base">Daftar Pengajuan Magang Mahasiswa</h3>

                    <div class="overflow-x-auto rounded-2xl border border-slate-200">
                        <table class="w-full text-left text-xs text-slate-600">
                            <thead class="bg-slate-100 text-[#172554] uppercase font-bold border-b border-slate-200">
                                <tr>
                                    <th class="px-4 py-3">No</th>
                                    <th class="px-4 py-3">Nama Mahasiswa</th>
                                    <th class="px-4 py-3">NIM / No HP</th>
                                    <th class="px-4 py-3">Universitas / Jurusan</th>
                                    <th class="px-4 py-3">Periode Magang</th>
                                    <th class="px-4 py-3">Surat Pengantar</th>
                                    <th class="px-4 py-3">Status</th>
                                    <th class="px-4 py-3 text-center">Verifikasi Admin</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 bg-white">
                                @forelse($magang as $index => $item)
                                @php
                                    $badgeColor = match($item->status) {
                                        'Diterima' => 'bg-emerald-100 text-emerald-800',
                                        'Ditolak' => 'bg-rose-100 text-rose-800',
                                        default => 'bg-amber-100 text-amber-800'
                                    };
                                @endphp
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="px-4 py-3 font-medium">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3 font-bold text-[#172554]">{{ $item->user->nama ?? '-' }}</td>
                                    <td class="px-4 py-3">
                                        <div class="font-mono text-slate-800 font-bold">{{ $item->nim ?? '-' }}</div>
                                        <div class="text-slate-400 text-[10px]">{{ $item->no_hp ?? '-' }}</div>
                                    </td>
                                    <td class="px-4 py-3 font-medium">{{ $item->universitas }} ({{ $item->jurusan }})</td>
                                    <td class="px-4 py-3">{{ date('d M Y', strtotime($item->tgl_mulai)) }} s.d {{ date('d M Y', strtotime($item->tgl_selesai)) }}</td>
                                    <td class="px-4 py-3">
                                        @if($item->surat_pengantar)
                                            <a href="{{ asset('storage/' . $item->surat_pengantar) }}" target="_blank" class="inline-flex items-center space-x-1 text-[#3B82F6] hover:underline font-bold">
                                                <i class="fa-solid fa-file-pdf text-rose-500"></i>
                                                <span>Lihat PDF</span>
                                            </a>
                                        @else
                                            <span class="text-slate-400">-</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="px-3 py-1 rounded-full font-bold text-xs {{ $badgeColor }}">
                                            {{ $item->status }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center">
                                        <button @click="showModal = true; selectedItem = {{ json_encode($item) }}" class="bg-gradient-to-r from-[#3B82F6] to-[#2563EB] text-white px-4 py-1.5 rounded-full text-xs font-bold shadow-md hover:shadow-lg transition flex items-center space-x-1 mx-auto">
                                            <i class="fa-solid fa-sliders"></i>
                                            <span>Kelola Verifikasi</span>
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="px-4 py-8 text-center text-slate-400">Belum ada pendaftaran magang.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <!-- MODAL VERIFIKASI MAGANG -->
    <div x-show="showModal" x-cloak class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4 z-50">
        <div class="bg-white rounded-3xl shadow-2xl max-w-lg w-full p-6 space-y-4 border border-slate-100" @click.away="showModal = false">
            <div class="flex justify-between items-center border-b pb-3">
                <h3 class="font-black text-[#172554] text-base">Verifikasi Pendaftaran Magang</h3>
                <button @click="showModal = false" class="text-slate-400 hover:text-slate-600">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form :action="'{{ url('/admin/magang') }}/' + selectedItem.id + '/status'" method="POST" enctype="multipart/form-data" class="space-y-4 text-xs">
                @csrf
                
                <div>
                    <label class="block font-bold text-[#172554] mb-1">Status Keputusan</label>
                    <select name="status" x-model="selectedItem.status" class="w-full border border-slate-300 rounded-xl p-2.5 focus:ring-2 focus:ring-[#3B82F6] text-sm font-semibold">
                        <option value="Menunggu">Menunggu Verifikasi</option>
                        <option value="Diterima">Diterima</option>
                        <option value="Ditolak">Ditolak (Otomatis Hapus Data dari DB)</option>
                    </select>
                    <p class="text-[11px] text-rose-500 mt-1 font-medium" x-show="selectedItem.status === 'Ditolak'">
                        <i class="fa-solid fa-triangle-exclamation mr-1"></i> Data pengajuan & berkas akan otomatis dihapus permanen dari database saat ditolak.
                    </p>
                </div>

                <div>
                    <label class="block font-bold text-[#172554] mb-1">Nomor Surat Balasan (Opsional)</label>
                    <input type="text" name="no_surat" placeholder="Contoh: 800/DISKOMINFO/102/2026" class="w-full border border-slate-300 rounded-xl p-2.5 focus:ring-2 focus:ring-[#3B82F6]">
                </div>

                <div>
                    <label class="block font-bold text-[#172554] mb-1">Upload Berkas Surat Balasan (PDF, Maks 2MB)</label>
                    <input type="file" name="file_surat_balasan" accept=".pdf" class="w-full text-slate-500 file:mr-4 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-[#3B82F6] hover:file:bg-blue-100 border border-slate-300 rounded-xl cursor-pointer">
                    <p class="text-[10px] text-slate-400 mt-1">Surat balasan resmi dari Diskominfo yang nantinya dapat diunduh mahasiswa.</p>
                </div>

                <div>
                    <label class="block font-bold text-[#172554] mb-1">Catatan Admin (Opsional)</label>
                    <textarea name="catatan_admin" rows="2" placeholder="Tuliskan catatan tambahan..." class="w-full border border-slate-300 rounded-xl p-2.5 focus:ring-2 focus:ring-[#3B82F6]"></textarea>
                </div>

                <div class="flex justify-end space-x-2 pt-3 border-t border-slate-100">
                    <button type="button" @click="showModal = false" class="px-5 py-2.5 bg-slate-200 text-slate-700 rounded-full font-bold">Batal</button>
                    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-[#3B82F6] to-[#2563EB] text-white rounded-full font-bold shadow-md hover:shadow-lg">Simpan Keputusan</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>