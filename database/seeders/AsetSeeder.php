<?php

namespace Database\Seeders;

use App\Models\AsetPeralatanMesin;
use Illuminate\Database\Seeder;

class AsetSeeder extends Seeder
{
    public function run(): void
    {
        AsetPeralatanMesin::updateOrCreate(
            ['no_reg_pemda' => 'REG-2024-001'],
            [
                'penanggung_jawab'       => 'Dinas Kominfo',
                'jenis_barang'           => 'Proyektor Epson EB-X400',
                'merek_tipe'             => 'Epson EB-X400',
                'tahun'                  => 2024,
                'harga_perolehan'        => 8500000,
                'no_rangka_seri'         => 'EPSON-X400-8812',
                'no_mesin'               => '-',
                'no_polisi'              => '-',
                'no_bpkb'                => '-',
                'kondisi'                => 'Baik',
                'keterangan_lokasi_unit' => 'Bidang E-Government',
                'no_sk_bast'             => 'SK/001/KOMINFO/2024',
                'tgl_mulai_pinjam'       => '2026-01-12',
                'tgl_selesai_pinjam'     => '2027-01-12',
                'status_ketersediaan'    => 'Tersedia',
            ]
        );

        AsetPeralatanMesin::updateOrCreate(
            ['no_reg_pemda' => 'REG-2024-002'],
            [
                'penanggung_jawab'       => 'Bagian Umum',
                'jenis_barang'           => 'Toyota Innova Reborn 2.0 V',
                'merek_tipe'             => 'Toyota Innova',
                'tahun'                  => 2023,
                'harga_perolehan'        => 380000000,
                'no_rangka_seri'         => 'MHFK1111223344',
                'no_mesin'               => '1TR-FE-998822',
                'no_polisi'              => 'DM 1024 AB',
                'no_bpkb'                => 'BPKB-8827361',
                'kondisi'                => 'Baik',
                'keterangan_lokasi_unit' => 'Garasi Dinas Kominfo',
                'no_sk_bast'             => 'SK/002/KOMINFO/2024',
                'tgl_mulai_pinjam'       => '2026-02-01',
                'tgl_selesai_pinjam'     => '2026-08-01',
                'status_ketersediaan'    => 'Tersedia',
            ]
        );

        AsetPeralatanMesin::updateOrCreate(
            ['no_reg_pemda' => 'REG-2024-003'],
            [
                'penanggung_jawab'       => 'Bidang Aptika',
                'jenis_barang'           => 'Modem Portable Orbit Star H1',
                'merek_tipe'             => 'Telkomsel Orbit H1',
                'tahun'                  => 2024,
                'harga_perolehan'        => 650000,
                'no_rangka_seri'         => 'SN-ORB991823',
                'no_mesin'               => '-',
                'no_polisi'              => '-',
                'no_bpkb'                => '-',
                'kondisi'                => 'Baik',
                'keterangan_lokasi_unit' => 'Ruang Lab Aptika',
                'no_sk_bast'             => 'SK/003/KOMINFO/2024',
                'tgl_mulai_pinjam'       => null,
                'tgl_selesai_pinjam'     => null,
                'status_ketersediaan'    => 'Tersedia',
            ]
        );
    }
}
