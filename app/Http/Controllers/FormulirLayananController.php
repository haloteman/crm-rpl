<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Lead;
use App\Services\DuplicateChecker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\Rule;

class FormulirLayananController extends Controller
{
    public function create()
    {
        return view('website.formulir', [
            'layanans' => Layanan::orderBy('id')->get(),
        ]);
    }

    public function submit(Request $request)
    {
        $request->validate([
            'nama' => 'required|max:100',
            'instansi' => 'nullable|max:100',
            'tipe_pemohon' => ['required', Rule::in(Lead::TIPE_PEMOHON)],
            'layanan' => 'required|array',
            'layanan.*' => 'exists:layanans,id',
            'email' => 'nullable|required_without:no_hp|email|max:255',
            'no_hp' => ['bail', 'nullable', 'required_without:email', 'regex:/^\+?[0-9 \-]+$/', function ($attribute, $value, $fail) {
                $jumlahAngka = strlen(preg_replace('/[^0-9]/', '', $value));

                if ($jumlahAngka < 9 || $jumlahAngka > 15) {
                    $fail('Nomor HP harus 9 sampai 15 angka');
                }
            }],
            'pesan' => 'nullable|max:1000',
        ], [
            'nama.required' => 'Nama wajib diisi',
            'nama.max' => 'Nama maksimal 100 karakter',
            'instansi.max' => 'Asal/instansi maksimal 100 karakter',
            'tipe_pemohon.required' => 'Status pemohon wajib dipilih',
            'tipe_pemohon.in' => 'Status pemohon tidak tersedia',
            'layanan.required' => 'Pilih minimal satu layanan',
            'layanan.array' => 'Layanan tidak tersedia',
            'layanan.*.exists' => 'Layanan tidak tersedia',
            'email.required_without' => 'Isi email atau nomor HP',
            'email.email' => 'Format email tidak valid',
            'email.max' => 'Email terlalu panjang',
            'no_hp.required_without' => 'Isi email atau nomor HP',
            'no_hp.regex' => 'Nomor HP hanya boleh berisi angka, spasi, tanda hubung, dan awalan +',
            'pesan.max' => 'Pesan maksimal 1.000 karakter',
        ]);

        // kolom jebakan: disembunyikan dari pengunjung, jadi yang ngisi pasti bot
        if ($request->filled('website')) {
            return redirect()->route('website.konfirmasi');
        }

        $kunci = 'formulir-layanan:'.$request->ip();

        if (RateLimiter::tooManyAttempts($kunci, 5)) {
            return back()->withInput()->withErrors([
                'formulir' => 'Terlalu sering mengirim permintaan. Silakan coba lagi nanti.',
            ]);
        }

        RateLimiter::hit($kunci, 60 * 60);

        try {
            DB::transaction(function () use ($request) {
                $adaYangMirip = DuplicateChecker::cariLeadMirip($request->no_hp, $request->email)->isNotEmpty();

                $lead = Lead::create([
                    'nama' => $request->nama,
                    'instansi' => $request->instansi,
                    'tipe_pemohon' => $request->tipe_pemohon,
                    'email' => $request->email,
                    'email_normal' => DuplicateChecker::normalkanEmail($request->email),
                    'no_hp' => $request->no_hp,
                    'no_hp_normal' => DuplicateChecker::normalkanNoHp($request->no_hp),
                    'catatan_kebutuhan' => $request->pesan,
                    'sumber' => 'Website',
                    'penanda' => $adaYangMirip ? 'Kemungkinan Duplikat' : null,
                ]);

                $lead->layanans()->attach($request->layanan);
            });
        } catch (\Throwable $e) {
            report($e);

            return back()->withInput()->withErrors([
                'formulir' => 'Maaf, terjadi kesalahan. Silakan coba lagi atau hubungi kami lewat WhatsApp di halaman Kontak.',
            ]);
        }

        return redirect()->route('website.konfirmasi');
    }
}
