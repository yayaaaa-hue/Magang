<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Magang Mahasiswa - SIMPATIK</title>
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
                        <i class="fa-solid fa-user-graduate text-lg"></i>
                    </div>
                    <div>
                        <h2 class="font-black text-base leading-tight text-white">Portal Magang</h2>
                        <span class="text-xs text-blue-200">Diskominfo System</span>
                    </div>
                </div>

                <nav class="mt-6 space-y-2">
                    <a href="{{ route('mahasiswa.dashboard') }}" class="flex items-center space-x-3 px-4 py-3 bg-[#3B82F6] text-white rounded-full font-bold shadow-md transition">
                        <i class="fa-solid fa-file-pen w-5"></i>
                        <span>Pengajuan & Status</span>
                    </a>
                </nav>
            </div>

            <div class="border-t border-blue-900/60 pt-4">
                <div class="flex items-center justify-between px-2">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-pink-100 text-[#EC4899] rounded-full flex items-center justify-center font-black shadow uppercase">
                            {{ substr(Auth::user()->nama ?? 'M', 0, 1) }}
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-white truncate max-w-[110px]">{{ Auth::user()->nama ?? 'Mahasiswa' }}</p>
                            <p class="text-xs text-blue-200 capitalize">{{ Auth::user()->role ?? 'mahasiswa' }}</p>
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
                <h1 class="text-xl font-black text-[#172554] tracking-tight">Pengajuan Magang Mahasiswa</h1>
                <span class="text-xs font-bold px-3 py-1 bg-blue-100 text-[#3B82F6] rounded-full">
                    {{ Auth::user()->nama ?? Auth::user()->name ?? 'Mahasiswa Magang' }}
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

                <!-- 1. Status Pendaftaran Section -->
                <div class="bg-card-gradient rounded-3xl p-6 space-y-4">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-slate-100 pb-4">
                        <div>
                            <h3 class="font-extrabold text-[#172554] text-lg">Status Pendaftaran Magang</h3>
                            <p class="text-xs text-slate-500">Pantau status verifikasi dan berkas balasan dari Admin Diskominfo</p>
                        </div>
                        
                        <div>
                            @if(isset($pengajuanSaya))
                                @if($pengajuanSaya->status === 'Diterima')
                                    <span class="inline-flex items-center space-x-1.5 bg-emerald-100 text-emerald-800 px-4 py-1.5 rounded-full text-xs font-bold border border-emerald-200">
                                        <i class="fa-solid fa-circle-check"></i>
                                        <span>Diterima</span>
                                    </span>
                                @elseif($pengajuanSaya->status === 'Ditolak')
                                    <span class="inline-flex items-center space-x-1.5 bg-rose-100 text-rose-800 px-4 py-1.5 rounded-full text-xs font-bold border border-rose-200">
                                        <i class="fa-solid fa-circle-xmark"></i>
                                        <span>Ditolak</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center space-x-1.5 bg-amber-100 text-amber-800 px-4 py-1.5 rounded-full text-xs font-bold border border-amber-200">
                                        <i class="fa-solid fa-clock"></i>
                                        <span>Menunggu Verifikasi</span>
                                    </span>
                                @endif
                            @else
                                <span class="inline-flex items-center space-x-1.5 bg-slate-100 text-slate-600 px-4 py-1.5 rounded-full text-xs font-bold border border-slate-200">
                                    <i class="fa-solid fa-circle-info"></i>
                                    <span>Belum Mengajukan</span>
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Area Download Surat Balasan -->
                    <div class="bg-slate-50/80 rounded-2xl p-4 border border-slate-200 flex flex-col md:flex-row items-center justify-between gap-4">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 rounded-full bg-blue-100 text-[#3B82F6] flex items-center justify-center shrink-0 shadow-sm">
                                <i class="fa-solid fa-file-pdf text-xl"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-bold text-[#172554]">Surat Balasan Penerimaan Magang</h4>
                                <p class="text-xs text-slate-500">
                                    @if(isset($pengajuanSaya) && $pengajuanSaya->suratBalasan)
                                        No Surat: {{ $pengajuanSaya->suratBalasan->no_surat ?? 'Tersedia' }}
                                    @else
                                        Diunggah oleh admin jika berkas pengajuan telah disetujui.
                                    @endif
                                </p>
                            </div>
                        </div>

                        @if(isset($pengajuanSaya) && $pengajuanSaya->suratBalasan && $pengajuanSaya->suratBalasan->file_surat_balasan)
                            <a href="{{ route('mahasiswa.surat-balasan.download', $pengajuanSaya->id) }}" class="w-full md:w-auto bg-gradient-to-r from-[#3B82F6] to-[#2563EB] hover:from-blue-600 hover:to-blue-800 text-white px-5 py-2.5 rounded-full text-xs font-extrabold flex items-center justify-center space-x-2 transition shadow-md">
                                <i class="fa-solid fa-download"></i>
                                <span>Download Surat Balasan (PDF)</span>
                            </a>
                        @else
                            <button disabled class="w-full md:w-auto bg-slate-200 text-slate-400 px-5 py-2.5 rounded-full text-xs font-semibold flex items-center justify-center space-x-2 cursor-not-allowed">
                                <i class="fa-solid fa-lock"></i>
                                <span>Surat Balasan Belum Tersedia</span>
                            </button>
                        @endif
                    </div>
                </div>

                <!-- 2. Form Pendaftaran Magang -->
                <div class="bg-card-gradient rounded-3xl border border-slate-200/80 shadow-xl overflow-hidden">
                    <div class="p-5 border-b border-slate-200 bg-slate-50/80">
                        <h3 class="font-bold text-[#172554] text-base">Form Formulir Pendaftaran Magang</h3>
                        <p class="text-xs text-slate-500 mt-0.5">Isi data diri dan berkas pengajuan surat pengantar kampus kamu.</p>
                    </div>

                    <form action="{{ route('mahasiswa.magang.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                        @csrf
                        
                        <!-- Data Diri Section -->
                        <div>
                            <h4 class="text-xs font-bold text-[#3B82F6] uppercase tracking-wider mb-4 border-b pb-1">1. Data Diri & Kampus</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-[#172554] mb-1">Nama Lengkap</label>
                                    <input type="text" name="nama" value="{{ Auth::user()->nama }}" class="w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-sm bg-slate-100/80 focus:outline-none" readonly>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-[#172554] mb-1">Email</label>
                                    <input type="email" name="email" value="{{ Auth::user()->email }}" class="w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-sm bg-slate-100/80 focus:outline-none" readonly>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-[#172554] mb-1">NIM</label>
                                    <input type="text" name="nim" value="{{ old('nim', $pengajuanSaya->nim ?? '') }}" placeholder="Masukkan NIM kamu" class="w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-[#3B82F6]" required>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-[#172554] mb-1">Asal Perguruan Tinggi / Sekolah</label>
                                    <input type="text" name="universitas" value="{{ old('universitas', $pengajuanSaya->universitas ?? Auth::user()->instansi_bidang ?? '') }}" placeholder="Contoh: Universitas Negeri Gorontalo" class="w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-[#3B82F6]" required>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-[#172554] mb-1">Jurusan</label>
                                    <input type="text" name="jurusan" value="{{ old('jurusan', $pengajuanSaya->jurusan ?? '') }}" placeholder="Contoh: Sistem Informasi" class="w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-[#3B82F6]" required>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-[#172554] mb-1">No. WhatsApp / Telepon</label>
                                    <input type="tel" name="no_hp" value="{{ old('no_hp', $pengajuanSaya->no_hp ?? '') }}" placeholder="08xxxxxxxxxx" class="w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-[#3B82F6]" required>
                                </div>
                            </div>
                        </div>

                        <!-- Pelaksanaan Magang Section -->
                        <div>
                            <h4 class="text-xs font-bold text-[#3B82F6] uppercase tracking-wider mb-4 border-b pb-1">2. Durasi Pelaksanaan Magang</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-[#172554] mb-1">Tanggal Mulai</label>
                                    <input type="date" name="tgl_mulai" value="{{ old('tgl_mulai', $pengajuanSaya->tgl_mulai ?? '') }}" class="w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-[#3B82F6]" required>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-[#172554] mb-1">Tanggal Selesai</label>
                                    <input type="date" name="tgl_selesai" value="{{ old('tgl_selesai', $pengajuanSaya->tgl_selesai ?? '') }}" class="w-full px-3.5 py-2.5 border border-slate-300 rounded-xl text-sm focus:ring-2 focus:ring-[#3B82F6]" required>
                                </div>
                            </div>
                        </div>

                        <!-- Berkas Surat Pengantar PDF Section -->
                        <div>
                            <h4 class="text-xs font-bold text-[#3B82F6] uppercase tracking-wider mb-4 border-b pb-1">3. Upload Berkas Permohonan</h4>
                            <div>
                                <label class="block text-xs font-bold text-[#172554] mb-1">Surat Pengantar dari Kampus/Sekolah (Format PDF, Maks 2MB)</label>
                                <input type="file" name="surat_pengantar" accept=".pdf" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-[#3B82F6] hover:file:bg-blue-100 border border-slate-300 rounded-xl cursor-pointer" required>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex justify-end pt-4 border-t border-slate-100">
                            <button type="submit" class="bg-gradient-to-r from-[#3B82F6] to-[#2563EB] hover:from-blue-600 hover:to-blue-800 text-white px-6 py-3 rounded-full text-sm font-extrabold flex items-center space-x-2 transition shadow-lg transform hover:-translate-y-0.5">
                                <i class="fa-solid fa-paper-plane"></i>
                                <span>Kirim Pendaftaran</span>
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </main>
    </div>

</body>
</html>