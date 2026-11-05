<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Lead;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        $query = Lead::with(['layanans', 'penanggungJawab'])->latest();

        if ($request->filled('cari')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%'.$request->cari.'%')
                    ->orWhere('no_hp', 'like', '%'.$request->cari.'%')
                    ->orWhere('email', 'like', '%'.$request->cari.'%')
                    ->orWhere('instagram', 'like', '%'.$request->cari.'%');
            });
        }

        if ($request->filled('sumber')) {
            $query->where('sumber', $request->sumber);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('tipe_pemohon')) {
            $query->where('tipe_pemohon', $request->tipe_pemohon);
        }

        if ($request->filled('layanan')) {
            $query->whereRelation('layanans', 'layanans.id', $request->layanan);
        }

        $pesanTanggal = null;

        if ($request->filled('tanggal_awal') && $request->filled('tanggal_akhir') && $request->tanggal_akhir < $request->tanggal_awal) {
            $pesanTanggal = 'Tanggal akhir lebih awal dari tanggal awal, filter tanggal tidak dipakai.';
        } else {
            if ($request->filled('tanggal_awal')) {
                $query->whereDate('created_at', '>=', $request->tanggal_awal);
            }

            if ($request->filled('tanggal_akhir')) {
                $query->whereDate('created_at', '<=', $request->tanggal_akhir);
            }
        }

        return view('leads.index', [
            'leads' => $query->paginate(10)->withQueryString(),
            'totalLead' => Lead::count(),
            'totalLeadBaru' => Lead::where('is_baru', true)->count(),
            'semuaLayanan' => Layanan::orderBy('id')->get(),
            'pesanTanggal' => $pesanTanggal,
        ]);
    }
}
