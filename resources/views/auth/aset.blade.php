<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Aset - SIMPATIK</title>
    <!-- Plus Jakarta Sans Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
        .bg-card-gradient, .card-soft {
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.96) 0%, rgba(239, 246, 255, 0.65) 50%, rgba(253, 242, 248, 0.65) 100%) !important;
            border: 1px solid rgba(147, 197, 253, 0.45);
            border-radius: 1.5rem;
            box-shadow: 0 10px 25px -5px rgba(23, 37, 84, 0.07), 0 4px 12px -2px rgba(23, 37, 84, 0.03);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .card-interactive:hover {
            transform: translateY(-3px);
            box-shadow: 0 16px 32px -6px rgba(59, 130, 246, 0.15), 0 8px 16px -4px rgba(236, 72, 153, 0.1);
            border-color: rgba(59, 130, 246, 0.6);
        }
        .bg-modal-gradient {
            background: linear-gradient(145deg, #FFFFFF 0%, rgba(239, 246, 255, 0.95) 50%, rgba(253, 242, 248, 0.95) 100%) !important;
            border-radius: 1.5rem;
            border: 1px solid rgba(147, 197, 253, 0.45);
            box-shadow: 0 25px 50px -12px rgba(23, 37, 84, 0.25);
        }
        .bg-header-gradient {
            background: linear-gradient(90deg, rgba(255, 255, 255, 0.94) 0%, rgba(255, 255, 255, 0.88) 100%) !important;
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(147, 197, 253, 0.35);
        }
        .form-input {
            width: 100% !important;
            height: 2.625rem !important;
            box-sizing: border-box !important;
            padding: 0.625rem 0.875rem !important;
            font-size: 0.875rem !important;
            font-weight: 500 !important;
            line-height: 1.25rem !important;
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
    </style>
</head>
<body class="app-background font-sans antialiased text-slate-800" x-data="{ activeTab: '{{ request()->has('filter_bulan') || request()->has('filter_tahun') ? 'laporan' : 'master' }}', showAddModal: false, showEditModal: false, showQrModal: false, editItem: {}, qrItem: {} }">

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
                    <a href="{{ route('admin.aset') }}" class="flex items-center space-x-3 px-4 py-3 bg-[#3B82F6] text-white rounded-full font-bold shadow-md transition">
                        <i class="fa-solid fa-boxes-stacked w-5"></i>
                        <span>Manajemen Aset</span>
                    </a>
                    <a href="{{ route('admin.magang') }}" class="flex items-center space-x-3 px-4 py-3 text-blue-100 hover:bg-blue-900/50 hover:text-white rounded-full font-medium transition">
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
                <h1 class="text-xl font-black text-[#172554] tracking-tight">Manajemen Aset & Peralatan Mesin</h1>
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

                @if($errors->any())
                    <div class="p-4 bg-rose-100 border border-rose-300 text-rose-800 rounded-2xl text-sm space-y-1 shadow-sm">
                        <div class="flex items-center space-x-2 font-bold">
                            <i class="fa-solid fa-triangle-exclamation text-rose-600 text-lg"></i>
                            <span>Terdapat Kesalahan Input:</span>
                        </div>
                        <ul class="list-disc list-inside text-xs pl-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Sub-Menu Tabs Navigation (Pill styled tabs) -->
                <div class="flex bg-white/90 p-1.5 rounded-full border border-slate-200 shadow-sm flex-wrap gap-1 max-w-fit">
                    <button @click="activeTab = 'master'" :class="activeTab === 'master' ? 'bg-[#3B82F6] text-white font-extrabold shadow-md' : 'text-slate-600 hover:text-[#172554] font-medium'" class="py-2.5 px-5 rounded-full text-xs transition flex items-center space-x-2">
                        <i class="fa-solid fa-database"></i>
                        <span>Master Data Aset</span>
                    </button>
                    <button @click="activeTab = 'persetujuan'" :class="activeTab === 'persetujuan' ? 'bg-[#3B82F6] text-white font-extrabold shadow-md' : 'text-slate-600 hover:text-[#172554] font-medium'" class="py-2.5 px-5 rounded-full text-xs transition flex items-center space-x-2">
                        <i class="fa-solid fa-file-signature"></i>
                        <span>Persetujuan Pinjam Pakai</span>
                    </button>
                    <button @click="activeTab = 'laporan'" :class="activeTab === 'laporan' ? 'bg-gradient-to-r from-[#3B82F6] to-[#EC4899] text-white font-extrabold shadow-md' : 'text-slate-600 hover:text-[#172554] font-medium'" class="py-2.5 px-5 rounded-full text-xs transition flex items-center space-x-2">
                        <i class="fa-solid fa-chart-pie"></i>
                        <span>Laporan Rekap Bulanan</span>
                    </button>
                </div>

                <!-- TAB 1: MASTER DATA ASET -->
                <div x-show="activeTab === 'master'" class="bg-card-gradient rounded-3xl p-6 space-y-4">
                    <div class="flex justify-between items-center flex-wrap gap-2 border-b border-blue-100/80 pb-4">
                        <div>
                            <h3 class="font-extrabold text-[#172554] text-base flex items-center space-x-2">
                                <div class="w-8 h-8 rounded-full bg-blue-100 text-[#3B82F6] flex items-center justify-center">
                                    <i class="fa-solid fa-boxes-stacked text-xs"></i>
                                </div>
                                <span>Pendataan Aset Peralatan dan Mesin Diskominfo</span>
                            </h3>
                            <p class="text-xs text-slate-500 mt-1">Kelola data seluruh aset, generate QR code, dan perbarui data perolehan.</p>
                        </div>
                        <button @click="showAddModal = true" class="bg-gradient-to-r from-[#3B82F6] to-[#EC4899] hover:from-blue-600 hover:to-pink-600 text-white text-xs px-5 py-2.5 rounded-full font-bold flex items-center space-x-2 shadow-lg transition transform hover:-translate-y-0.5">
                            <i class="fa-solid fa-plus"></i>
                            <span>Tambah Aset Baru</span>
                        </button>
                    </div>

                    <!-- Tabel Master Data Aset Wrapper dengan Gradasi & Soft Shadow -->
                    <div class="overflow-x-auto rounded-2xl border border-blue-200/60 shadow-sm bg-white/80 backdrop-blur-md">
                        <table class="w-full text-left text-[11px] text-slate-600 whitespace-nowrap">
                            <thead class="bg-gradient-to-r from-blue-100/90 to-pink-100/90 text-[#172554] uppercase font-black border-b border-blue-200">
                                <tr>
                                    <th class="px-3 py-3.5 text-center">No</th>
                                    <th class="px-3 py-3.5">Penanggung Jawab</th>
                                    <th class="px-3 py-3.5">Jenis Barang</th>
                                    <th class="px-3 py-3.5">No Reg/ID Pemda</th>
                                    <th class="px-3 py-3.5">Merek/Tipe</th>
                                    <th class="px-3 py-3.5">Tahun</th>
                                    <th class="px-3 py-3.5">Harga Perolehan (Rp)</th>
                                    <th class="px-3 py-3.5">Nomor Rangka/Seri</th>
                                    <th class="px-3 py-3.5">Nomor Mesin</th>
                                    <th class="px-3 py-3.5">Nomor Polisi</th>
                                    <th class="px-3 py-3.5">Nomor BPKB</th>
                                    <th class="px-3 py-3.5">Kondisi Aset</th>
                                    <th class="px-3 py-3.5">Keterangan Unit Lokasi</th>
                                    <th class="px-3 py-3.5">No. SK/BAST/Pinjam Pakai</th>
                                    <th class="px-3 py-3.5 text-center">QR Code & Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 bg-white/90">
                                @forelse($aset as $index => $item)
                                @php
                                    $badgeColor = match($item->kondisi ?? 'Baik') {
                                        'Baik' => 'bg-emerald-100 text-emerald-800',
                                        'Rusak Ringan' => 'bg-amber-100 text-amber-800',
                                        'Rusak Berat', 'Hilang' => 'bg-rose-100 text-rose-800',
                                        default => 'bg-slate-100 text-slate-700'
                                    };
                                    $regId = $item->no_reg_pemda ?? 'REG-' . $loop->iteration;
                                @endphp
                                <tr class="hover:bg-blue-50/50 transition">
                                    <td class="px-3 py-3 text-center font-medium">{{ $loop->iteration }}</td>
                                    <td class="px-3 py-3 font-bold text-[#172554]">{{ $item->penanggung_jawab ?? '-' }}</td>
                                    <td class="px-3 py-3 font-semibold text-slate-800">{{ $item->jenis_barang ?? '-' }}</td>
                                    <td class="px-3 py-3 font-mono text-[#3B82F6] font-bold">{{ $regId }}</td>
                                    <td class="px-3 py-3">{{ $item->merek_tipe ?? '-' }}</td>
                                    <td class="px-3 py-3">{{ $item->tahun ?? '-' }}</td>
                                    <td class="px-3 py-3 font-mono font-semibold">Rp {{ number_format($item->harga_perolehan ?? 0, 0, ',', '.') }}</td>
                                    <td class="px-3 py-3 font-mono text-slate-600">{{ $item->no_rangka_seri ?: '-' }}</td>
                                    <td class="px-3 py-3 font-mono text-slate-600">{{ $item->no_mesin ?: '-' }}</td>
                                    <td class="px-3 py-3 font-mono text-slate-600">{{ $item->no_polisi ?: '-' }}</td>
                                    <td class="px-3 py-3 font-mono text-slate-600">{{ $item->no_bpkb ?: '-' }}</td>
                                    <td class="px-3 py-3">
                                        <span class="px-2.5 py-0.5 rounded-full font-bold {{ $badgeColor }}">
                                            {{ $item->kondisi ?? 'Baik' }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-3">{{ $item->keterangan_lokasi_unit ?? '-' }}</td>
                                    <td class="px-3 py-3">{{ $item->no_sk_bast ?? '-' }}</td>
                                    <td class="px-3 py-3 text-center">
                                        <div class="flex items-center justify-center space-x-1.5">
                                            <!-- QR Modal Trigger -->
                                            <button @click="showQrModal = true; qrItem = { id: '{{ addslashes($regId) }}', jenis: '{{ addslashes($item->jenis_barang ?? '-') }}', penanggung: '{{ addslashes($item->penanggung_jawab ?? '-') }}', merek: '{{ addslashes($item->merek_tipe ?? '-') }}', url: '{{ route('aset.public_detail', ['id' => $regId]) }}' }" class="bg-pink-100 hover:bg-[#EC4899] text-[#EC4899] hover:text-white font-extrabold px-3 py-1 rounded-full transition flex items-center space-x-1 text-[10px] shadow-sm">
                                                <i class="fa-solid fa-qrcode"></i>
                                                <span>QR</span>
                                            </button>
                                            <!-- Edit Modal Trigger -->
                                            <button @click="showEditModal = true; editItem = {{ json_encode($item) }}; formatEditHarga();" class="text-[#3B82F6] hover:text-blue-800 font-bold px-2 py-1 rounded-full hover:bg-blue-50 transition">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>
                                            <!-- Delete Form Trigger -->
                                            <form action="{{ route('admin.aset.destroy', ['no_reg_pemda' => $regId]) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus aset ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-rose-600 hover:text-rose-800 font-bold px-2 py-1 rounded-full hover:bg-rose-50 transition">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="15" class="px-4 py-8 text-center text-slate-400">Belum ada data aset terdaftar.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- TAB 2: PERSETUJUAN PINJAM PAKAI -->
                <div x-show="activeTab === 'persetujuan'" x-cloak class="bg-card-gradient rounded-3xl p-6 space-y-4">
                    <div>
                        <h3 class="font-extrabold text-[#172554] text-base">Daftar Permohonan Pinjam Pakai Pegawai</h3>
                    </div>

                    <div class="overflow-x-auto rounded-2xl border border-slate-200">
                        <table class="w-full text-left text-xs text-slate-600">
                            <thead class="bg-slate-100 text-[#172554] uppercase font-bold border-b border-slate-200">
                                <tr>
                                    <th class="px-4 py-3">No</th>
                                    <th class="px-4 py-3">Pegawai Pemohon</th>
                                    <th class="px-4 py-3">Barang Diajukan</th>
                                    <th class="px-4 py-3">Keperluan</th>
                                    <th class="px-4 py-3">Tanggal Pinjam - Kembali</th>
                                    <th class="px-4 py-3">Status</th>
                                    <th class="px-4 py-3 text-center">Aksi Verifikasi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 bg-white">
                                @forelse($peminjaman as $index => $pinjam)
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="px-4 py-3 font-medium">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-3 font-bold text-[#172554]">{{ $pinjam->user->nama ?? '-' }}</td>
                                    <td class="px-4 py-3 font-semibold text-[#3B82F6]">{{ $pinjam->aset->jenis_barang ?? '-' }} ({{ $pinjam->aset_id }})</td>
                                    <td class="px-4 py-3">{{ $pinjam->keperluan }}</td>
                                    <td class="px-4 py-3">{{ date('d M Y', strtotime($pinjam->tgl_pinjam)) }} s.d {{ date('d M Y', strtotime($pinjam->tgl_kembali)) }}</td>
                                    <td class="px-4 py-3">
                                        <span class="px-3 py-1 rounded-full font-bold text-xs {{ $pinjam->status === 'Disetujui' ? 'bg-emerald-100 text-emerald-800' : ($pinjam->status === 'Ditolak' ? 'bg-rose-100 text-rose-800' : ($pinjam->status === 'Dikembalikan' ? 'bg-slate-100 text-slate-700' : 'bg-amber-100 text-amber-800')) }}">
                                            {{ $pinjam->status }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-center space-x-1">
                                        @if($pinjam->status === 'Menunggu')
                                            <form action="{{ route('admin.peminjaman.update', $pinjam->id) }}" method="POST" class="inline">
                                                @csrf
                                                <input type="hidden" name="status" value="Disetujui">
                                                <button type="submit" class="bg-emerald-600 text-white px-3 py-1.5 rounded-full hover:bg-emerald-700 font-bold text-[11px] shadow-sm">
                                                    <i class="fa-solid fa-check mr-1"></i>Setujui
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.peminjaman.update', $pinjam->id) }}" method="POST" class="inline">
                                                @csrf
                                                <input type="hidden" name="status" value="Ditolak">
                                                <button type="submit" class="bg-rose-600 text-white px-3 py-1.5 rounded-full hover:bg-rose-700 font-bold text-[11px] shadow-sm">
                                                    <i class="fa-solid fa-xmark mr-1"></i>Tolak
                                                </button>
                                            </form>
                                        @elseif($pinjam->status === 'Disetujui')
                                            <form action="{{ route('admin.peminjaman.update', $pinjam->id) }}" method="POST" class="inline">
                                                @csrf
                                                <input type="hidden" name="status" value="Dikembalikan">
                                                <button type="submit" class="bg-[#3B82F6] text-white px-3 py-1.5 rounded-full hover:bg-blue-700 font-bold text-[11px] shadow-sm">
                                                    <i class="fa-solid fa-arrow-rotate-left mr-1"></i>Tandai Dikembalikan
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-slate-400 font-medium">Selesai</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-6 text-center text-slate-400">Belum ada pengajuan peminjaman.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- TAB 3: LAPORAN REKAP BULANAN -->
                <div x-show="activeTab === 'laporan'" x-cloak class="bg-card-gradient rounded-3xl p-6 space-y-6">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div>
                            <h3 class="font-black text-[#172554] text-lg">Laporan Rekap Kondisi Barang Bulanan</h3>
                            <p class="text-xs text-slate-500">Ringkasan statistik, diagram visualisasi data, dan rekapitulasi aset berdasarkan periode bulan/tahun.</p>
                        </div>

                        <!-- Filter Form & Export PDF -->
                        <form action="{{ route('admin.aset') }}" method="GET" class="flex flex-wrap items-center gap-2 bg-slate-50 p-2.5 rounded-full border border-slate-200">
                            <div>
                                <select name="filter_bulan" class="text-xs border border-slate-300 rounded-full px-3 py-1.5 bg-white focus:ring-2 focus:ring-[#3B82F6] font-semibold text-[#172554]">
                                    <option value="all" {{ $filterBulan === 'all' ? 'selected' : '' }}>Semua Bulan</option>
                                    <option value="1" {{ $filterBulan == '1' ? 'selected' : '' }}>Januari</option>
                                    <option value="2" {{ $filterBulan == '2' ? 'selected' : '' }}>Februari</option>
                                    <option value="3" {{ $filterBulan == '3' ? 'selected' : '' }}>Maret</option>
                                    <option value="4" {{ $filterBulan == '4' ? 'selected' : '' }}>April</option>
                                    <option value="5" {{ $filterBulan == '5' ? 'selected' : '' }}>Mei</option>
                                    <option value="6" {{ $filterBulan == '6' ? 'selected' : '' }}>Juni</option>
                                    <option value="7" {{ $filterBulan == '7' ? 'selected' : '' }}>Juli</option>
                                    <option value="8" {{ $filterBulan == '8' ? 'selected' : '' }}>Agustus</option>
                                    <option value="9" {{ $filterBulan == '9' ? 'selected' : '' }}>September</option>
                                    <option value="10" {{ $filterBulan == '10' ? 'selected' : '' }}>Oktober</option>
                                    <option value="11" {{ $filterBulan == '11' ? 'selected' : '' }}>November</option>
                                    <option value="12" {{ $filterBulan == '12' ? 'selected' : '' }}>Desember</option>
                                </select>
                            </div>
                            <div>
                                <select name="filter_tahun" class="text-xs border border-slate-300 rounded-full px-3 py-1.5 bg-white focus:ring-2 focus:ring-[#3B82F6] font-semibold text-[#172554]">
                                    <option value="all" {{ $filterTahun === 'all' ? 'selected' : '' }}>Semua Tahun</option>
                                    @for($y = date('Y'); $y >= 2020; $y--)
                                        <option value="{{ $y }}" {{ $filterTahun == $y ? 'selected' : '' }}>{{ $y }}</option>
                                    @endfor
                                </select>
                            </div>
                            <button type="submit" class="bg-[#3B82F6] hover:bg-blue-700 text-white text-xs px-4 py-1.5 rounded-full font-bold flex items-center space-x-1 shadow-sm transition">
                                <i class="fa-solid fa-filter"></i>
                                <span>Filter</span>
                            </button>
                            <a href="{{ route('admin.aset.laporan.pdf', ['filter_bulan' => $filterBulan, 'filter_tahun' => $filterTahun]) }}" target="_blank" class="bg-[#EC4899] hover:bg-pink-600 text-white text-xs px-4 py-1.5 rounded-full font-bold flex items-center space-x-1 shadow-sm transition">
                                <i class="fa-solid fa-file-pdf"></i>
                                <span>Export PDF</span>
                            </a>
                        </form>
                    </div>

                    <!-- Interactive Visual Summary Cards -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
                        <div class="p-5 rounded-3xl bg-blue-50/80 border border-blue-200/80 shadow-sm card-interactive flex flex-col justify-between">
                            <div class="flex items-center justify-between text-[#3B82F6]">
                                <span class="text-xs font-extrabold uppercase tracking-wider text-slate-600">Total Aset</span>
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                                    <i class="fa-solid fa-boxes-stacked text-sm"></i>
                                </div>
                            </div>
                            <p class="text-3xl font-black text-[#172554] mt-2">{{ $rekapKondisi['Total'] }}</p>
                        </div>

                        <div class="p-5 rounded-3xl bg-emerald-50/80 border border-emerald-200/80 shadow-sm card-interactive flex flex-col justify-between">
                            <div class="flex items-center justify-between text-emerald-600">
                                <span class="text-xs font-extrabold uppercase tracking-wider text-slate-600">Baik</span>
                                <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center">
                                    <i class="fa-solid fa-circle-check text-sm"></i>
                                </div>
                            </div>
                            <p class="text-3xl font-black text-emerald-700 mt-2">{{ $rekapKondisi['Baik'] }}</p>
                        </div>

                        <div class="p-5 rounded-3xl bg-amber-50/80 border border-amber-200/80 shadow-sm card-interactive flex flex-col justify-between">
                            <div class="flex items-center justify-between text-amber-600">
                                <span class="text-xs font-extrabold uppercase tracking-wider text-slate-600">Rusak Ringan</span>
                                <div class="w-8 h-8 rounded-full bg-amber-100 flex items-center justify-center">
                                    <i class="fa-solid fa-triangle-exclamation text-sm"></i>
                                </div>
                            </div>
                            <p class="text-3xl font-black text-amber-700 mt-2">{{ $rekapKondisi['Rusak Ringan'] }}</p>
                        </div>

                        <div class="p-5 rounded-3xl bg-rose-50/80 border border-rose-200/80 shadow-sm card-interactive flex flex-col justify-between">
                            <div class="flex items-center justify-between text-rose-600">
                                <span class="text-xs font-extrabold uppercase tracking-wider text-slate-600">Rusak Berat</span>
                                <div class="w-8 h-8 rounded-full bg-rose-100 flex items-center justify-center">
                                    <i class="fa-solid fa-circle-xmark text-sm"></i>
                                </div>
                            </div>
                            <p class="text-3xl font-black text-rose-700 mt-2">{{ $rekapKondisi['Rusak Berat'] }}</p>
                        </div>

                        <div class="p-5 rounded-3xl bg-slate-100/80 border border-slate-300/80 shadow-sm card-interactive flex flex-col justify-between col-span-2 sm:col-span-1">
                            <div class="flex items-center justify-between text-slate-600">
                                <span class="text-xs font-extrabold uppercase tracking-wider text-slate-600">Hilang</span>
                                <div class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center">
                                    <i class="fa-solid fa-ghost text-sm"></i>
                                </div>
                            </div>
                            <p class="text-3xl font-black text-slate-800 mt-2">{{ $rekapKondisi['Hilang'] }}</p>
                        </div>
                    </div>

                    <!-- Visual Statistics Chart Grid -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 pt-2">
                        <div class="bg-white/90 p-5 rounded-3xl border border-slate-200/80 shadow-sm space-y-3">
                            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                                <h4 class="font-extrabold text-[#172554] text-sm flex items-center space-x-2">
                                    <div class="w-7 h-7 rounded-full bg-blue-100 text-[#3B82F6] flex items-center justify-center">
                                        <i class="fa-solid fa-chart-pie text-xs"></i>
                                    </div>
                                    <span>Persentase Kondisi Aset</span>
                                </h4>
                                <span class="text-[11px] text-slate-400 font-semibold">Statistik Visual</span>
                            </div>
                            <div class="relative h-60 flex items-center justify-center">
                                <canvas id="kondisiDoughnutChart"></canvas>
                            </div>
                        </div>

                        <div class="bg-white/90 p-5 rounded-3xl border border-slate-200/80 shadow-sm space-y-3">
                            <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                                <h4 class="font-extrabold text-[#172554] text-sm flex items-center space-x-2">
                                    <div class="w-7 h-7 rounded-full bg-pink-100 text-[#EC4899] flex items-center justify-center">
                                        <i class="fa-solid fa-chart-column text-xs"></i>
                                    </div>
                                    <span>Grafik Rekapitulasi Jumlah Unit</span>
                                </h4>
                                <span class="text-[11px] text-slate-400 font-semibold">Statistik Visual</span>
                            </div>
                            <div class="relative h-60">
                                <canvas id="kondisiBarChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Tabel Rekap Aset Bulanan -->
                    <div class="overflow-x-auto rounded-2xl border border-slate-200">
                        <table class="w-full text-left text-xs text-slate-600 whitespace-nowrap">
                            <thead class="bg-slate-100 text-[#172554] uppercase font-bold border-b border-slate-200">
                                <tr>
                                    <th class="px-4 py-3 text-center">No</th>
                                    <th class="px-4 py-3">No. Reg Pemda</th>
                                    <th class="px-4 py-3">Jenis Barang</th>
                                    <th class="px-4 py-3">Merek / Tipe</th>
                                    <th class="px-4 py-3">Penanggung Jawab</th>
                                    <th class="px-4 py-3">Tahun</th>
                                    <th class="px-4 py-3">Kondisi</th>
                                    <th class="px-4 py-3">Status Ketersediaan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 bg-white">
                                @forelse($laporanAset as $index => $item)
                                @php
                                    $badgeColor = match($item->kondisi ?? 'Baik') {
                                        'Baik' => 'bg-emerald-100 text-emerald-800',
                                        'Rusak Ringan' => 'bg-amber-100 text-amber-800',
                                        'Rusak Berat', 'Hilang' => 'bg-rose-100 text-rose-800',
                                        default => 'bg-slate-100 text-slate-700'
                                    };
                                @endphp
                                <tr class="hover:bg-slate-50/80 transition">
                                    <td class="px-4 py-3 text-center font-medium">{{ $loop->iteration }}</td>
                                    <td class="px-4 py-3 font-mono font-bold text-[#3B82F6]">{{ $item->no_reg_pemda }}</td>
                                    <td class="px-4 py-3 font-semibold text-[#172554]">{{ $item->jenis_barang }}</td>
                                    <td class="px-4 py-3">{{ $item->merek_tipe }}</td>
                                    <td class="px-4 py-3 font-medium">{{ $item->penanggung_jawab ?: 'Belum Ditentukan' }}</td>
                                    <td class="px-4 py-3">{{ $item->tahun ?: '-' }}</td>
                                    <td class="px-4 py-3">
                                        <span class="px-3 py-1 rounded-full font-bold text-xs {{ $badgeColor }}">
                                            {{ $item->kondisi }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="px-3 py-1 rounded-full font-bold text-xs bg-slate-100 text-slate-700">
                                            {{ $item->status_ketersediaan }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="px-4 py-8 text-center text-slate-400">Tidak ada data aset pada periode filter ini.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <!-- MODAL QR CODE GENERATED -->
    <div x-show="showQrModal" x-cloak class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4 z-50">
        <div class="bg-modal-gradient rounded-3xl shadow-2xl max-w-sm w-full p-6 text-center space-y-4 border border-blue-200/80" @click.away="showQrModal = false">
            <div class="flex justify-between items-center border-b border-blue-100 pb-3">
                <h3 class="font-black text-[#172554] text-base flex items-center space-x-2">
                    <div class="w-7 h-7 rounded-full bg-pink-100 text-[#EC4899] flex items-center justify-center">
                        <i class="fa-solid fa-qrcode text-sm"></i>
                    </div>
                    <span>QR Code Aset</span>
                </h3>
                <button @click="showQrModal = false" class="text-slate-400 hover:text-slate-600">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <div class="bg-gradient-to-br from-blue-100/60 to-pink-100/60 p-5 rounded-3xl inline-block border border-blue-200/60 shadow-inner">
                <template x-if="qrItem.id">
                    <div class="bg-white p-3.5 rounded-2xl shadow-sm inline-block">
                        <img :src="'https://api.qrserver.com/v1/create-qr-code/?size=180x180&data=' + encodeURIComponent(qrItem.url)" alt="QR Code" class="w-44 h-44 mx-auto">
                    </div>
                </template>
            </div>

            <div class="space-y-1 text-xs">
                <span class="font-mono text-[#3B82F6] font-bold block text-sm" x-text="qrItem.id"></span>
                <p class="font-bold text-[#172554]" x-text="qrItem.jenis"></p>
                <p class="text-slate-500" x-text="'Merek: ' + qrItem.merek"></p>
                <p class="text-slate-500" x-text="'Penanggung Jawab: ' + qrItem.penanggung"></p>
            </div>

            <div class="pt-3 border-t border-slate-100 flex flex-col space-y-2">
                <a :href="qrItem.url" target="_blank" class="w-full bg-gradient-to-r from-[#3B82F6] to-[#2563EB] hover:from-blue-600 hover:to-blue-800 text-white py-2.5 rounded-full font-bold text-xs flex items-center justify-center space-x-2 shadow-md transition">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                    <span>Buka Halaman Detail Publik</span>
                </a>
                <button @click="window.print()" class="w-full bg-white hover:bg-slate-50 text-slate-700 py-2.5 rounded-full font-bold text-xs flex items-center justify-center space-x-2 transition border border-slate-200 shadow-sm">
                    <i class="fa-solid fa-print"></i>
                    <span>Cetak Label QR</span>
                </button>
            </div>
        </div>
    </div>

    <!-- MODAL TAMBAH ASET (URUTAN KOLOM FORM PERSIS DENGAN TABEL) -->
    <div x-show="showAddModal" x-cloak class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4 z-50">
        <div class="bg-modal-gradient rounded-3xl shadow-2xl max-w-2xl w-full p-6 sm:p-8 space-y-5 max-h-[90vh] overflow-y-auto border border-blue-200/80" @click.away="showAddModal = false">
            <div class="flex justify-between items-center border-b border-blue-100 pb-3">
                <h3 class="font-black text-[#172554] text-base flex items-center space-x-2">
                    <div class="w-8 h-8 rounded-full bg-blue-100 text-[#3B82F6] flex items-center justify-center shadow-sm">
                        <i class="fa-solid fa-plus text-sm"></i>
                    </div>
                    <span>Tambah Data Aset Peralatan & Mesin</span>
                </h3>
                <button @click="showAddModal = false" class="text-slate-400 hover:text-slate-600">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form action="{{ route('admin.aset.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @csrf

                <div>
                    <label class="form-label">No. Reg / ID Pemda <span class="text-rose-500">*</span></label>
                    <input type="text" name="no_reg_pemda" placeholder="Contoh: REG-2026-001 (Wajib diisi manual)" required class="form-input font-mono font-bold text-[#3B82F6]">
                </div>

                <div>
                    <label class="form-label">Penanggung Jawab <span class="text-rose-500">*</span></label>
                    <input type="text" name="penanggung_jawab" placeholder="Contoh: Ahmad Rizky" required class="form-input">
                </div>

                <div>
                    <label class="form-label">Jenis Barang <span class="text-rose-500">*</span></label>
                    <input type="text" name="jenis_barang" placeholder="Contoh: Laptop, AC, Router, Mobil, dll" required class="form-input">
                </div>

                <div>
                    <label class="form-label">Merek / Tipe Aset <span class="text-rose-500">*</span></label>
                    <input type="text" name="merek_tipe" placeholder="Contoh: Lenovo ThinkPad / Toyota Avanza" required class="form-input">
                </div>

                <div>
                    <label class="form-label">Tahun Perolehan <span class="text-rose-500">*</span></label>
                    <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="4" name="tahun" placeholder="2026" required class="form-input">
                </div>

                <div>
                    <label class="form-label">Harga Perolehan <span class="text-rose-500">*</span></label>
                    <input type="text" name="harga_perolehan" id="add_harga_perolehan" oninput="formatRupiahInput(this)" placeholder="Contoh: 15.000.000" required class="form-input font-mono">
                </div>

                <div>
                    <label class="form-label">Nomor Rangka / Nomor Seri</label>
                    <input type="text" name="no_rangka_seri" placeholder="Isi jika ada (Opsional)" class="form-input">
                </div>

                <div>
                    <label class="form-label">Nomor Mesin</label>
                    <input type="text" name="no_mesin" placeholder="Isi jika ada (Opsional)" class="form-input">
                </div>

                <div>
                    <label class="form-label">Nomor Polisi</label>
                    <input type="text" name="no_polisi" placeholder="DM 1234 AB (Opsional)" class="form-input">
                </div>

                <div>
                    <label class="form-label">Nomor BPKB</label>
                    <input type="text" name="no_bpkb" placeholder="Isi jika kendaraan dinas (Opsional)" class="form-input">
                </div>

                <div>
                    <label class="form-label">Kondisi Aset <span class="text-rose-500">*</span></label>
                    <select name="kondisi" required class="form-input font-semibold">
                        <option value="Baik">Baik</option>
                        <option value="Hilang">Hilang</option>
                        <option value="Rusak Ringan">Rusak Ringan</option>
                        <option value="Rusak Berat">Rusak Berat</option>
                    </select>
                </div>

                <div>
                    <label class="form-label">Keterangan Unit Lokasi <span class="text-rose-500">*</span></label>
                    <input type="text" name="keterangan_lokasi_unit" placeholder="Bidang E-Government" required class="form-input">
                </div>

                <div class="md:col-span-2 border-t border-slate-200/60 pt-2">
                    <label class="form-label">No. SK, BAST, Naskah Perjanjian Pinjam Pakai</label>
                    <input type="text" name="no_sk_bast" placeholder="SK/001/KOMINFO/2026" class="form-input">
                </div>

                <div class="md:col-span-2 flex justify-end space-x-2 pt-4 border-t border-blue-100 mt-2">
                    <button type="button" @click="showAddModal = false" class="px-5 py-2.5 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-full font-bold transition text-xs">Batal</button>
                    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-[#3B82F6] to-[#EC4899] hover:from-blue-600 hover:to-pink-600 text-white rounded-full font-bold hover:shadow-lg shadow-md transition text-xs">Simpan Aset Baru</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL EDIT ASET (URUTAN KOLOM FORM PERSIS DENGAN TABEL) -->
    <div x-show="showEditModal" x-cloak class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center p-4 z-50">
        <div class="bg-modal-gradient rounded-3xl shadow-2xl max-w-2xl w-full p-6 sm:p-8 space-y-5 max-h-[90vh] overflow-y-auto border border-blue-200/80" @click.away="showEditModal = false">
            <div class="flex justify-between items-center border-b border-blue-100 pb-3">
                <h3 class="font-black text-[#172554] text-base flex items-center space-x-2">
                    <div class="w-8 h-8 rounded-full bg-pink-100 text-[#EC4899] flex items-center justify-center shadow-sm">
                        <i class="fa-solid fa-pen-to-square text-sm"></i>
                    </div>
                    <span>Edit Data Aset Peralatan & Mesin</span>
                </h3>
                <button @click="showEditModal = false" class="text-slate-400 hover:text-slate-600">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <!-- Action URL Safe Encoding to Prevent 404 -->
            <form :action="'{{ url('/admin/aset') }}/' + encodeURIComponent(editItem.no_reg_pemda)" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="form-label">No. Reg / ID Pemda <span class="text-rose-500">*</span></label>
                    <input type="text" name="no_reg_pemda" x-model="editItem.no_reg_pemda" required class="form-input font-mono font-bold text-[#3B82F6]">
                </div>

                <div>
                    <label class="form-label">Penanggung Jawab <span class="text-rose-500">*</span></label>
                    <input type="text" name="penanggung_jawab" x-model="editItem.penanggung_jawab" required class="form-input">
                </div>

                <div>
                    <label class="form-label">Jenis Barang <span class="text-rose-500">*</span></label>
                    <input type="text" name="jenis_barang" x-model="editItem.jenis_barang" required class="form-input">
                </div>

                <div>
                    <label class="form-label">Merek / Tipe Aset <span class="text-rose-500">*</span></label>
                    <input type="text" name="merek_tipe" x-model="editItem.merek_tipe" required class="form-input">
                </div>

                <div>
                    <label class="form-label">Tahun Perolehan <span class="text-rose-500">*</span></label>
                    <input type="text" inputmode="numeric" pattern="[0-9]*" maxlength="4" name="tahun" x-model="editItem.tahun" required class="form-input">
                </div>

                <div>
                    <label class="form-label">Harga Perolehan <span class="text-rose-500">*</span></label>
                    <input type="text" name="harga_perolehan" id="edit_harga_perolehan" x-model="editItem.harga_perolehan" oninput="formatRupiahInput(this)" placeholder="Contoh: 15.000.000" required class="form-input font-mono">
                </div>

                <div>
                    <label class="form-label">Nomor Rangka / Nomor Seri</label>
                    <input type="text" name="no_rangka_seri" x-model="editItem.no_rangka_seri" class="form-input">
                </div>

                <div>
                    <label class="form-label">Nomor Mesin</label>
                    <input type="text" name="no_mesin" x-model="editItem.no_mesin" class="form-input">
                </div>

                <div>
                    <label class="form-label">Nomor Polisi</label>
                    <input type="text" name="no_polisi" x-model="editItem.no_polisi" class="form-input">
                </div>

                <div>
                    <label class="form-label">Nomor BPKB</label>
                    <input type="text" name="no_bpkb" x-model="editItem.no_bpkb" class="form-input">
                </div>

                <div>
                    <label class="form-label">Kondisi Aset <span class="text-rose-500">*</span></label>
                    <select name="kondisi" x-model="editItem.kondisi" required class="form-input font-semibold">
                        <option value="Baik">Baik</option>
                        <option value="Hilang">Hilang</option>
                        <option value="Rusak Ringan">Rusak Ringan</option>
                        <option value="Rusak Berat">Rusak Berat</option>
                    </select>
                </div>

                <div>
                    <label class="form-label">Status Ketersediaan <span class="text-rose-500">*</span></label>
                    <select name="status_ketersediaan" x-model="editItem.status_ketersediaan" required class="form-input font-semibold">
                        <option value="Tersedia">Tersedia</option>
                        <option value="Dipinjam">Dipinjam</option>
                        <option value="Perbaikan">Perbaikan</option>
                    </select>
                </div>

                <div>
                    <label class="form-label">Keterangan Unit Lokasi <span class="text-rose-500">*</span></label>
                    <input type="text" name="keterangan_lokasi_unit" x-model="editItem.keterangan_lokasi_unit" required class="form-input">
                </div>

                <div>
                    <label class="form-label">No. SK, BAST, Naskah Pinjam Pakai</label>
                    <input type="text" name="no_sk_bast" x-model="editItem.no_sk_bast" class="form-input">
                </div>

                <div class="md:col-span-2 flex justify-end space-x-2 pt-4 border-t border-blue-100 mt-2">
                    <button type="button" @click="showEditModal = false" class="px-5 py-2.5 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-full font-bold transition text-xs">Batal</button>
                    <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-[#3B82F6] to-[#EC4899] hover:from-blue-600 hover:to-pink-600 text-white rounded-full font-bold hover:shadow-lg shadow-md transition text-xs">Perbarui Data Aset</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Script Formatter & Chart.js Initialization -->
    <script>
        function formatRupiahInput(input) {
            if (!input) return;
            let value = String(input.value || "").replace(/\D/g, "");
            if (value) {
                let num = parseInt(value, 10);
                if (num > 999000000) {
                    num = 999000000;
                }
                input.value = new Intl.NumberFormat('id-ID').format(num);
            } else {
                input.value = "";
            }
        }

        function formatEditHarga() {
            setTimeout(() => {
                const el = document.getElementById('edit_harga_perolehan');
                if (el) formatRupiahInput(el);
            }, 50);
        }

        document.addEventListener("DOMContentLoaded", function () {
            const baikCount = {{ $rekapKondisi['Baik'] ?? 0 }};
            const ringanCount = {{ $rekapKondisi['Rusak Ringan'] ?? 0 }};
            const beratCount = {{ $rekapKondisi['Rusak Berat'] ?? 0 }};
            const hilangCount = {{ $rekapKondisi['Hilang'] ?? 0 }};

            // 1. Doughnut Chart (Persentase Kondisi Aset dengan Tema Warna Sistem)
            const ctxDoughnut = document.getElementById('kondisiDoughnutChart');
            if (ctxDoughnut) {
                new Chart(ctxDoughnut.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: ['Baik', 'Rusak Ringan', 'Rusak Berat', 'Hilang'],
                        datasets: [{
                            data: [baikCount, ringanCount, beratCount, hilangCount],
                            backgroundColor: ['#3B82F6', '#EC4899', '#172554', '#93C5FD'],
                            hoverOffset: 8,
                            borderWidth: 2,
                            borderColor: '#ffffff'
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    font: { family: 'Plus Jakarta Sans, sans-serif', weight: 'bold', size: 11 },
                                    color: '#172554'
                                }
                            }
                        }
                    }
                });
            }

            // 2. Bar Chart (Grafik Batang Jumlah Unit dengan Tema Warna Sistem)
            const ctxBar = document.getElementById('kondisiBarChart');
            if (ctxBar) {
                new Chart(ctxBar.getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: ['Baik', 'Rusak Ringan', 'Rusak Berat', 'Hilang'],
                        datasets: [{
                            label: 'Jumlah Unit Aset',
                            data: [baikCount, ringanCount, beratCount, hilangCount],
                            backgroundColor: ['#3B82F6', '#EC4899', '#172554', '#F9A8D4'],
                            borderRadius: 12,
                            borderSkipped: false,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: { stepSize: 1, color: '#64748B', font: { weight: '600' } },
                                grid: { color: 'rgba(226, 232, 240, 0.7)' }
                            },
                            x: {
                                ticks: { color: '#172554', font: { weight: 'bold' } },
                                grid: { display: false }
                            }
                        }
                    }
                });
            }
        });
    </script>

</body>
</html>