<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    const METODE = ['Transfer Bank', 'Tunai', 'Lainnya'];

    // pembayaran tidak bisa diubah, jadi cuma ada created_at
    const UPDATED_AT = null;

    protected $fillable = [
        'kesepakatan_id',
        'tanggal_bayar',
        'jumlah',
        'metode',
        'catatan',
        'dibuat_oleh',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_bayar' => 'date',
        ];
    }

    public function kesepakatan()
    {
        return $this->belongsTo(Kesepakatan::class);
    }

    public function pembuat()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh')->withTrashed();
    }
}
