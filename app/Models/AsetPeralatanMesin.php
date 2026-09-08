<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsetPeralatanMesin extends Model
{
    use HasFactory;

    protected $table = 'aset_peralatan_mesin';
    protected $primaryKey = 'no_reg_pemda';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'no_reg_pemda',
        'penanggung_jawab',
        'jenis_barang',
        'merek_tipe',
        'tahun',
        'harga_perolehan',
        'no_rangka_seri',
        'no_mesin',
        'no_polisi',
        'no_bpkb',
        'kondisi',
        'keterangan_lokasi_unit',
        'no_sk_bast',
        'tgl_mulai_pinjam',
        'tgl_selesai_pinjam',
        'status_ketersediaan',
    ];

    protected $casts = [
        'tgl_mulai_pinjam'   => 'date',
        'tgl_selesai_pinjam' => 'date',
    ];

    public function peminjaman()
    {
        return $this->hasMany(PeminjamanAset::class, 'aset_id', 'no_reg_pemda');
    }
}