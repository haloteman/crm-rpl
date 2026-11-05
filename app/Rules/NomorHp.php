<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NomorHp implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! preg_match('/^\+?[0-9 \-]+$/', $value)) {
            $fail('Nomor HP hanya boleh berisi angka, spasi, tanda hubung, dan awalan +');

            return;
        }

        $jumlahAngka = strlen(preg_replace('/[^0-9]/', '', $value));

        if ($jumlahAngka < 9 || $jumlahAngka > 15) {
            $fail('Nomor HP harus 9 sampai 15 angka');
        }
    }
}
