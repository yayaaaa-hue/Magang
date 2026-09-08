<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Pegawai - SIMPATIK</title>
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
            background: linear-gradient(145deg, #FFFFFF 0%, rgba(255, 255, 255, 0.94) 100%) !important;
            border: 1px solid rgba(147, 197, 253, 0.35);
            box-shadow: 0 10px 30px -5px rgba(23, 37, 84, 0.08), 0 4px 12px -2px rgba(23, 37, 84, 0.04);
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
                        <i class="fa-solid fa-handshake-angle text-lg"></i>
                    </div>
                    <div>
                        <h2 class="font-bold text-base leading-tight text-white">Portal Pegawai</h2>
                        <span class="text-xs text-blue-200">Pemkab Bonebol</span>
                    </div>
                </div>

                <nav class="mt-6 space-y-1.5">
                    <a href="{{ route('pegawai.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 bg-[#3B82F6] text-white rounded-full font-bold shadow-md transition">
                        <i class="fa-solid fa-boxes-packing w-5"></i>
                        <span>Pinjam Pakai Aset</span>
                    </a>
                </nav>
            </div>

            <div class="border-t border-blue-900/60 pt-4">
                <div class="flex items-center justify-between px-2">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-pink-100 text-[#EC4899] rounded-full flex items-center justify-center font-black shadow uppercase">
                            {{ substr(Auth::user()->nama ?? 'P', 0, 1) }}
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-white truncate max-w-[110px]">{{ Auth::user()->nama ?? 'Pegawai' }}</p>
                            <p class="text-xs text-blue-200">Pegawai Bonebol</p>
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
                <h1 class="text-xl font-black text-[#172554] tracking-tight">Pinjam Pakai Aset Pemkab Bone Bolango</h1>
                <span class="text-xs font-bold px-3 py-1 bg-amber-100 text-amber-800 rounded-full">
                    {{ Auth::user()->instansi_bidang ?? 'Pegawai Pemkab' }}
                </span>
            </header>

            <div class="p-6 space-y-6 flex-1">

                @if(session('success'))
                    <div class="bg-emerald-100 border border-emerald-300 text-emerald-800 px-4 py-3 rounded-2xl flex items-center space-x-3 text-sm shadow-sm">
                        <i class="fa-solid fa-circle-check text-emerald-600 text-lg"></i>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-rose-100 border border-rose-300 text-rose-800 px-4 py-3 rounded-2xl flex items-center space-x-3 text-sm shadow-sm">
                        <i class="fa-solid fa-circle-exclamation text-rose-600 text-lg"></i>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="p-4 bg-rose-50 border border-rose-200 text-rose-700 text-xs rounded-2xl">
                        <ul class="list-disc pl-4 space-y-1 font-medium">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- 1. Katalog Aset yang Tersedia -->
                <div class="bg-card-gradient rounded-3xl p-6">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-slate-100 pb-4">
                        <div>
                            <h3 class="font-bold text-[#172554] text-lg">Daftar Aset Tersedia</h3>
                            <p class="text-xs text-slate-500">Hanya menampilkan aset dengan status ketersediaan <span class="text-emerald-600 font-bold">Tersedia</span>.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                        @forelse($asetTersedia as $aset)
                        <div class="border border-slate-200/80 rounded-2xl p-4 hover:border-[#3B82F6] hover:shadow-md transition bg-white/90 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">{{ $aset->merek_tipe ?? 'Peralatan' }}</span>
                                    <span class="bg-emerald-100 text-emerald-800 text-[10px] font-bold px-2 py-0.5 rounded-full border border-emerald-200">Tersedia</span>
                                </div>
                                <h4 class="font-bold text-[#172554] text-sm">{{ $aset->jenis_barang }}</h4>
                                <p class="text-xs text-[#3B82F6] mt-1 font-mono font-bold">No Reg: {{ $aset->no_reg_pemda }}</p>
                                <p class="text-xs text-slate-600 mt-2 font-medium">Kondisi: {{ $aset->kondisi ?? 'Baik' }}</p>
                                @if($aset->keterangan_lokasi_unit)
                                    <p class="text-[11px] text-slate-400 mt-1"><i class="fa-solid fa-location-dot mr-1"></i>{{ $aset->keterangan_lokasi_unit }}</p>
                                @endif
                            </div>
                        </div>
                        @empty
                        <div class="col-span-3 text-center py-6 text-slate-400 text-sm">
                            Tidak ada barang/aset yang tersedia saat ini.
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- 2. Form Permohonan Pinjam Pakai -->
                <div class="bg-card-gradient rounded-3xl border border-slate-200/80 shadow-xl overflow-hidden">
                    <div class="p-5 border-b border-slate-200 bg-slate-50/80">
                        <h3 class="font-bold text-[#172554] text-base">Form Permohonan Pinjam Pakai Aset</h3>
                        <p class="text-xs text-slate-500">Pilih aset yang tersedia dan tentukan durasi pengajuan peminjaman.</p>
                    </div>

                    <form action="{{ route('pegawai.peminjaman.store') }}" method="POST" class="p-6 space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label class="block text-xs font-semibold text-[#172554] mb-1">Pilih Barang / Aset Tersedia</label>
                                <select name="aset_id" class="w-full px-3 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-[#3B82F6]" required>
                                    <option value="">-- Pilih Barang yang Tersedia --</option>
                                    @foreach($asetTersedia as $aset)
                                        <option value="{{ $aset->no_reg_pemda }}">
                                            {{ $aset->jenis_barang }} ({{ $aset->merek_tipe }} - Reg: {{ $aset->no_reg_pemda }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-xs font-semibold text-[#172554] mb-1">Keperluan / Keterangan Penggunaan</label>
                                <textarea name="keperluan" rows="3" placeholder="Jelaskan keperluan peminjaman barang..." class="w-full px-3 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-[#3B82F6]" required></textarea>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-[#172554] mb-1">Tanggal Mulai Pinjam</label>
                                <input type="date" name="tgl_pinjam" class="w-full px-3 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-[#3B82F6]" required>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-[#172554] mb-1">Tanggal Pengembalian</label>
                                <input type="date" name="tgl_kembali" class="w-full px-3 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-[#3B82F6]" required>
                            </div>
                        </div>

                        <div class="flex justify-end pt-4 border-t border-slate-100">
                            <button type="submit" class="bg-gradient-to-r from-[#3B82F6] to-[#2563EB] hover:from-blue-600 hover:to-blue-800 text-white px-6 py-2.5 rounded-full text-sm font-bold flex items-center space-x-2 transition shadow-md">
                                <i class="fa-solid fa-paper-plane"></i>
                                <span>Kirim Permohonan</span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- 3. Riwayat Pengajuan Pegawai -->
                <div class="bg-card-gradient rounded-3xl overflow-hidden">
                    <div class="p-5 border-b border-slate-200">
                        <h3 class="font-bold text-[#172554] text-base">Riwayat Pengajuan Peminjaman Aset Saya</h3>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs text-slate-600">
                            <thead class="bg-slate-100 text-[#172554] uppercase font-bold border-b border-slate-200">
                                <tr>
                                    <th class="px-4 py-3">No</th>
                                    <th class="px-4 py-3">Barang / Aset</th>
                                    <th class="px-4 py-3">Keperluan</th>
                                    <th class="px-4 py-3">Tgl Pinjam</th>
                                    <th class="px-4 py-3">Tgl Kembali</th>
                                    <th class="px-4 py-3">Status</th>
                                    <th class="px-4 py-3">Catatan Admin</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 bg-white">
                                @forelse($riwayatSaya as $index => $row)
                                @php
                                    $badge = match($row->status) {
                                        'Disetujui' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                                        'Ditolak' => 'bg-rose-100 text-rose-800 border-rose-200',
                                        'Dikembalikan' => 'bg-slate-100 text-slate-700 border-slate-200',
                                        default => 'bg-amber-100 text-amber-800 border-amber-200'
                                    };
                                @endphp
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="px-4 py-3 font-medium">{{ $index + 1 }}</td>
                                    <td class="px-4 py-3 font-bold text-[#172554]">{{ $row->aset->jenis_barang ?? '-' }}</td>
                                    <td class="px-4 py-3">{{ $row->keperluan }}</td>
                                    <td class="px-4 py-3">{{ date('d M Y', strtotime($row->tgl_pinjam)) }}</td>
                                    <td class="px-4 py-3">{{ date('d M Y', strtotime($row->tgl_kembali)) }}</td>
                                    <td class="px-4 py-3">
                                        <span class="{{ $badge }} px-2.5 py-1 rounded-full font-bold text-xs border">
                                            {{ $row->status }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-slate-500 font-italics">{{ $row->catatan_admin ?? '-' }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-6 text-center text-slate-400">Belum ada riwayat peminjaman.</td>
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