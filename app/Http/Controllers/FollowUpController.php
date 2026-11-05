<?php

namespace App\Http\Controllers;

use App\Models\FollowUp;
use App\Models\Lead;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FollowUpController extends Controller
{
    public function store(Request $request, Lead $lead)
    {
        $this->validasi($request);

        $lead->followUps()->create([
            'pelanggan_id' => $lead->pelanggan_id,
            'tanggal' => $request->tanggal,
            'jenis' => $request->jenis,
            'catatan_tujuan' => $request->catatan_tujuan,
            'dibuat_oleh' => auth()->id(),
        ]);

        return redirect()->route('leads.show', $lead)->with('status', 'Follow-up berhasil dijadwalkan');
    }

    public function storePelanggan(Request $request, Pelanggan $pelanggan)
    {
        $this->validasi($request);

        $pelanggan->followUps()->create([
            'tanggal' => $request->tanggal,
            'jenis' => $request->jenis,
            'catatan_tujuan' => $request->catatan_tujuan,
            'dibuat_oleh' => auth()->id(),
        ]);

        return redirect()->route('customer.show', $pelanggan)->with('status', 'Follow-up berhasil dijadwalkan');
    }

    private function validasi(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date|after_or_equal:today',
            'jenis' => ['required', Rule::in(FollowUp::JENIS)],
            'catatan_tujuan' => 'nullable|max:1000',
        ], [
            'tanggal.required' => 'Tanggal follow-up wajib diisi',
            'tanggal.date' => 'Tanggal follow-up tidak valid',
            'tanggal.after_or_equal' => 'Tanggal follow-up tidak boleh sebelum hari ini',
            'jenis.required' => 'Jenis follow-up wajib dipilih',
            'jenis.in' => 'Jenis follow-up tidak tersedia',
            'catatan_tujuan.max' => 'Catatan tujuan maksimal 1.000 karakter',
        ]);
    }

    public function selesai(FollowUp $followUp)
    {
        $followUp->update([
            'selesai' => true,
            'selesai_pada' => now(),
        ]);

        return back()->with('status', 'Follow-up ditandai selesai');
    }
}
