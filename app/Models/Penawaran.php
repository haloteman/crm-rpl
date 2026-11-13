<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penawaran extends Model
{
    const STATUS = ['Draf', 'Dikirim', 'Disetujui', 'Ditolak'];
    const ALASAN_LOST = ['Harga tidak sesuai', 'Memilih pihak lain', 'Kebutuhan dibatalkan', 'Tidak ada respons', 'Lainnya'];

    protected $fillable = [
        'lead_id',
        'nomor_penawaran',
        'ruang_lingkup',
        'nilai_penawaran',
        'catatan_negosiasi',
        'status',
        'harga_akhir',
        'harga_akhir_oleh',
        'harga_akhir_at',
        'alasan_lost',
        'catatan_lost',
        'diputuskan_oleh',
        'diputuskan_at',
        'dikirim_oleh',
        'dikirim_at',
        'dibuat_oleh',
        'diubah_oleh',
    ];

    protected function casts(): array
    {
        return [
            'harga_akhir_at' => 'datetime',
            'diputuskan_at' => 'datetime',
            'dikirim_at' => 'datetime',
        ];
    }

    public function lead()
    {
        return $this->belongsTo(Lead::class)->withTrashed();
    }

    public function layanans()
    {
        return $this->belongsToMany(Layanan::class, 'penawaran_layanan');
    }

    public function kesepakatan()
    {
        return $this->hasOne(Kesepakatan::class);
    }

    // kalau harga akhir belum ada, pakai nilai penawaran
    public function nilaiTampil()
    {
        return $this->harga_akhir ?? $this->nilai_penawaran;
    }
}
