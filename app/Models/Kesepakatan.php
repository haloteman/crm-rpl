<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kesepakatan extends Model
{
    const STATUS_PEMBAYARAN = ['Belum Dibayar', 'Dibayar Sebagian', 'Lunas'];

    protected $fillable = [
        'penawaran_id',
        'nilai_kesepakatan',
        'ketentuan_pekerjaan',
        'tanggal_kesepakatan',
        'masa_kontrak_mulai',
        'masa_kontrak_selesai',
        'frekuensi_update_progres',
        'status_pembayaran',
        'dibuat_oleh',
        'diubah_oleh',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_kesepakatan' => 'date',
            'masa_kontrak_mulai' => 'date',
            'masa_kontrak_selesai' => 'date',
        ];
    }

    public function penawaran()
    {
        return $this->belongsTo(Penawaran::class);
    }

    public function pembuat()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh')->withTrashed();
    }

    public function pengubah()
    {
        return $this->belongsTo(User::class, 'diubah_oleh')->withTrashed();
    }

    public function pembayarans()
    {
        return $this->hasMany(Pembayaran::class)->orderBy('tanggal_bayar')->orderBy('id');
    }

    public function totalDibayar()
    {
        return (int) $this->pembayarans()->sum('jumlah');
    }

    public function sisaTagihan()
    {
        return $this->nilai_kesepakatan - $this->totalDibayar();
    }

    // pembayaran pertama (DP) disarankan 50%, berikutnya sisa tagihan
    public function saranJumlah()
    {
        if (! $this->pembayarans()->exists()) {
            return (int) round($this->nilai_kesepakatan / 2);
        }

        return $this->sisaTagihan();
    }
}
