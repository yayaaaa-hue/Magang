<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Aset - {{ $aset->jenis_barang }} ({{ $aset->no_reg_pemda }})</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            background: linear-gradient(135deg, rgba(147, 197, 253, 0.45) 0%, rgba(255, 255, 255, 0.95) 50%, rgba(249, 168, 212, 0.45) 100%) !important;
            background-attachment: fixed !important;
        }
    </style>
</head>
<body class="bg-gradient-main font-sans antialiased text-slate-800 py-8 px-4 sm:px-6">

    <div class="max-w-xl mx-auto">
        <!-- Header Brand -->
        <div class="text-center mb-6">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-[#3B82F6] text-white rounded-2xl shadow-lg mb-3">
                <i class="fa-solid fa-qrcode text-3xl"></i>
            </div>
            <h1 class="text-2xl font-black text-[#172554] tracking-tight">Detail Informasi Aset</h1>
            <p class="text-sm text-slate-500 font-medium mt-1">Dinas Komunikasi dan Informatika (Diskominfo)</p>
        </div>

        <!-- Card Main Info -->
        <div class="bg-white rounded-3xl shadow-xl border border-slate-100 overflow-hidden mb-6">
            <!-- Top Status Badge Banner -->
            <div class="bg-[#172554] text-white px-6 py-4 flex items-center justify-between">
                <div>
                    <span class="text-xs text-blue-200 uppercase tracking-wider font-semibold block">No. Reg Pemda</span>
                    <span class="text-lg font-bold tracking-wide">{{ $aset->no_reg_pemda }}</span>
                </div>
                <div>
                    @if($aset->status_ketersediaan === 'Tersedia')
                        <span class="bg-emerald-500 text-white text-xs px-3 py-1.5 rounded-full font-bold shadow-sm inline-flex items-center space-x-1">
                            <i class="fa-solid fa-circle-check"></i>
                            <span>Tersedia</span>
                        </span>
                    @elseif($aset->status_ketersediaan === 'Dipinjam')
                        <span class="bg-amber-500 text-white text-xs px-3 py-1.5 rounded-full font-bold shadow-sm inline-flex items-center space-x-1">
                            <i class="fa-solid fa-clock-rotate-left"></i>
                            <span>Dipinjam</span>
                        </span>
                    @else
                        <span class="bg-rose-500 text-white text-xs px-3 py-1.5 rounded-full font-bold shadow-sm inline-flex items-center space-x-1">
                            <i class="fa-solid fa-wrench"></i>
                            <span>{{ $aset->status_ketersediaan }}</span>
                        </span>
                    @endif
                </div>
            </div>

            <div class="p-6 space-y-5">
                <!-- 1. Penanggung Jawab -->
                <div class="flex items-start space-x-4 p-4 bg-blue-50/60 rounded-2xl border border-blue-100">
                    <div class="w-10 h-10 rounded-xl bg-[#3B82F6] text-white flex items-center justify-center shrink-0 mt-0.5">
                        <i class="fa-solid fa-user-shield text-lg"></i>
                    </div>
                    <div>
                        <span class="text-xs text-slate-500 font-medium block">Penanggung Jawab</span>
                        <h3 class="text-base font-bold text-[#172554]">{{ $aset->penanggung_jawab ?? 'Belum Ditentukan' }}</h3>
                    </div>
                </div>

                <!-- 2. Jenis & Merek -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <div class="flex items-center space-x-2 text-[#3B82F6] mb-1">
                            <i class="fa-solid fa-box text-sm"></i>
                            <span class="text-xs font-semibold text-slate-500 uppercase">Jenis Aset</span>
                        </div>
                        <p class="font-bold text-[#172554]">{{ $aset->jenis_barang }}</p>
                    </div>

                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                        <div class="flex items-center space-x-2 text-[#EC4899] mb-1">
                            <i class="fa-solid fa-tag text-sm"></i>
                            <span class="text-xs font-semibold text-slate-500 uppercase">Merek / Tipe</span>
                        </div>
                        <p class="font-bold text-[#172554]">{{ $aset->merek_tipe }}</p>
                    </div>
                </div>

                <!-- 3. Spesifikasi Aset -->
                <div class="border-t border-slate-100 pt-4">
                    <h4 class="text-sm font-bold text-[#172554] mb-3 flex items-center space-x-2">
                        <i class="fa-solid fa-sliders text-[#3B82F6]"></i>
                        <span>Spesifikasi & Detail Teknis</span>
                    </h4>

                    <div class="bg-slate-50 rounded-2xl p-4 divide-y divide-slate-200/60 text-sm">
                        <div class="py-2 flex justify-between">
                            <span class="text-slate-500 font-medium">Tahun Pengadaan</span>
                            <span class="font-bold text-[#172554]">{{ $aset->tahun ?? '-' }}</span>
                        </div>
                        <div class="py-2 flex justify-between">
                            <span class="text-slate-500 font-medium">Kondisi Barang</span>
                            <span class="font-bold {{ $aset->kondisi === 'Baik' ? 'text-emerald-600' : 'text-rose-600' }}">
                                {{ $aset->kondisi }}
                            </span>
                        </div>
                        <div class="py-2 flex justify-between">
                            <span class="text-slate-500 font-medium">No. Rangka / Seri</span>
                            <span class="font-semibold text-slate-800">{{ $aset->no_rangka_seri ?: '-' }}</span>
                        </div>
                        <div class="py-2 flex justify-between">
                            <span class="text-slate-500 font-medium">No. Mesin</span>
                            <span class="font-semibold text-slate-800">{{ $aset->no_mesin ?: '-' }}</span>
                        </div>
                        <div class="py-2 flex justify-between">
                            <span class="text-slate-500 font-medium">No. Polisi</span>
                            <span class="font-semibold text-slate-800">{{ $aset->no_polisi ?: '-' }}</span>
                        </div>
                        <div class="py-2 flex justify-between">
                            <span class="text-slate-500 font-medium">No. BPKB</span>
                            <span class="font-semibold text-slate-800">{{ $aset->no_bpkb ?: '-' }}</span>
                        </div>
                        <div class="py-2 flex justify-between">
                            <span class="text-slate-500 font-medium">Lokasi Unit</span>
                            <span class="font-semibold text-slate-800">{{ $aset->keterangan_lokasi_unit ?: '-' }}</span>
                        </div>
                        <div class="py-2 flex justify-between">
                            <span class="text-slate-500 font-medium">Harga Perolehan</span>
                            <span class="font-bold text-[#3B82F6]">Rp {{ number_format($aset->harga_perolehan ?? 0, 0, ',', '.') }}</span>
                        </div>
                        @if($aset->no_sk_bast)
                        <div class="py-2 flex justify-between">
                            <span class="text-slate-500 font-medium">No. SK BAST</span>
                            <span class="font-semibold text-slate-800">{{ $aset->no_sk_bast }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Footer Action -->
            <div class="bg-slate-50 px-6 py-4 border-t border-slate-100 text-center">
                <p class="text-xs text-slate-400">QR Code Sistem Pemantauan Aset Diskominfo</p>
            </div>
        </div>

        <div class="text-center">
            <a href="/" class="inline-flex items-center space-x-2 text-sm font-semibold text-[#3B82F6] hover:text-[#172554] transition">
                <i class="fa-solid fa-arrow-left"></i>
                <span>Kembali ke Halaman Utama</span>
            </a>
        </div>
    </div>

</body>
</html>
