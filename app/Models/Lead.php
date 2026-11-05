<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model
{
    use SoftDeletes;

    const SUMBER = ['Instagram', 'WhatsApp', 'Email', 'Website'];
    const SUMBER_MANUAL = ['Instagram', 'WhatsApp', 'Email'];
    const STATUS = ['Baru', 'Negosiasi', 'Deal', 'Terkonversi', 'Tidak Berlanjut'];
    const TIPE_PEMOHON = ['Calon Pelanggan Baru', 'Pelanggan Lama'];
    const PENANDA = ['Kemungkinan Duplikat', 'Terhubung', 'Perlu Verifikasi'];

    protected $fillable = [
        'nama',
        'instansi',
        'tipe_pemohon',
        'no_hp',
        'no_hp_normal',
        'email',
        'email_normal',
        'instagram',
        'sumber',
        'status',
        'alasan_tidak_berlanjut',
        'catatan_kebutuhan',
        'catatan_kesepakatan',
        'penanda',
        'is_baru',
        'penanggung_jawab_id',
    ];

    protected function casts(): array
    {
        return [
            'is_baru' => 'boolean',
        ];
    }

    public function layanans()
    {
        return $this->belongsToMany(Layanan::class);
    }

    public function penanggungJawab()
    {
        // akun yang sudah dihapus tetap kebaca biar namanya masih tampil
        return $this->belongsTo(User::class, 'penanggung_jawab_id')->withTrashed();
    }

    public function riwayatInteraksis()
    {
        return $this->hasMany(RiwayatInteraksi::class)->orderByDesc('waktu')->orderByDesc('id');
    }

    public function followUps()
    {
        return $this->hasMany(FollowUp::class)->orderBy('tanggal');
    }

    public function konsultasis()
    {
        return $this->hasMany(Konsultasi::class)->orderBy('tanggal')->orderBy('waktu');
    }

    // status yang boleh dipilih dari status sekarang, Deal ditetapkan lewat fitur tersendiri
    public function statusDiizinkan($user)
    {
        if ($this->status === 'Baru') {
            return ['Negosiasi', 'Tidak Berlanjut'];
        }

        if ($this->status === 'Negosiasi') {
            return ['Tidak Berlanjut'];
        }

        if ($this->status === 'Deal' && $user->hasRole(Role::OWNER)) {
            return ['Negosiasi', 'Tidak Berlanjut'];
        }

        if ($this->status === 'Tidak Berlanjut') {
            return ['Baru', 'Negosiasi'];
        }

        return [];
    }
}
