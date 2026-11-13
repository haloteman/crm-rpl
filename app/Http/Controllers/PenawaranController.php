<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Penawaran;
use Illuminate\Http\Request;

class PenawaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Penawaran::with(['lead', 'layanans', 'kesepakatan'])->latest()->orderByDesc('id');

        if ($request->filled('cari')) {
            $query->where(function ($q) use ($request) {
                $q->where('nomor_penawaran', 'like', '%'.$request->cari.'%')
                    ->orWhereRelation('lead', 'nama', 'like', '%'.$request->cari.'%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('layanan')) {
            $query->whereRelation('layanans', 'layanans.id', $request->layanan);
        }

        if ($request->filled('status_pembayaran')) {
            $query->whereRelation('kesepakatan', 'status_pembayaran', $request->status_pembayaran);
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

        return view('penawaran.index', [
            'penawarans' => $query->paginate(10)->withQueryString(),
            'totalPenawaran' => Penawaran::count(),
            'totalDikirim' => Penawaran::where('status', 'Dikirim')->count(),
            'totalWon' => Penawaran::where('status', 'Disetujui')->count(),
            'totalLost' => Penawaran::where('status', 'Ditolak')->count(),
            'semuaLayanan' => Layanan::orderBy('id')->get(),
            'pesanTanggal' => $pesanTanggal,
        ]);
    }
}
