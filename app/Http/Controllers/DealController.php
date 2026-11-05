<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DealController extends Controller
{
    public function tetapkan(Request $request, Lead $lead)
    {
        if (! auth()->user()->hasRole(Role::OWNER)) {
            abort(403);
        }

        if ($lead->status !== 'Negosiasi') {
            return back()->withErrors(['deal' => 'Deal hanya bisa ditetapkan untuk lead berstatus Negosiasi']);
        }

        if (! $lead->konsultasis()->where('status', 'Terlaksana')->exists()) {
            return back()->withErrors(['deal' => 'Deal belum bisa ditetapkan, belum ada konsultasi yang Terlaksana']);
        }

        $request->validate([
            'catatan_kesepakatan' => 'nullable|max:1000',
        ], [
            'catatan_kesepakatan.max' => 'Catatan kesepakatan maksimal 1.000 karakter',
        ]);

        $ringkasan = 'Lead ditetapkan Deal';

        if ($request->filled('catatan_kesepakatan')) {
            $ringkasan = $ringkasan.'. Catatan: '.$request->catatan_kesepakatan;
        }

        DB::transaction(function () use ($request, $lead, $ringkasan) {
            $lead->update([
                'status' => 'Deal',
                'catatan_kesepakatan' => $request->catatan_kesepakatan,
            ]);

            $lead->riwayatInteraksis()->create([
                'waktu' => now(),
                'jenis' => 'Penetapan Deal',
                'ringkasan' => $ringkasan,
                'status_lama' => 'Negosiasi',
                'status_baru' => 'Deal',
                'dibuat_oleh' => auth()->id(),
            ]);
        });

        return redirect()->route('leads.show', $lead)->with('status', 'Lead berhasil ditetapkan Deal');
    }
}
