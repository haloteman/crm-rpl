<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Konsultasi extends Model
{
    const STATUS = ['Dijadwalkan', 'Terlaksana', 'Dibatalkan'];

    protected $fillable = [
        'lead_id',
        'tanggal',
        'waktu',
        'tempat',
        'peserta',
        'catatan',
        'status',
        'hasil',
        'dibuat_oleh',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
        ];
    }

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }
}
