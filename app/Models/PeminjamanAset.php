<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanAset extends Model
{
    use HasFactory;

    protected $table = 'peminjaman_aset';

    protected $fillable = [
        'user_id',
        'aset_id',
        'keperluan',
        'tgl_pinjam',
        'tgl_kembali',
        'status',
        'catatan_admin',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function aset()
    {
        return $this->belongsTo(AsetPeralatanMesin::class, 'aset_id', 'no_reg_pemda');
    }
}
