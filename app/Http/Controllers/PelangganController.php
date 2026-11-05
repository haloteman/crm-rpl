<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Rules\NomorHp;
use App\Services\DuplicateChecker;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index(Request $request)
    {
        $query = Pelanggan::latest('tanggal_menjadi_pelanggan')->latest('id');

        if ($request->filled('cari')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%'.$request->cari.'%')
                    ->orWhere('no_hp', 'like', '%'.$request->cari.'%')
                    ->orWhere('email', 'like', '%'.$request->cari.'%')
                    ->orWhere('instagram', 'like', '%'.$request->cari.'%');
            });
        }

        return view('customer.index', [
            'semuaPelanggan' => $query->paginate(10)->withQueryString(),
            'totalPelanggan' => Pelanggan::count(),
        ]);
    }

    public function show(Pelanggan $pelanggan)
    {
        $pelanggan->load(['leads.layanans', 'riwayatInteraksis.pencatat', 'followUps']);

        return view('customer.show', [
            'pelanggan' => $pelanggan,
            'semuaLayanan' => $pelanggan->leads->pluck('layanans')->flatten()->pluck('nama')->unique(),
        ]);
    }

    public function edit(Pelanggan $pelanggan)
    {
        return view('customer.form', ['pelanggan' => $pelanggan]);
    }

    public function update(Request $request, Pelanggan $pelanggan)
    {
        $request->validate([
            'nama' => 'required|max:100',
            'instansi' => 'nullable|max:100',
            'no_hp' => ['bail', 'nullable', 'required_without_all:email,instagram', new NomorHp],
            'email' => 'nullable|email|max:255',
            'instagram' => 'nullable|max:100',
            'catatan' => 'nullable|max:1000',
        ], [
            'nama.required' => 'Nama wajib diisi',
            'nama.max' => 'Nama maksimal 100 karakter',
            'instansi.max' => 'Asal/instansi maksimal 100 karakter',
            'no_hp.required_without_all' => 'Isi minimal satu kontak: nomor HP, email, atau Instagram',
            'email.email' => 'Format email tidak valid',
            'email.max' => 'Email terlalu panjang',
            'instagram.max' => 'Instagram maksimal 100 karakter',
            'catatan.max' => 'Catatan maksimal 1.000 karakter',
        ]);

        $pelanggan->update([
            'nama' => $request->nama,
            'instansi' => $request->instansi,
            'no_hp' => $request->no_hp,
            'no_hp_normal' => DuplicateChecker::normalkanNoHp($request->no_hp),
            'email' => $request->email,
            'email_normal' => DuplicateChecker::normalkanEmail($request->email),
            'instagram' => $request->instagram,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('customer.show', $pelanggan)->with('status', 'Data pelanggan berhasil diubah');
    }
}
