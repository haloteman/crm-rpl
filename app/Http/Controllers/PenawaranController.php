<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Lead;
use App\Models\Penawaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function create()
    {
        return view('penawaran.form', [
            'penawaran' => null,
            'pilihanLead' => Lead::whereIn('status', ['Negosiasi', 'Deal'])
                ->whereDoesntHave('penawarans', fn ($q) => $q->where('status', '!=', 'Ditolak'))
                ->orderBy('nama')
                ->get(),
            'semuaLayanan' => Layanan::orderBy('id')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate(['lead_id' => 'required|exists:leads,id'], ['lead_id.*' => 'Pilih lead terlebih dahulu']);

        $lead = Lead::find($request->lead_id);

        if (! in_array($lead->status, ['Negosiasi', 'Deal'])) {
            return back()->withInput()->withErrors(['lead_id' => 'Penawaran hanya untuk lead berstatus Negosiasi atau Deal']);
        }

        $penawaranAktif = $lead->penawarans()->where('status', '!=', 'Ditolak')->first();

        if ($penawaranAktif) {
            return redirect()->route('penawaran.show', $penawaranAktif)->with('status', 'Lead ini sudah memiliki penawaran aktif');
        }

        $request->validate($this->aturanPenawaran(), $this->pesanPenawaran());

        $penawaran = DB::transaction(function () use ($request) {
            $penawaran = Penawaran::create([
                'lead_id' => $request->lead_id,
                'nomor_penawaran' => 'PNW-'.str_pad(Penawaran::count() + 1, 4, '0', STR_PAD_LEFT),
                'ruang_lingkup' => $request->ruang_lingkup,
                'nilai_penawaran' => $request->nilai_penawaran,
                'catatan_negosiasi' => $request->catatan_negosiasi,
                'dibuat_oleh' => auth()->id(),
            ]);

            $penawaran->layanans()->attach($request->layanan);

            return $penawaran;
        });

        return redirect()->route('penawaran.show', $penawaran)->with('status', 'Penawaran '.$penawaran->nomor_penawaran.' berhasil dibuat');
    }

    public function show(Penawaran $penawaran)
    {
        return view('penawaran.show', [
            'penawaran' => $penawaran->load(['lead', 'layanans', 'pembuat', 'pengubah', 'pengirim']),
        ]);
    }

    public function edit(Penawaran $penawaran)
    {
        if ($penawaran->sudahDiputuskan()) {
            return redirect()->route('penawaran.show', $penawaran)->withErrors(['penawaran' => 'Penawaran telah diputuskan dan datanya terkunci']);
        }

        return view('penawaran.form', [
            'penawaran' => $penawaran,
            'pilihanLead' => collect(),
            'semuaLayanan' => Layanan::orderBy('id')->get(),
        ]);
    }

    public function update(Request $request, Penawaran $penawaran)
    {
        if ($penawaran->sudahDiputuskan()) {
            return redirect()->route('penawaran.show', $penawaran)->withErrors(['penawaran' => 'Penawaran telah diputuskan dan datanya terkunci']);
        }

        $aturan = $this->aturanPenawaran();
        $pesan = $this->pesanPenawaran();

        if ($penawaran->harga_akhir !== null) {
            $aturan['nilai_penawaran'] = 'required|integer|min:'.$penawaran->harga_akhir.'|max:999999999';
            $pesan['nilai_penawaran.min'] = 'Nilai penawaran tidak boleh lebih kecil daripada harga akhir';
        }

        $request->validate($aturan, $pesan);

        DB::transaction(function () use ($request, $penawaran) {
            $penawaran->update([
                'ruang_lingkup' => $request->ruang_lingkup,
                'nilai_penawaran' => $request->nilai_penawaran,
                'catatan_negosiasi' => $request->catatan_negosiasi,
                'diubah_oleh' => auth()->id(),
            ]);

            $penawaran->layanans()->sync($request->layanan);
        });

        return redirect()->route('penawaran.show', $penawaran)->with('status', 'Penawaran berhasil diubah');
    }

    public function kirim(Penawaran $penawaran)
    {
        if ($penawaran->sudahDiputuskan()) {
            return back()->withErrors(['penawaran' => 'Penawaran telah diputuskan dan datanya terkunci']);
        }

        if ($penawaran->status !== 'Draf') {
            return back()->withErrors(['penawaran' => 'Perubahan status tidak sesuai urutan']);
        }

        $penawaran->update([
            'status' => 'Dikirim',
            'dikirim_oleh' => auth()->id(),
            'dikirim_at' => now(),
        ]);

        return back()->with('status', 'Penawaran ditandai Dikirim');
    }

    private function aturanPenawaran()
    {
        return [
            'layanan' => 'required|array',
            'layanan.*' => 'exists:layanans,id',
            'ruang_lingkup' => 'required|max:2000',
            'nilai_penawaran' => 'required|integer|min:1|max:999999999',
            'catatan_negosiasi' => 'nullable|max:2000',
        ];
    }

    private function pesanPenawaran()
    {
        return [
            'layanan.required' => 'Pilih minimal satu jenis layanan',
            'layanan.*.exists' => 'Pilih minimal satu jenis layanan',
            'ruang_lingkup.required' => 'Ruang lingkup layanan wajib diisi',
            'ruang_lingkup.max' => 'Ruang lingkup layanan maksimal 2.000 karakter',
            'nilai_penawaran.required' => 'Nilai harus bilangan bulat Rupiah lebih dari nol',
            'nilai_penawaran.integer' => 'Nilai harus bilangan bulat Rupiah lebih dari nol',
            'nilai_penawaran.min' => 'Nilai harus bilangan bulat Rupiah lebih dari nol',
            'nilai_penawaran.max' => 'Nilai penawaran maksimal Rp999.999.999',
            'catatan_negosiasi.max' => 'Catatan negosiasi maksimal 2.000 karakter',
        ];
    }
}
