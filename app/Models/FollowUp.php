<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FollowUp extends Model
{
    const JENIS = ['Umum', 'Update Progres'];

    protected $fillable = [
        'lead_id',
        'tanggal',
        'jenis',
        'catatan_tujuan',
        'selesai',
        'selesai_pada',
        'dibuat_oleh',
    ];

    protected function casts(): array
    {
        return [
            'tanggal' => 'date',
            'selesai' => 'boolean',
            'selesai_pada' => 'datetime',
        ];
    }

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }

    public function jatuhTempo()
    {
        return ! $this->selesai && $this->tanggal->lte(today());
    }
}
