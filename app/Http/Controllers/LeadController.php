<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Lead;
use App\Models\Role;
use App\Models\User;
use App\Services\DuplicateChecker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class LeadController extends Controller
{
    public function index(Request $request)
    {
        $query = Lead::with(['layanans', 'penanggungJawab'])->latest();

        $query->withExists(['followUps as ada_pengingat' => function ($q) {
            $q->where('selesai', false)->whereDate('tanggal', '<=', today());
        }]);

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

    public function create()
    {
        return view('leads.form', [
            'lead' => null,
            'semuaLayanan' => Layanan::orderBy('id')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $aturan = $this->aturanLead();
        $aturan['sumber'] = ['required', Rule::in(Lead::SUMBER_MANUAL)];

        $request->validate($aturan, $this->pesanLead());

        $leadMirip = DuplicateChecker::cariLeadMirip($request->no_hp, $request->email);

        if ($leadMirip->isNotEmpty() && ! $request->boolean('tetap_simpan')) {
            return back()->withInput()->with('leadMirip', $leadMirip->pluck('nama', 'id'));
        }

        DB::transaction(function () use ($request) {
            $lead = Lead::create([
                'nama' => $request->nama,
                'instansi' => $request->instansi,
                'tipe_pemohon' => $request->tipe_pemohon,
                'no_hp' => $request->no_hp,
                'no_hp_normal' => DuplicateChecker::normalkanNoHp($request->no_hp),
                'email' => $request->email,
                'email_normal' => DuplicateChecker::normalkanEmail($request->email),
                'instagram' => $request->instagram,
                'sumber' => $request->sumber,
                'catatan_kebutuhan' => $request->catatan_kebutuhan,
                'is_baru' => false,
                'penanggung_jawab_id' => auth()->id(),
            ]);

            $lead->layanans()->attach($request->layanan);
        });

        return redirect()->route('leads')->with('status', 'Lead '.$request->nama.' berhasil ditambahkan');
    }

    public function show(Lead $lead)
    {
        if ($lead->is_baru) {
            $lead->update(['is_baru' => false]);
        }

        $lead->load(['layanans', 'penanggungJawab', 'riwayatInteraksis.pencatat', 'followUps']);

        return view('leads.show', [
            'lead' => $lead,
            'statusDiizinkan' => $lead->statusDiizinkan(auth()->user()),
            'semuaAdmin' => User::role(Role::ADMIN)->orderBy('name')->get(),
        ]);
    }

    public function edit(Lead $lead)
    {
        if ($lead->status === 'Terkonversi') {
            abort(403);
        }

        return view('leads.form', [
            'lead' => $lead,
            'semuaLayanan' => Layanan::orderBy('id')->get(),
        ]);
    }

    public function update(Request $request, Lead $lead)
    {
        if ($lead->status === 'Terkonversi') {
            abort(403);
        }

        $request->validate($this->aturanLead(), $this->pesanLead());

        $noHpNormal = DuplicateChecker::normalkanNoHp($request->no_hp);
        $emailNormal = DuplicateChecker::normalkanEmail($request->email);
        $kontakBerubah = $noHpNormal !== $lead->no_hp_normal || $emailNormal !== $lead->email_normal;

        if ($kontakBerubah && ! $request->boolean('tetap_simpan')) {
            $leadMirip = DuplicateChecker::cariLeadMirip($request->no_hp, $request->email, $lead->id);

            if ($leadMirip->isNotEmpty()) {
                return back()->withInput()->with('leadMirip', $leadMirip->pluck('nama', 'id'));
            }
        }

        DB::transaction(function () use ($request, $lead, $noHpNormal, $emailNormal) {
            $lead->update([
                'nama' => $request->nama,
                'instansi' => $request->instansi,
                'tipe_pemohon' => $request->tipe_pemohon,
                'no_hp' => $request->no_hp,
                'no_hp_normal' => $noHpNormal,
                'email' => $request->email,
                'email_normal' => $emailNormal,
                'instagram' => $request->instagram,
                'catatan_kebutuhan' => $request->catatan_kebutuhan,
            ]);

            $lead->layanans()->sync($request->layanan);
        });

        return redirect()->route('leads.show', $lead)->with('status', 'Data lead '.$lead->nama.' berhasil diubah');
    }

    public function destroy(Lead $lead)
    {
        if ($lead->status === 'Terkonversi') {
            abort(403);
        }

        $lead->delete();

        return redirect()->route('leads')->with('status', 'Lead '.$lead->nama.' berhasil dihapus');
    }

    public function updateStatus(Request $request, Lead $lead)
    {
        $statusDiizinkan = $lead->statusDiizinkan(auth()->user());

        $request->validate([
            'status_baru' => ['required', Rule::in($statusDiizinkan)],
            'alasan' => 'nullable|required_if:status_baru,Tidak Berlanjut|max:255',
        ], [
            'status_baru.required' => 'Status baru wajib dipilih',
            'status_baru.in' => 'Status tidak sesuai alur. Pilihan yang diizinkan: '.implode(', ', $statusDiizinkan),
            'alasan.required_if' => 'Alasan wajib diisi untuk status Tidak Berlanjut',
            'alasan.max' => 'Alasan maksimal 255 karakter',
        ]);

        $statusLama = $lead->status;
        $ringkasan = 'Status diubah dari '.$statusLama.' ke '.$request->status_baru;
        $alasan = null;

        if ($request->status_baru === 'Tidak Berlanjut') {
            $alasan = $request->alasan;
            $ringkasan = $ringkasan.'. Alasan: '.$alasan;
        }

        DB::transaction(function () use ($request, $lead, $statusLama, $ringkasan, $alasan) {
            $lead->update([
                'status' => $request->status_baru,
                'alasan_tidak_berlanjut' => $alasan,
            ]);

            $lead->riwayatInteraksis()->create([
                'waktu' => now(),
                'jenis' => 'Perubahan Status',
                'ringkasan' => $ringkasan,
                'status_lama' => $statusLama,
                'status_baru' => $request->status_baru,
                'dibuat_oleh' => auth()->id(),
            ]);
        });

        return redirect()->route('leads.show', $lead)->with('status', 'Status lead berhasil diubah');
    }

    public function tetapkanPenanggungJawab(Request $request, Lead $lead)
    {
        $semuaAdmin = User::role(Role::ADMIN)->pluck('id');

        $request->validate([
            'penanggung_jawab_id' => ['required', Rule::in($semuaAdmin)],
        ], [
            'penanggung_jawab_id.required' => 'Penanggung jawab wajib dipilih',
            'penanggung_jawab_id.in' => 'Akun Admin tidak tersedia',
        ]);

        $admin = User::find($request->penanggung_jawab_id);

        DB::transaction(function () use ($lead, $admin) {
            $lead->update(['penanggung_jawab_id' => $admin->id]);

            $lead->riwayatInteraksis()->create([
                'waktu' => now(),
                'jenis' => 'Penanggung Jawab',
                'ringkasan' => 'Penanggung jawab ditetapkan ke '.$admin->name,
                'dibuat_oleh' => auth()->id(),
            ]);
        });

        return redirect()->route('leads.show', $lead)->with('status', 'Penanggung jawab berhasil ditetapkan');
    }

    private function aturanLead()
    {
        return [
            'nama' => 'required|max:100',
            'instansi' => 'nullable|max:100',
            'tipe_pemohon' => ['required', Rule::in(Lead::TIPE_PEMOHON)],
            'no_hp' => ['bail', 'nullable', 'required_without_all:email,instagram', 'regex:/^\+?[0-9 \-]+$/', function ($attribute, $value, $fail) {
                $jumlahAngka = strlen(preg_replace('/[^0-9]/', '', $value));

                if ($jumlahAngka < 9 || $jumlahAngka > 15) {
                    $fail('Nomor HP harus 9 sampai 15 angka');
                }
            }],
            'email' => 'nullable|email|max:255',
            'instagram' => 'nullable|max:100',
            'layanan' => 'required|array',
            'layanan.*' => 'exists:layanans,id',
            'catatan_kebutuhan' => 'nullable|max:1000',
        ];
    }

    private function pesanLead()
    {
        return [
            'nama.required' => 'Nama wajib diisi',
            'nama.max' => 'Nama maksimal 100 karakter',
            'instansi.max' => 'Asal/instansi maksimal 100 karakter',
            'tipe_pemohon.required' => 'Tipe pemohon wajib dipilih',
            'tipe_pemohon.in' => 'Tipe pemohon tidak tersedia',
            'no_hp.required_without_all' => 'Isi minimal satu kontak: nomor HP, email, atau Instagram',
            'no_hp.regex' => 'Nomor HP hanya boleh berisi angka, spasi, tanda hubung, dan awalan +',
            'email.email' => 'Format email tidak valid',
            'email.max' => 'Email terlalu panjang',
            'instagram.max' => 'Instagram maksimal 100 karakter',
            'layanan.required' => 'Pilih minimal satu layanan',
            'layanan.array' => 'Layanan tidak tersedia',
            'layanan.*.exists' => 'Layanan tidak tersedia',
            'sumber.required' => 'Sumber wajib dipilih',
            'sumber.in' => 'Sumber tidak tersedia',
            'catatan_kebutuhan.max' => 'Catatan kebutuhan maksimal 1.000 karakter',
        ];
    }
}
