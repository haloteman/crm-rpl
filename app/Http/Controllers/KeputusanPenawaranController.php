<?php

namespace App\Http\Controllers;

use App\Models\Penawaran;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class KeputusanPenawaranController extends Controller
{
    public function hargaAkhir(Request $request, Penawaran $penawaran)
    {
        if (! auth()->user()->hasRole(Role::OWNER)) {
            abort(403);
        }

        if ($penawaran->sudahDiputuskan()) {
            return back()->withErrors(['penawaran' => 'Penawaran telah diputuskan dan datanya terkunci']);
        }

        if ($penawaran->status !== 'Dikirim') {
            return back()->withErrors(['harga_akhir' => 'Harga akhir hanya bisa ditetapkan pada penawaran berstatus Dikirim']);
        }

        $request->validate([
            'harga_akhir' => 'required|integer|min:1|max:'.$penawaran->nilai_penawaran,
        ], [
            'harga_akhir.required' => 'Harga akhir wajib diisi',
            'harga_akhir.integer' => 'Harga akhir harus bilangan bulat Rupiah lebih dari nol',
            'harga_akhir.min' => 'Harga akhir harus bilangan bulat Rupiah lebih dari nol',
            'harga_akhir.max' => 'Harga akhir tidak boleh lebih besar daripada nilai penawaran',
        ]);

        $penawaran->update([
            'harga_akhir' => $request->harga_akhir,
            'harga_akhir_oleh' => auth()->id(),
            'harga_akhir_at' => now(),
        ]);

        return back()->with('status', 'Harga akhir berhasil ditetapkan');
    }

    public function won(Penawaran $penawaran)
    {
        if (! auth()->user()->hasRole(Role::OWNER)) {
            abort(403);
        }

        if ($penawaran->sudahDiputuskan()) {
            return back()->withErrors(['penawaran' => 'Penawaran telah diputuskan dan datanya terkunci']);
        }

        if ($penawaran->status !== 'Dikirim' || $penawaran->harga_akhir === null || $penawaran->lead->status !== 'Deal') {
            return back()->withErrors(['keputusan' => 'Syarat Won belum terpenuhi']);
        }

        $penawaran->update([
            'status' => 'Disetujui',
            'diputuskan_oleh' => auth()->id(),
            'diputuskan_at' => now(),
        ]);

        return back()->with('status', 'Penawaran ditetapkan Won');
    }

    public function lost(Request $request, Penawaran $penawaran)
    {
        if (! auth()->user()->hasRole(Role::OWNER)) {
            abort(403);
        }

        if ($penawaran->sudahDiputuskan()) {
            return back()->withErrors(['penawaran' => 'Penawaran telah diputuskan dan datanya terkunci']);
        }

        $request->validate([
            'alasan_lost' => ['required', Rule::in(Penawaran::ALASAN_LOST)],
            'catatan_lost' => 'nullable|max:1000',
        ], [
            'alasan_lost.*' => 'Alasan Lost wajib dipilih',
            'catatan_lost.max' => 'Catatan maksimal 1.000 karakter',
        ]);

        DB::transaction(function () use ($request, $penawaran) {
            $penawaran->update([
                'status' => 'Ditolak',
                'alasan_lost' => $request->alasan_lost,
                'catatan_lost' => $request->catatan_lost,
                'diputuskan_oleh' => auth()->id(),
                'diputuskan_at' => now(),
            ]);

            $lead = $penawaran->lead;

            if ($lead->status !== 'Tidak Berlanjut') {
                $statusLama = $lead->status;

                $lead->update([
                    'status' => 'Tidak Berlanjut',
                    'alasan_tidak_berlanjut' => $request->alasan_lost,
                ]);

                $lead->riwayatInteraksis()->create([
                    'waktu' => now(),
                    'jenis' => 'Perubahan Status',
                    'ringkasan' => 'Status diubah dari '.$statusLama.' ke Tidak Berlanjut karena penawaran '.$penawaran->nomor_penawaran.' Lost. Alasan: '.$request->alasan_lost,
                    'status_lama' => $statusLama,
                    'status_baru' => 'Tidak Berlanjut',
                    'dibuat_oleh' => auth()->id(),
                ]);
            }
        });

        return back()->with('status', 'Penawaran ditetapkan Lost');
    }
}
