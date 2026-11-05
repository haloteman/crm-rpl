<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatInteraksi extends Model
{
    const KANAL = ['Instagram', 'WhatsApp', 'Email', 'Tatap Muka', 'Lainnya'];

    protected $fillable = [
        'lead_id',
        'waktu',
        'jenis',
        'kanal',
        'ringkasan',
        'status_lama',
        'status_baru',
        'dibuat_oleh',
    ];

    protected function casts(): array
    {
        return [
            'waktu' => 'datetime',
        ];
    }

    public function pencatat()
    {
        return $this->belongsTo(User::class, 'dibuat_oleh')->withTrashed();
    }
}
