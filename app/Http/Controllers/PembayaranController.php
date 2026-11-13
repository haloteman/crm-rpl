<?php

namespace App\Http\Controllers;

use App\Models\Kesepakatan;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PembayaranController extends Controller
{
    public function store(Request $request, Kesepakatan $kesepakatan)
    {
        $sisa = $kesepakatan->sisaTagihan();
        $pesanSisa = 'Jumlah harus bilangan bulat lebih dari nol dan tidak melebihi sisa tagihan Rp'.number_format($sisa, 0, ',', '.');

        $request->validate([
            'tanggal_bayar' => 'required|date|before_or_equal:today',
            'jumlah' => 'required|integer|min:1|max:'.$sisa,
            'metode' => ['required', Rule::in(Pembayaran::METODE)],
            'catatan' => 'nullable|max:500',
        ], [
            'tanggal_bayar.required' => 'Tanggal bayar wajib diisi',
            'tanggal_bayar.date' => 'Tanggal bayar tidak valid',
            'tanggal_bayar.before_or_equal' => 'Tanggal bayar tidak boleh di masa depan',
            'jumlah.*' => $pesanSisa,
            'metode.*' => 'Metode pembayaran wajib dipilih',
            'catatan.max' => 'Catatan maksimal 500 karakter',
        ]);

        DB::transaction(function () use ($request, $kesepakatan) {
            $kesepakatan->pembayarans()->create([
                'tanggal_bayar' => $request->tanggal_bayar,
                'jumlah' => $request->jumlah,
                'metode' => $request->metode,
                'catatan' => $request->catatan,
                'dibuat_oleh' => auth()->id(),
            ]);

            $kesepakatan->update([
                'status_pembayaran' => $kesepakatan->sisaTagihan() === 0 ? 'Lunas' : 'Dibayar Sebagian',
            ]);
        });

        return back()->with('status', 'Pembayaran berhasil dicatat');
    }
}
