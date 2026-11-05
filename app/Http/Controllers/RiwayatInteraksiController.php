<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Pelanggan;
use App\Models\RiwayatInteraksi;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RiwayatInteraksiController extends Controller
{
    public function store(Request $request, Lead $lead)
    {
        $this->validasi($request);

        $lead->riwayatInteraksis()->create([
            'pelanggan_id' => $lead->pelanggan_id,
            'waktu' => $request->waktu,
            'jenis' => 'Interaksi',
            'kanal' => $request->kanal,
            'ringkasan' => $request->ringkasan,
            'dibuat_oleh' => auth()->id(),
        ]);

        return redirect()->route('leads.show', $lead)->with('status', 'Catatan interaksi berhasil ditambahkan');
    }

    public function storePelanggan(Request $request, Pelanggan $pelanggan)
    {
        $this->validasi($request);

        $pelanggan->riwayatInteraksis()->create([
            'waktu' => $request->waktu,
            'jenis' => 'Interaksi',
            'kanal' => $request->kanal,
            'ringkasan' => $request->ringkasan,
            'dibuat_oleh' => auth()->id(),
        ]);

        return redirect()->route('customer.show', $pelanggan)->with('status', 'Catatan interaksi berhasil ditambahkan');
    }

    private function validasi(Request $request)
    {
        $request->validate([
            'waktu' => 'required|date',
            'kanal' => ['required', Rule::in(RiwayatInteraksi::KANAL)],
            'ringkasan' => 'required|max:1000',
        ], [
            'waktu.required' => 'Tanggal dan waktu wajib diisi',
            'waktu.date' => 'Tanggal dan waktu tidak valid',
            'kanal.required' => 'Kanal wajib dipilih',
            'kanal.in' => 'Kanal tidak tersedia',
            'ringkasan.required' => 'Ringkasan wajib diisi',
            'ringkasan.max' => 'Ringkasan maksimal 1.000 karakter',
        ]);
    }
}
