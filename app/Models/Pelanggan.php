<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $fillable = [
        'nama',
        'instansi',
        'no_hp',
        'no_hp_normal',
        'email',
        'email_normal',
        'instagram',
        'sumber_awal',
        'catatan',
        'tanggal_menjadi_pelanggan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_menjadi_pelanggan' => 'date',
        ];
    }

    public function leads()
    {
        return $this->hasMany(Lead::class);
    }

    public function riwayatInteraksis()
    {
        return $this->hasMany(RiwayatInteraksi::class)->orderByDesc('waktu')->orderByDesc('id');
    }

    public function followUps()
    {
        return $this->hasMany(FollowUp::class)->orderBy('tanggal');
    }
}
