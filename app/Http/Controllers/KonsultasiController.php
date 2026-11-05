<?php

namespace App\Http\Controllers;

use App\Models\Konsultasi;
use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class KonsultasiController extends Controller
{
    public function store(Request $request, Lead $lead)
    {
        if ($lead->status !== 'Negosiasi') {
            return back()->withErrors(['konsultasi' => 'Konsultasi hanya bisa dijadwalkan untuk lead berstatus Negosiasi']);
        }

        $request->validate([
            'tanggal_konsultasi' => 'required|date|after_or_equal:today',
            'waktu_konsultasi' => 'required|date_format:H:i',
            'tempat' => 'required|max:150',
            'peserta' => 'nullable|max:255',
            'catatan' => 'nullable|max:1000',
        ], [
            'tanggal_konsultasi.required' => 'Tanggal konsultasi wajib diisi',
            'tanggal_konsultasi.date' => 'Tanggal konsultasi tidak valid',
            'tanggal_konsultasi.after_or_equal' => 'Tanggal konsultasi tidak boleh sebelum hari ini',
            'waktu_konsultasi.required' => 'Waktu konsultasi wajib diisi',
            'waktu_konsultasi.date_format' => 'Waktu konsultasi tidak valid',
            'tempat.required' => 'Tempat konsultasi wajib diisi',
            'tempat.max' => 'Tempat maksimal 150 karakter',
            'peserta.max' => 'Peserta maksimal 255 karakter',
            'catatan.max' => 'Catatan maksimal 1.000 karakter',
        ]);

        DB::transaction(function () use ($request, $lead) {
            $lead->konsultasis()->create([
                'tanggal' => $request->tanggal_konsultasi,
                'waktu' => $request->waktu_konsultasi,
                'tempat' => $request->tempat,
                'peserta' => $request->peserta,
                'catatan' => $request->catatan,
                'dibuat_oleh' => auth()->id(),
            ]);

            $lead->riwayatInteraksis()->create([
                'waktu' => now(),
                'jenis' => 'Jadwal Konsultasi',
                'ringkasan' => 'Konsultasi dijadwalkan '.date('d/m/Y', strtotime($request->tanggal_konsultasi)).' pukul '.$request->waktu_konsultasi.' di '.$request->tempat,
                'dibuat_oleh' => auth()->id(),
            ]);
        });

        return redirect()->route('leads.show', $lead)->with('status', 'Konsultasi berhasil dijadwalkan');
    }

    public function updateHasil(Request $request, Konsultasi $konsultasi)
    {
        if ($konsultasi->status !== 'Dijadwalkan') {
            return back()->withErrors(['konsultasi' => 'Konsultasi ini sudah '.$konsultasi->status]);
        }

        $request->validate([
            'status_konsultasi' => ['required', Rule::in(['Terlaksana', 'Dibatalkan'])],
            'hasil' => 'required_if:status_konsultasi,Terlaksana|prohibited_unless:status_konsultasi,Terlaksana|max:1000',
        ], [
            'status_konsultasi.required' => 'Status konsultasi wajib dipilih',
            'status_konsultasi.in' => 'Status konsultasi tidak tersedia',
            'hasil.required_if' => 'Hasil konsultasi wajib diisi',
            'hasil.prohibited_unless' => 'Hasil hanya diisi untuk konsultasi yang Terlaksana',
            'hasil.max' => 'Hasil maksimal 1.000 karakter',
        ]);

        $ringkasan = 'Konsultasi '.$konsultasi->tanggal->format('d/m/Y').' dibatalkan';

        if ($request->status_konsultasi === 'Terlaksana') {
            $ringkasan = 'Konsultasi '.$konsultasi->tanggal->format('d/m/Y').' terlaksana. Hasil: '.$request->hasil;
        }

        DB::transaction(function () use ($request, $konsultasi, $ringkasan) {
            $konsultasi->update([
                'status' => $request->status_konsultasi,
                'hasil' => $request->hasil,
            ]);

            $konsultasi->lead->riwayatInteraksis()->create([
                'waktu' => now(),
                'jenis' => 'Hasil Konsultasi',
                'ringkasan' => $ringkasan,
                'dibuat_oleh' => auth()->id(),
            ]);
        });

        return redirect()->route('leads.show', $konsultasi->lead_id)->with('status', 'Hasil konsultasi berhasil disimpan');
    }
}
