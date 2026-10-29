<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;

class CredentialService
{
    public static function generateNip()
    {
        do {
            $nip = (string) random_int(10000000000, 99999999999);
        } while (User::withTrashed()->where('nip', $nip)->exists());

        return $nip;
    }

    public static function generatePassword()
    {
        return Str::password(12, symbols: false);
    }
}
