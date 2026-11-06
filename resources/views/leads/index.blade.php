@extends('layouts.app')
@section('title', 'Leads')
@section('heading', 'Leads')

@section('content')
<div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
    <div>
        <h1 class="page-title">Leads</h1>
        <p class="page-sub">Semua calon pelanggan dari Instagram, WhatsApp, Email, dan Website.</p>
    </div>
    <a href="{{ route('leads.create') }}" class="btn-primary w-full sm:w-auto">
        <x-icon name="plus" class="size-4" /> Tambah Lead
    </a>
</div>

{{-- ringkasan --}}
<div class="mt-6 grid grid-cols-2 gap-4 md:max-w-xl">
    <div class="card px-5 py-4">
        <div class="text-xs text-slate-500">Total Lead</div>
        <div class="mt-2 text-[28px] font-semibold leading-none text-brand-dark">{{ $totalLead }}</div>
    </div>
    <div class="card px-5 py-4">
        <div class="text-xs text-slate-500">Lead Baru</div>
        <div class="mt-2 text-[28px] font-semibold leading-none">{{ $totalLeadBaru }}</div>
    </div>
</div>

<section class="card mt-6">
    <div class="flex items-center justify-between gap-3 px-4 pt-4 sm:px-5">
        <h2 class="text-base font-semibold">Semua lead</h2>
        <span class="text-xs font-medium text-brand-dark">{{ $leads->total() }} lead terdaftar</span>
    </div>

    {{-- pencarian + filter --}}
    <form method="GET" action="{{ route('leads') }}" class="px-4 pt-3.5 sm:px-5"
          x-data="{ lanjut: {{ request()->anyFilled(['layanan', 'tipe_pemohon', 'tanggal_awal', 'tanggal_akhir']) ? 'true' : 'false' }} }">
        <div class="flex flex-col gap-3 lg:flex-row">
            <div class="relative flex-1">
                <x-icon name="search" class="pointer-events-none absolute left-3 top-1/2 size-[18px] -translate-y-1/2 text-slate-400" />
                <input type="search" name="cari" value="{{ request('cari') }}" placeholder="Cari nama atau kontak" class="field pl-10">
            </div>

            <select name="status" class="field lg:w-44">
                <option value="">Semua Status</option>
                @foreach (\App\Models\Lead::STATUS as $status)
                    <option value="{{ $status }}" @selected(request('status') === $status)>{{ $status }}</option>
                @endforeach
            </select>

            <select name="sumber" class="field lg:w-44">
                <option value="">Semua Sumber</option>
                @foreach (\App\Models\Lead::SUMBER as $sumber)
                    <option value="{{ $sumber }}" @selected(request('sumber') === $sumber)>{{ $sumber }}</option>
                @endforeach
            </select>

            <button type="button" @click="lanjut = ! lanjut" class="btn-outline" :aria-expanded="lanjut">
                Filter lanjutan
                <x-icon name="chevron-down" class="size-4 transition-transform" ::class="lanjut ? 'rotate-180' : ''" />
            </button>
        </div>

        <div x-show="lanjut" x-cloak class="mt-3 grid gap-3 sm:grid-cols-2 lg:grid-cols-4">
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

            <label class="text-[11px] text-slate-500">Dari tanggal
                <input type="date" name="tanggal_awal" value="{{ request('tanggal_awal') }}" class="field mt-1">
            </label>
            <label class="text-[11px] text-slate-500">Sampai tanggal
                <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}" class="field mt-1">
            </label>
        </div>

        <div class="mt-3 flex gap-3">
            <button type="submit" class="btn-primary">Terapkan</button>
            <a href="{{ route('leads') }}" class="btn-outline">Hapus Filter</a>
        </div>
    </form>

    @if ($pesanTanggal)
        <p class="mx-4 mt-3 rounded-lg bg-warn-tint px-4 py-2 text-xs text-warn sm:mx-5">{{ $pesanTanggal }}</p>
    @endif

    {{-- tabel di layar lebar, jadi kartu di layar kecil --}}
    <table class="mt-4 block w-full text-left text-xs xl:table">
        <thead class="hidden bg-thead text-[11px] text-slate-500 xl:table-header-group">
            <tr>
                <th class="px-[18px] py-2.5 font-medium">Nama</th>
                <th class="px-[18px] py-2.5 font-medium">Kontak</th>
                <th class="px-[18px] py-2.5 font-medium">Layanan</th>
                <th class="px-[18px] py-2.5 font-medium">Sumber</th>
                <th class="px-[18px] py-2.5 font-medium">Status</th>
                <th class="px-[18px] py-2.5 font-medium">Penanggung Jawab</th>
                <th class="px-[18px] py-2.5 font-medium">Tanggal Masuk</th>
                <th class="px-[18px] py-2.5 font-medium">Aksi</th>
            </tr>
        </thead>
        <tbody class="block xl:table-row-group">
            @forelse ($leads as $lead)
                <tr class="block border-t px-4 py-3 hover:bg-thead xl:table-row xl:p-0 xl:align-top">
                    <td class="block pb-1.5 xl:table-cell xl:px-[18px] xl:py-3">
                        <a href="{{ route('leads.show', $lead) }}" class="text-[13px] font-semibold hover:underline">{{ $lead->nama }}</a>
                        @if ($lead->instansi)
                            <div class="text-[11px] text-slate-500">{{ $lead->instansi }}</div>
                        @endif
                        <div class="mt-1 flex flex-wrap gap-1.5 empty:hidden">
                            @if ($lead->is_baru)
                                <span class="badge badge-blue">Baru masuk</span>
                            @endif
                            @if ($lead->ada_pengingat)
                                <span class="badge badge-red">Follow-up jatuh tempo</span>
                            @endif
                            @if ($lead->penanda)
                                <span class="badge badge-amber">{{ $lead->penanda }}</span>
                            @endif
                        </div>
                    </td>
                    <td class="flex justify-between gap-3 py-1 xl:table-cell xl:px-[18px] xl:py-3">
                        <span class="text-[11px] text-slate-500 xl:hidden">Kontak</span>
                        <span class="text-right xl:text-left">
                            @if ($lead->no_hp) <div>{{ $lead->no_hp }}</div> @endif
                            @if ($lead->email) <div class="text-slate-500">{{ $lead->email }}</div> @endif
                            @if ($lead->instagram) <div class="text-slate-500">{{ $lead->instagram }}</div> @endif
                        </span>
                    </td>
                    <td class="flex justify-between gap-3 py-1 xl:table-cell xl:px-[18px] xl:py-3">
                        <span class="text-[11px] text-slate-500 xl:hidden">Layanan</span>
                        <span class="text-right xl:text-left">{{ $lead->layanans->pluck('nama')->implode(', ') }}</span>
                    </td>
                    <td class="flex justify-between gap-3 py-1 xl:table-cell xl:px-[18px] xl:py-3">
                        <span class="text-[11px] text-slate-500 xl:hidden">Sumber</span>
                        <span>{{ $lead->sumber }}</span>
                    </td>
                    <td class="flex items-center justify-between gap-3 py-1 xl:table-cell xl:px-[18px] xl:py-3">
                        <span class="text-[11px] text-slate-500 xl:hidden">Status</span>
                        <x-status-badge :status="$lead->status" />
                    </td>
                    <td class="flex justify-between gap-3 py-1 xl:table-cell xl:px-[18px] xl:py-3">
                        <span class="text-[11px] text-slate-500 xl:hidden">Penanggung Jawab</span>
                        <span>{{ $lead->penanggungJawab->name ?? 'Belum ditugaskan' }}</span>
                    </td>
                    <td class="flex justify-between gap-3 py-1 text-slate-500 xl:table-cell xl:px-[18px] xl:py-3">
                        <span class="text-[11px] xl:hidden">Tanggal Masuk</span>
                        <span>{{ $lead->created_at->format('d/m/Y') }}</span>
                    </td>
                    <td class="flex justify-end pt-2 xl:table-cell xl:px-[18px] xl:py-3 xl:pt-3">
                        <a href="{{ route('leads.show', $lead) }}" class="inline-flex items-center gap-1 font-semibold text-brand-dark hover:underline">
                            Detail <x-icon name="arrow-right" class="size-3.5" />
                        </a>
                    </td>
                </tr>
            @empty
                <tr class="block border-t xl:table-row">
                    <td colspan="8" class="block px-5 py-10 text-center text-[13px] text-slate-500 xl:table-cell">
                        {{ request()->except('page') ? 'Data tidak ditemukan' : 'Belum ada lead' }}
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="flex flex-col gap-3 border-t px-4 py-3.5 text-[11px] text-slate-500 sm:flex-row sm:items-center sm:justify-between sm:px-5">
        <span>Menampilkan {{ $leads->firstItem() ?? 0 }}–{{ $leads->lastItem() ?? 0 }} dari {{ $leads->total() }} lead</span>
        <div>{{ $leads->links() }}</div>
    </div>
</section>
@endsection