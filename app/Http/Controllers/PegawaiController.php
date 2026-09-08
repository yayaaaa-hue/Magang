<?php

namespace App\Http\Controllers;

use App\Models\AsetPeralatanMesin;
use App\Models\PeminjamanAset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PegawaiController extends Controller
{
    public function index()
    {
        $asetTersedia = AsetPeralatanMesin::where('status_ketersediaan', 'Tersedia')->get();
        $riwayatSaya = PeminjamanAset::with('aset')->where('user_id', Auth::id())->latest()->get();

        return view('auth.pegawai', compact('asetTersedia', 'riwayatSaya'));
    }

    public function storePeminjaman(Request $request)
    {
        $validated = $request->validate([
            'aset_id' => 'required|exists:aset_peralatan_mesin,no_reg_pemda',
            'keperluan' => 'required|string',
            'tgl_pinjam' => 'required|date',
            'tgl_kembali' => 'required|date|after_or_equal:tgl_pinjam',
        ]);

        $aset = AsetPeralatanMesin::where('no_reg_pemda', $validated['aset_id'])->firstOrFail();
        if ($aset->status_ketersediaan !== 'Tersedia') {
            return back()->with('error', 'Aset yang Anda pilih saat ini sedang tidak tersedia.');
        }

        PeminjamanAset::create([
            'user_id' => Auth::id(),
            'aset_id' => $validated['aset_id'],
            'keperluan' => $validated['keperluan'],
            'tgl_pinjam' => $validated['tgl_pinjam'],
            'tgl_kembali' => $validated['tgl_kembali'],
            'status' => 'Menunggu',
        ]);

        return back()->with('success', 'Pengajuan pinjam pakai berhasil dikirim!');
    }
}