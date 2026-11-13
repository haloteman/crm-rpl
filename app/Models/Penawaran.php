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

    public function pembuat()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh')->withTrashed();
    }

    public function pengubah()
    {
        return $this->belongsTo(User::class, 'diubah_oleh')->withTrashed();
    }

    public function pengirim()
    {
        return $this->belongsTo(User::class, 'dikirim_oleh')->withTrashed();
    }

    public function penetapHargaAkhir()
    {
        return $this->belongsTo(User::class, 'harga_akhir_oleh')->withTrashed();
    }

    public function pemutus()
    {
        return $this->belongsTo(User::class, 'diputuskan_oleh')->withTrashed();
    }

    public function kesepakatan()
    {
        return $this->hasOne(Kesepakatan::class);
    }

    public function sudahDiputuskan()
    {
        return in_array($this->status, ['Disetujui', 'Ditolak']);
    }

    public function diskon()
    {
        return $this->harga_akhir === null ? null : $this->nilai_penawaran - $this->harga_akhir;
    }

    // kalau harga akhir belum ada, pakai nilai penawaran
    public function nilaiTampil()
    {
        return $this->harga_akhir ?? $this->nilai_penawaran;
    }
}
