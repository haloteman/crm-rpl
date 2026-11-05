<?php

namespace App\Services;

use App\Models\Lead;
use App\Models\Pelanggan;

class DuplicateChecker
{
    public static function normalkanNoHp($noHp)
    {
        if (! $noHp) {
            return null;
        }

        $angka = preg_replace('/[^0-9]/', '', $noHp);

        // 62812... dan +62812... disamakan jadi 0812...
        if (str_starts_with($angka, '62')) {
            $angka = '0'.substr($angka, 2);
        }

        return $angka;
    }

    public static function normalkanEmail($email)
    {
        if (! $email) {
            return null;
        }

        return strtolower(trim($email));
    }

    public static function cariLeadMirip($noHp, $email, $kecualiLeadId = null)
    {
        $query = self::cariKontakSama(Lead::query(), $noHp, $email);

        if (! $query) {
            return collect();
        }

        if ($kecualiLeadId) {
            $query->where('id', '!=', $kecualiLeadId);
        }

        return $query->get();
    }

    public static function cariPelangganMirip($noHp, $email)
    {
        $query = self::cariKontakSama(Pelanggan::query(), $noHp, $email);

        if (! $query) {
            return collect();
        }

        return $query->get();
    }

    private static function cariKontakSama($query, $noHp, $email)
    {
        $noHpNormal = self::normalkanNoHp($noHp);
        $emailNormal = self::normalkanEmail($email);

        if (! $noHpNormal && ! $emailNormal) {
            return null;
        }

        return $query->where(function ($q) use ($noHpNormal, $emailNormal) {
            if ($noHpNormal) {
                $q->orWhere('no_hp_normal', $noHpNormal);
            }

            if ($emailNormal) {
                $q->orWhere('email_normal', $emailNormal);
            }
        });
    }
}
