@extends('layouts.app')
@section('title', 'Leads')
@section('heading', 'Leads')

@section('content')
<div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
    <div>
        <h1 class="text-[28px] font-bold leading-tight">Leads</h1>
        <p class="mt-1 text-sm text-slate-500">Semua calon pelanggan dari Instagram, WhatsApp, Email, dan Website.</p>
    </div>
    <a href="{{ route('leads.create') }}" class="btn-primary w-full sm:w-auto">Tambah Lead</a>
</div>

<div class="mt-5 grid gap-4 sm:grid-cols-2 md:w-[520px]">
    <div class="card px-5 py-4">
        <div class="text-sm text-slate-500">Total Lead</div>
        <div class="text-3xl font-semibold">{{ $totalLead }}</div>
    </div>
    <div class="card px-5 py-4">
        <div class="text-sm text-slate-500">Lead Baru</div>
        <div class="text-3xl font-semibold text-brand-dark">{{ $totalLeadBaru }}</div>
    </div>
</div>

<section class="card mt-5">
    <form method="GET" action="{{ route('leads') }}" class="grid gap-3 px-4 pt-4 sm:grid-cols-2 sm:px-5 lg:grid-cols-4">
        <input type="search" name="cari" value="{{ request('cari') }}" placeholder="Cari nama atau kontak" class="field sm:col-span-2">

        <select name="sumber" class="field">
            <option value="">Semua Sumber</option>
            @foreach (\App\Models\Lead::SUMBER as $sumber)
                <option value="{{ $sumber }}" @selected(request('sumber') === $sumber)>{{ $sumber }}</option>
            @endforeach
        </select>

        <select name="status" class="field">
            <option value="">Semua Status</option>
            @foreach (\App\Models\Lead::STATUS as $status)
                <option value="{{ $status }}" @selected(request('status') === $status)>{{ $status }}</option>
            @endforeach
        </select>

        <select name="layanan" class="field">
            <option value="">Semua Layanan</option>
            @foreach ($semuaLayanan as $layanan)
                <option value="{{ $layanan->id }}" @selected(request('layanan') == $layanan->id)>{{ $layanan->nama }}</option>
            @endforeach
        </select>

        <select name="tipe_pemohon" class="field">
            <option value="">Semua Tipe Pemohon</option>
            @foreach (\App\Models\Lead::TIPE_PEMOHON as $tipe)
                <option value="{{ $tipe }}" @selected(request('tipe_pemohon') === $tipe)>{{ $tipe }}</option>
            @endforeach
        </select>

        <label class="text-xs text-slate-500">Dari tanggal
            <input type="date" name="tanggal_awal" value="{{ request('tanggal_awal') }}" class="field mt-1">
        </label>
        <label class="text-xs text-slate-500">Sampai tanggal
            <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}" class="field mt-1">
        </label>

        <div class="flex gap-3 sm:col-span-2 lg:col-span-4">
            <button type="submit" class="btn-primary">Terapkan</button>
            <a href="{{ route('leads') }}" class="btn-outline">Hapus Filter</a>
        </div>
    </form>

    @if ($pesanTanggal)
        <p class="mx-4 mt-3 rounded-lg bg-warn-tint px-4 py-2 text-sm text-warn sm:mx-5">{{ $pesanTanggal }}</p>
    @endif

    <div class="mt-4 overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-thead text-xs text-slate-500">
                <tr>
                    <th class="px-5 py-3 font-medium">Nama</th>
                    <th class="px-5 py-3 font-medium">Kontak</th>
                    <th class="px-5 py-3 font-medium">Layanan</th>
                    <th class="px-5 py-3 font-medium">Sumber</th>
                    <th class="px-5 py-3 font-medium">Status</th>
                    <th class="px-5 py-3 font-medium">Penanggung Jawab</th>
                    <th class="px-5 py-3 font-medium">Tanggal Masuk</th>
                    <th class="px-5 py-3 font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($leads as $lead)
                    <tr class="border-t align-top">
                        <td class="px-5 py-3">
                            <div class="font-medium">
                                <a href="{{ route('leads.show', $lead) }}" class="hover:underline">{{ $lead->nama }}</a>
                                @if ($lead->is_baru)
                                    <span class="ml-1 rounded-md bg-tint px-1.5 py-0.5 text-[11px] font-medium text-brand-dark">Baru masuk</span>
                                @endif
                                @if ($lead->ada_pengingat)
                                    <span class="ml-1 rounded-md bg-lost-tint px-1.5 py-0.5 text-[11px] font-medium text-lost">Follow-up jatuh tempo</span>
                                @endif
                                @if ($lead->penanda)
                                    <span class="ml-1 rounded-md bg-warn-tint px-1.5 py-0.5 text-[11px] font-medium text-warn">{{ $lead->penanda }}</span>
                                @endif
                            </div>
                            @if ($lead->instansi)
                                <div class="text-xs text-slate-500">{{ $lead->instansi }}</div>
                            @endif
                        </td>
                        <td class="px-5 py-3">
                            @if ($lead->no_hp) <div>{{ $lead->no_hp }}</div> @endif
                            @if ($lead->email) <div>{{ $lead->email }}</div> @endif
                            @if ($lead->instagram) <div>{{ $lead->instagram }}</div> @endif
                        </td>
                        <td class="px-5 py-3">{{ $lead->layanans->pluck('nama')->implode(', ') }}</td>
                        <td class="px-5 py-3">{{ $lead->sumber }}</td>
                        <td class="px-5 py-3">{{ $lead->status }}</td>
                        <td class="px-5 py-3">{{ $lead->penanggungJawab->name ?? 'Belum ditugaskan' }}</td>
                        <td class="px-5 py-3">{{ $lead->created_at->format('d/m/Y') }}</td>
                        <td class="px-5 py-3">
                            <a href="{{ route('leads.show', $lead) }}" class="text-xs font-medium text-brand-dark hover:underline">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr class="border-t">
                        <td colspan="8" class="px-5 py-8 text-center text-slate-500">
                            {{ request()->except('page') ? 'Data tidak ditemukan' : 'Belum ada lead' }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="flex flex-col gap-3 border-t px-4 py-4 text-xs text-slate-500 sm:flex-row sm:items-center sm:justify-between sm:px-5">
        <span>Menampilkan {{ $leads->firstItem() ?? 0 }}–{{ $leads->lastItem() ?? 0 }} dari {{ $leads->total() }} lead</span>
        <div>{{ $leads->links() }}</div>
    </div>
</section>

@endsection
