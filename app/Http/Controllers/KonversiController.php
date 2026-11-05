<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KonversiController extends Controller
{
    public function konversi(Request $request, Lead $lead)
    {
        if ($lead->status !== 'Deal') {
            return back()->withErrors(['konversi' => 'Lead belum dapat dikonversi, statusnya harus Deal']);
        }

        $pelangganSama = $lead->pelangganSama();

        if ($pelangganSama->isNotEmpty() && ! $pelangganSama->contains('id', $request->pelanggan_id)) {
            return back()->withErrors(['konversi' => 'Pilih pelanggan yang akan ditautkan']);
        }

        DB::transaction(function () use ($request, $lead, $pelangganSama) {
            if ($pelangganSama->isNotEmpty()) {
                $pelanggan = Pelanggan::find($request->pelanggan_id);
                $ringkasan = 'Lead dikonversi dan ditautkan ke pelanggan '.$pelanggan->nama;
            } else {
                $pelanggan = Pelanggan::create([
                    'nama' => $lead->nama,
                    'instansi' => $lead->instansi,
                    'no_hp' => $lead->no_hp,
                    'no_hp_normal' => $lead->no_hp_normal,
                    'email' => $lead->email,
                    'email_normal' => $lead->email_normal,
                    'instagram' => $lead->instagram,
                    'sumber_awal' => $lead->sumber,
                    'catatan' => $lead->catatan_kebutuhan,
                    'tanggal_menjadi_pelanggan' => today(),
                ]);
                $ringkasan = 'Lead dikonversi menjadi pelanggan baru';
            }

            $lead->update([
                'status' => 'Terkonversi',
                'pelanggan_id' => $pelanggan->id,
            ]);

            $lead->riwayatInteraksis()->create([
                'waktu' => now(),
                'jenis' => 'Konversi',
                'ringkasan' => $ringkasan,
                'status_lama' => 'Deal',
                'status_baru' => 'Terkonversi',
                'dibuat_oleh' => auth()->id(),
            ]);

            // semua catatan lead ikut ditautkan ke pelanggan
            $lead->riwayatInteraksis()->update(['pelanggan_id' => $pelanggan->id]);
            $lead->followUps()->update(['pelanggan_id' => $pelanggan->id]);
            $lead->konsultasis()->update(['pelanggan_id' => $pelanggan->id]);
        });

        return redirect()->route('leads.show', $lead)->with('status', 'Lead berhasil dikonversi menjadi pelanggan');
    }
}
