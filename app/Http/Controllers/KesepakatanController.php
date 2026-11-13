<?php

namespace App\Http\Controllers;

use App\Models\Kesepakatan;
use App\Models\Penawaran;
use Illuminate\Http\Request;

class KesepakatanController extends Controller
{
    public function store(Request $request, Penawaran $penawaran)
    {
        if ($penawaran->status !== 'Disetujui') {
            return back()->withErrors(['kesepakatan' => 'Kesepakatan hanya bisa dicatat pada penawaran yang sudah Won']);
        }

        if ($penawaran->kesepakatan) {
            return back()->withErrors(['kesepakatan' => 'Penawaran ini sudah memiliki kesepakatan']);
        }

        $request->validate($this->aturan(), $this->pesan());

        Kesepakatan::create([
            'penawaran_id' => $penawaran->id,
            'nilai_kesepakatan' => $penawaran->harga_akhir,
            'ketentuan_pekerjaan' => $request->ketentuan_pekerjaan,
            'tanggal_kesepakatan' => $request->tanggal_kesepakatan,
            'masa_kontrak_mulai' => $request->masa_kontrak_mulai,
            'masa_kontrak_selesai' => $request->masa_kontrak_selesai,
            'frekuensi_update_progres' => $request->frekuensi_update_progres,
            'dibuat_oleh' => auth()->id(),
        ]);

        return back()->with('status', 'Kesepakatan berhasil dicatat');
    }

    public function update(Request $request, Kesepakatan $kesepakatan)
    {
        if ($kesepakatan->pembayarans()->exists()) {
            return back()->withErrors(['kesepakatan' => 'Kesepakatan tidak dapat diubah karena pembayaran telah tercatat']);
        }

        $request->validate($this->aturan(), $this->pesan());

        $kesepakatan->update([
            'ketentuan_pekerjaan' => $request->ketentuan_pekerjaan,
            'tanggal_kesepakatan' => $request->tanggal_kesepakatan,
            'masa_kontrak_mulai' => $request->masa_kontrak_mulai,
            'masa_kontrak_selesai' => $request->masa_kontrak_selesai,
            'frekuensi_update_progres' => $request->frekuensi_update_progres,
            'diubah_oleh' => auth()->id(),
        ]);

        return back()->with('status', 'Kesepakatan berhasil diubah');
    }

    private function aturan()
    {
        return [
            'ketentuan_pekerjaan' => 'required|max:2000',
            'tanggal_kesepakatan' => 'required|date|before_or_equal:today',
            'masa_kontrak_mulai' => 'nullable|date',
            'masa_kontrak_selesai' => 'nullable|date|after_or_equal:masa_kontrak_mulai',
            'frekuensi_update_progres' => 'nullable|max:100',
        ];
    }

    private function pesan()
    {
        return [
            'ketentuan_pekerjaan.required' => 'Ketentuan pekerjaan wajib diisi',
            'ketentuan_pekerjaan.max' => 'Ketentuan pekerjaan maksimal 2.000 karakter',
            'tanggal_kesepakatan.required' => 'Tanggal kesepakatan wajib diisi',
            'tanggal_kesepakatan.date' => 'Tanggal kesepakatan tidak valid',
            'tanggal_kesepakatan.before_or_equal' => 'Tanggal kesepakatan tidak boleh di masa depan',
            'masa_kontrak_mulai.date' => 'Tanggal mulai tidak valid',
            'masa_kontrak_selesai.date' => 'Tanggal selesai tidak valid',
            'masa_kontrak_selesai.after_or_equal' => 'Tanggal selesai tidak boleh sebelum tanggal mulai',
            'frekuensi_update_progres.max' => 'Frekuensi update progres maksimal 100 karakter',
        ];
    }
}
