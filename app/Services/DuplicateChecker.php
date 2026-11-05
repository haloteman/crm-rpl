<?php

namespace App\Services;

use App\Models\Lead;

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
        $noHpNormal = self::normalkanNoHp($noHp);
        $emailNormal = self::normalkanEmail($email);

        if (! $noHpNormal && ! $emailNormal) {
            return collect();
        }

        $query = Lead::where(function ($q) use ($noHpNormal, $emailNormal) {
            if ($noHpNormal) {
                $q->orWhere('no_hp_normal', $noHpNormal);
            }

            if ($emailNormal) {
                $q->orWhere('email_normal', $emailNormal);
            }
        });

        if ($kecualiLeadId) {
            $query->where('id', '!=', $kecualiLeadId);
        }

        return $query->get();
    }
}
