<?php

namespace App\Http\Controllers;

use App\Models\AsetPeralatanMesin;
use App\Models\PeminjamanAset;
use App\Models\PendaftaranMagang;
use App\Models\SuratBalasanMagang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminController extends Controller
{
    // Halaman Manajemen Aset & Persetujuan Pinjam Pakai & Laporan Rekap
    public function aset(Request $request)
    {
        $aset = AsetPeralatanMesin::orderBy('created_at', 'desc')->get();
        
        $peminjaman = PeminjamanAset::with(['user', 'aset'])
            ->orderBy('id', 'desc')
            ->get();

        // Data Laporan Rekap Bulanan
        $filterBulan = $request->query('filter_bulan', 'all');
        $filterTahun = $request->query('filter_tahun', date('Y'));

        $queryLaporan = AsetPeralatanMesin::query();
        if ($filterBulan && $filterBulan !== 'all') {
            $queryLaporan->whereMonth('created_at', $filterBulan);
        }
        if ($filterTahun && $filterTahun !== 'all') {
            $queryLaporan->whereYear('created_at', $filterTahun);
        }
        $laporanAset = $queryLaporan->orderBy('created_at', 'desc')->get();

        $rekapKondisi = [
            'Baik' => $laporanAset->where('kondisi', 'Baik')->count(),
            'Rusak Ringan' => $laporanAset->where('kondisi', 'Rusak Ringan')->count(),
            'Rusak Berat' => $laporanAset->where('kondisi', 'Rusak Berat')->count(),
            'Hilang' => $laporanAset->where('kondisi', 'Hilang')->count(),
            'Total' => $laporanAset->count(),
        ];

        return view('auth.aset', compact('aset', 'peminjaman', 'laporanAset', 'rekapKondisi', 'filterBulan', 'filterTahun'));
    }

    // Tombol Tambah Aset
    public function storeAset(Request $request)
    {
        if ($request->has('harga_perolehan') && is_string($request->harga_perolehan)) {
            $cleanPrice = preg_replace('/[^\d]/', '', $request->harga_perolehan);
            $request->merge(['harga_perolehan' => $cleanPrice !== '' ? (int)$cleanPrice : null]);
        }

        $request->validate([
            'no_reg_pemda'           => 'required|string|max:100|unique:aset_peralatan_mesin,no_reg_pemda',
            'penanggung_jawab'       => 'required|string|max:100',
            'jenis_barang'           => 'required|string|max:100',
            'merek_tipe'             => 'required|string|max:100',
            'tahun'                  => 'required|digits:4',
            'harga_perolehan'        => 'required|numeric|min:0|max:999000000',
            'kondisi'                => 'required|in:Baik,Hilang,Rusak Ringan,Rusak Berat',
            'keterangan_lokasi_unit' => 'required|string|max:150',
            'no_sk_bast'             => 'nullable|string|max:150',
            'no_rangka_seri'         => 'nullable|string|max:100',
            'no_mesin'               => 'nullable|string|max:100',
            'no_polisi'              => 'nullable|string|max:50',
            'no_bpkb'                => 'nullable|string|max:50',
        ], [
            'no_reg_pemda.required'             => 'No. Reg / ID Pemda wajib diisi.',
            'no_reg_pemda.unique'               => 'No. Reg / ID Pemda sudah terdaftar dalam sistem (harus unik).',
            'penanggung_jawab.required'         => 'Penanggung Jawab wajib diisi.',
            'jenis_barang.required'             => 'Jenis Barang wajib diisi.',
            'merek_tipe.required'               => 'Merek / Tipe Aset wajib diisi.',
            'tahun.required'                    => 'Tahun Perolehan wajib diisi.',
            'tahun.digits'                      => 'Tahun Perolehan harus 4 digit angka valid (contoh: 2026).',
            'harga_perolehan.required'          => 'Harga Perolehan wajib diisi.',
            'harga_perolehan.numeric'           => 'Harga Perolehan harus berupa angka valid.',
            'harga_perolehan.min'               => 'Harga Perolehan tidak boleh kurang dari 0.',
            'harga_perolehan.max'               => 'Harga Perolehan tidak boleh melebihi Rp 999.000.000.',
            'kondisi.required'                  => 'Kondisi Aset wajib dipilih.',
            'keterangan_lokasi_unit.required'   => 'Keterangan Unit Lokasi wajib diisi.',
        ]);

        AsetPeralatanMesin::create([
            'no_reg_pemda'           => trim($request->no_reg_pemda),
            'penanggung_jawab'       => trim($request->penanggung_jawab),
            'jenis_barang'           => trim($request->jenis_barang),
            'merek_tipe'             => trim($request->merek_tipe),
            'tahun'                  => $request->tahun,
            'harga_perolehan'        => $request->harga_perolehan,
            'no_rangka_seri'         => $request->no_rangka_seri,
            'no_mesin'               => $request->no_mesin,
            'no_polisi'              => $request->no_polisi,
            'no_bpkb'                => $request->no_bpkb,
            'kondisi'                => $request->kondisi,
            'keterangan_lokasi_unit' => trim($request->keterangan_lokasi_unit),
            'no_sk_bast'             => $request->no_sk_bast ? trim($request->no_sk_bast) : null,
            'status_ketersediaan'    => 'Tersedia',
        ]);

        return redirect()->back()->with('success', 'Aset berhasil ditambahkan!');
    }

    // Tombol Edit Aset
    public function updateAset(Request $request, $no_reg_pemda)
    {
        $id = urldecode($no_reg_pemda);
        $aset = AsetPeralatanMesin::where('no_reg_pemda', $id)->orWhere('no_reg_pemda', $no_reg_pemda)->first();

        if (!$aset) {
            $aset = AsetPeralatanMesin::find($no_reg_pemda);
        }

        if (!$aset) {
            return redirect()->back()->with('error', 'Data aset tidak ditemukan.');
        }

        if ($request->has('harga_perolehan') && is_string($request->harga_perolehan)) {
            $cleanPrice = preg_replace('/[^\d]/', '', $request->harga_perolehan);
            $request->merge(['harga_perolehan' => $cleanPrice !== '' ? (int)$cleanPrice : null]);
        }

        $request->validate([
            'no_reg_pemda'           => 'required|string|max:100|unique:aset_peralatan_mesin,no_reg_pemda,' . $aset->no_reg_pemda . ',no_reg_pemda',
            'penanggung_jawab'       => 'required|string|max:100',
            'jenis_barang'           => 'required|string|max:100',
            'merek_tipe'             => 'required|string|max:100',
            'tahun'                  => 'required|digits:4',
            'harga_perolehan'        => 'required|numeric|min:0|max:999000000',
            'kondisi'                => 'required|in:Baik,Hilang,Rusak Ringan,Rusak Berat',
            'keterangan_lokasi_unit' => 'required|string|max:150',
            'no_sk_bast'             => 'nullable|string|max:150',
            'status_ketersediaan'    => 'required|in:Tersedia,Dipinjam,Perbaikan',
            'no_rangka_seri'         => 'nullable|string|max:100',
            'no_mesin'               => 'nullable|string|max:100',
            'no_polisi'              => 'nullable|string|max:50',
            'no_bpkb'                => 'nullable|string|max:50',
        ], [
            'no_reg_pemda.required'             => 'No. Reg / ID Pemda wajib diisi.',
            'no_reg_pemda.unique'               => 'No. Reg / ID Pemda sudah terdaftar dalam sistem (harus unik).',
            'penanggung_jawab.required'         => 'Penanggung Jawab wajib diisi.',
            'jenis_barang.required'             => 'Jenis Barang wajib diisi.',
            'merek_tipe.required'               => 'Merek / Tipe Aset wajib diisi.',
            'tahun.required'                    => 'Tahun Perolehan wajib diisi.',
            'tahun.digits'                      => 'Tahun Perolehan harus 4 digit angka valid (contoh: 2026).',
            'harga_perolehan.required'          => 'Harga Perolehan wajib diisi.',
            'harga_perolehan.numeric'           => 'Harga Perolehan harus berupa angka valid.',
            'harga_perolehan.min'               => 'Harga Perolehan tidak boleh kurang dari 0.',
            'harga_perolehan.max'               => 'Harga Perolehan tidak boleh melebihi Rp 999.000.000.',
            'kondisi.required'                  => 'Kondisi Aset wajib dipilih.',
            'keterangan_lokasi_unit.required'   => 'Keterangan Unit Lokasi wajib diisi.',
        ]);

        $aset->update([
            'no_reg_pemda'           => trim($request->no_reg_pemda),
            'penanggung_jawab'       => trim($request->penanggung_jawab),
            'jenis_barang'           => trim($request->jenis_barang),
            'merek_tipe'             => trim($request->merek_tipe),
            'tahun'                  => $request->tahun,
            'harga_perolehan'        => $request->harga_perolehan,
            'no_rangka_seri'         => $request->no_rangka_seri,
            'no_mesin'               => $request->no_mesin,
            'no_polisi'              => $request->no_polisi,
            'no_bpkb'                => $request->no_bpkb,
            'kondisi'                => $request->kondisi,
            'keterangan_lokasi_unit' => trim($request->keterangan_lokasi_unit),
            'no_sk_bast'             => $request->no_sk_bast ? trim($request->no_sk_bast) : null,
            'status_ketersediaan'    => $request->status_ketersediaan,
        ]);

        return redirect()->back()->with('success', 'Data aset berhasil diperbarui!');
    }

    // Tombol Hapus Aset
    public function destroyAset($no_reg_pemda)
    {
        $id = urldecode($no_reg_pemda);
        $aset = AsetPeralatanMesin::where('no_reg_pemda', $id)->orWhere('no_reg_pemda', $no_reg_pemda)->first();

        if (!$aset) {
            $aset = AsetPeralatanMesin::find($no_reg_pemda);
        }

        if ($aset) {
            $aset->delete();
            return redirect()->back()->with('success', 'Aset berhasil dihapus!');
        }

        return redirect()->back()->with('error', 'Data aset tidak ditemukan.');
    }

    // Setujui / Tolak / Kembalikan Pinjam Pakai Pegawai
    public function updateStatusPeminjaman(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Disetujui,Ditolak,Dikembalikan',
            'catatan_admin' => 'nullable|string|max:255',
        ]);

        $peminjaman = PeminjamanAset::findOrFail($id);
        
        $peminjaman->update([
            'status'        => $request->status,
            'catatan_admin' => $request->catatan_admin ?: $peminjaman->catatan_admin,
        ]);

        // Perbarui status ketersediaan barang di aset_peralatan_mesin
        if ($peminjaman->aset) {
            if ($request->status === 'Disetujui') {
                $peminjaman->aset->update(['status_ketersediaan' => 'Dipinjam']);
            } elseif (in_array($request->status, ['Ditolak', 'Dikembalikan'])) {
                $peminjaman->aset->update(['status_ketersediaan' => 'Tersedia']);
            }
        }

        return redirect()->back()->with('success', 'Status permohonan peminjaman berhasil diperbarui!');
    }

    // Halaman Kelola Magang
    public function magang()
    {
        $magang = PendaftaranMagang::with(['user', 'suratBalasan'])->latest()->get();
        return view('auth.magang', compact('magang'));
    }

    // Setujui / Tolak Magang & Upload Surat Balasan
    public function updateStatusMagang(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Diterima,Ditolak',
            'no_surat' => 'nullable|string|max:100',
            'file_surat_balasan' => 'nullable|file|mimes:pdf|max:2048',
            'catatan_admin' => 'nullable|string',
        ]);

        $pendaftaran = PendaftaranMagang::findOrFail($id);

        if ($request->status === 'Ditolak') {
            // Hapus berkas pengantar jika ada
            if ($pendaftaran->surat_pengantar) {
                Storage::disk('public')->delete($pendaftaran->surat_pengantar);
            }
            // Hapus berkas surat balasan jika ada
            if ($pendaftaran->suratBalasan) {
                if ($pendaftaran->suratBalasan->file_surat_balasan) {
                    Storage::disk('public')->delete($pendaftaran->suratBalasan->file_surat_balasan);
                }
                $pendaftaran->suratBalasan->delete();
            }
            // Hapus record dari database
            $pendaftaran->delete();

            return redirect()->back()->with('success', 'Data pendaftaran magang ditolak dan telah otomatis dihapus dari database.');
        }

        $pendaftaran->update(['status' => $request->status]);

        if ($request->hasFile('file_surat_balasan')) {
            $path = $request->file('file_surat_balasan')->store('surat_balasan', 'public');
            
            SuratBalasanMagang::updateOrCreate(
                ['pendaftaran_id' => $pendaftaran->id],
                [
                    'no_surat' => $request->no_surat ?: ('SK/' . $pendaftaran->id . '/DISCOM/2026'),
                    'tanggal_surat' => now(),
                    'file_surat_balasan' => $path,
                    'catatan_admin' => $request->catatan_admin,
                ]
            );
        }

        return redirect()->back()->with('success', 'Status pendaftaran magang berhasil diperbarui!');
    }

    // Halaman Kelola User
    public function users()
    {
        $users = User::latest()->get();
        return view('auth.user', compact('users'));
    }

    // Tambah User Baru (Khusus Admin Master)
    public function storeUser(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'required|in:admin_master,admin,pegawai,mahasiswa',
            'instansi_bidang' => 'nullable|string|max:150',
        ]);

        User::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'instansi_bidang' => $request->instansi_bidang ?: 'Diskominfo Bonebol',
        ]);

        return redirect()->back()->with('success', 'Pengguna baru berhasil ditambahkan!');
    }

    // Hapus User
    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri!');
        }
        $user->delete();
        return redirect()->back()->with('success', 'Pengguna berhasil dihapus!');
    }

    // Halaman Detail Publik Aset (Scan QR Code)
    public function publicDetail($id)
    {
        $decodedId = urldecode($id);
        $aset = AsetPeralatanMesin::where('no_reg_pemda', $decodedId)->orWhere('no_reg_pemda', $id)->firstOrFail();
        return view('aset.public_detail', compact('aset'));
    }

    // Export Laporan Rekap Bulanan ke PDF
    public function exportLaporanPdf(Request $request)
    {
        $filterBulan = $request->query('filter_bulan', 'all');
        $filterTahun = $request->query('filter_tahun', date('Y'));

        $queryLaporan = AsetPeralatanMesin::query();
        if ($filterBulan && $filterBulan !== 'all') {
            $queryLaporan->whereMonth('created_at', $filterBulan);
        }
        if ($filterTahun && $filterTahun !== 'all') {
            $queryLaporan->whereYear('created_at', $filterTahun);
        }
        $aset = $queryLaporan->orderBy('created_at', 'desc')->get();

        $rekap = [
            'Baik' => $aset->where('kondisi', 'Baik')->count(),
            'Rusak Ringan' => $aset->where('kondisi', 'Rusak Ringan')->count(),
            'Rusak Berat' => $aset->where('kondisi', 'Rusak Berat')->count(),
            'Hilang' => $aset->where('kondisi', 'Hilang')->count(),
            'Total' => $aset->count(),
        ];

        $namaBulanList = [
            '1' => 'Januari', '2' => 'Februari', '3' => 'Maret', '4' => 'April',
            '5' => 'Mei', '6' => 'Juni', '7' => 'Juli', '8' => 'Agustus',
            '9' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Desember',
            'all' => 'Semua Bulan'
        ];

        $namaBulan = $namaBulanList[$filterBulan] ?? 'Semua Bulan';
        $tahun = $filterTahun === 'all' ? 'Semua Tahun' : $filterTahun;

        if (class_exists(Pdf::class)) {
            $pdf = Pdf::loadView('admin.laporan_pdf', compact('aset', 'rekap', 'namaBulan', 'tahun'));
            return $pdf->download('laporan-rekap-kondisi-aset-' . $filterBulan . '-' . $filterTahun . '.pdf');
        }

        return view('admin.laporan_pdf', compact('aset', 'rekap', 'namaBulan', 'tahun'));
    }
}