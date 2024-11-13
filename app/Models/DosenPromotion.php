<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DosenPromotion extends Model
{
    use HasFactory;
    protected $table = 'dosen_promotions';
    protected $fillable = [
        'nama_dosen',
        'jabatan_akademik_sebelumnya',
        'jabatan_akademik_di_usulkan',
        'tanggal_proses',
        'tanggal_selesai',
        'surat_pengantar_pimpinan_pts',
        'berita_acara_senat',
    ];
}
