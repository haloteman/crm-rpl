@extends('layouts.app')
@section('title', 'Penawaran')
@section('heading', 'Penawaran')

@section('content')
<h1 class="page-title">Penawaran</h1>
<p class="page-sub">Penawaran harga, kesepakatan, dan pembayaran.</p>

{{-- ringkasan --}}
<div class="mt-6 grid grid-cols-2 gap-4 lg:grid-cols-4">
    <div class="card px-5 py-4">
        <div class="text-xs text-slate-500">Total Penawaran</div>
        <div class="mt-2 text-[28px] font-semibold leading-none text-brand-dark">{{ $totalPenawaran }}</div>
    </div>
    <div class="card px-5 py-4">
        <div class="text-xs text-slate-500">Dikirim</div>
        <div class="mt-2 text-[28px] font-semibold leading-none">{{ $totalDikirim }}</div>
    </div>
    <div class="card px-5 py-4">
        <div class="text-xs text-slate-500">Won</div>
        <div class="mt-2 text-[28px] font-semibold leading-none">{{ $totalWon }}</div>
    </div>
    <div class="card px-5 py-4">
        <div class="text-xs text-slate-500">Lost</div>
        <div class="mt-2 text-[28px] font-semibold leading-none">{{ $totalLost }}</div>
    </div>
</div>

<section class="card mt-6">
    {{-- pencarian + filter --}}
    <form method="GET" action="{{ route('penawaran') }}" class="grid gap-3 px-4 pt-4 sm:grid-cols-2 sm:px-5 lg:grid-cols-3">
        <input type="search" name="cari" value="{{ request('cari') }}" placeholder="Cari nomor penawaran atau nama" class="field">

        <select name="status" class="field">
            <option value="">Semua Status Penawaran</option>
            @foreach (\App\Models\Penawaran::STATUS as $status)
                <option value="{{ $status }}" @selected(request('status') === $status)>{{ $status }}</option>
            @endforeach
        </select>

        <select name="layanan" class="field">
            <option value="">Semua Layanan</option>
            @foreach ($semuaLayanan as $layanan)
                <option value="{{ $layanan->id }}" @selected(request('layanan') == $layanan->id)>{{ $layanan->nama }}</option>
            @endforeach
        </select>

        <select name="status_pembayaran" class="field">
            <option value="">Semua Status Pembayaran</option>
            @foreach (\App\Models\Kesepakatan::STATUS_PEMBAYARAN as $status)
                <option value="{{ $status }}" @selected(request('status_pembayaran') === $status)>{{ $status }}</option>
            @endforeach
        </select>

        <label class="text-[11px] text-slate-500">Dari tanggal
            <input type="date" name="tanggal_awal" value="{{ request('tanggal_awal') }}" class="field mt-1">
        </label>
        <label class="text-[11px] text-slate-500">Sampai tanggal
            <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}" class="field mt-1">
        </label>

        <div class="flex gap-3">
            <button type="submit" class="btn-primary">Terapkan</button>
            <a href="{{ route('penawaran') }}" class="btn-outline">Hapus Filter</a>
        </div>
    </form>

    @if ($pesanTanggal)
        <p class="mx-4 mt-3 rounded-lg bg-warn-tint px-4 py-2 text-xs text-warn sm:mx-5">{{ $pesanTanggal }}</p>
    @endif

    <div class="mt-4 overflow-x-auto">
        <table class="w-full min-w-[760px] text-left text-xs">
            <thead class="bg-thead text-[11px] text-slate-500">
                <tr>
                    <th class="px-[18px] py-2.5 font-medium">No. Penawaran</th>
                    <th class="px-[18px] py-2.5 font-medium">Nama Lead/Pelanggan</th>
                    <th class="px-[18px] py-2.5 font-medium">Layanan</th>
                    <th class="px-[18px] py-2.5 font-medium">Nilai</th>
                    <th class="px-[18px] py-2.5 font-medium">Status Penawaran</th>
                    <th class="px-[18px] py-2.5 font-medium">Status Pembayaran</th>
                    <th class="px-[18px] py-2.5 font-medium">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($penawarans as $penawaran)
                    <tr class="border-t">
                        <td class="px-[18px] py-3 font-semibold">{{ $penawaran->nomor_penawaran }}</td>
                        <td class="px-[18px] py-3">{{ $penawaran->lead->nama }}</td>
                        <td class="px-[18px] py-3">{{ $penawaran->layanans->pluck('nama')->implode(', ') }}</td>
                        <td class="px-[18px] py-3">Rp{{ number_format($penawaran->nilaiTampil(), 0, ',', '.') }}</td>
                        <td class="px-[18px] py-3"><x-status-badge :status="$penawaran->status" /></td>
                        <td class="px-[18px] py-3">
                            @if ($penawaran->kesepakatan)
                                <x-status-badge :status="$penawaran->kesepakatan->status_pembayaran" />
                            @else
                                <span class="text-slate-400">—</span>
                            @endif
                        </td>
                        <td class="px-[18px] py-3 text-slate-500">{{ $penawaran->created_at->format('d/m/Y') }}</td>
                    </tr>
                @empty
                    <tr class="border-t">
                        <td colspan="7" class="px-5 py-10 text-center text-[13px] text-slate-500">
                            {{ request()->except('page') ? 'Data tidak ditemukan' : 'Belum ada penawaran' }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="flex flex-col gap-3 border-t px-4 py-3.5 text-[11px] text-slate-500 sm:flex-row sm:items-center sm:justify-between sm:px-5">
        <span>Menampilkan {{ $penawarans->firstItem() ?? 0 }}–{{ $penawarans->lastItem() ?? 0 }} dari {{ $penawarans->total() }} penawaran</span>
        <div>{{ $penawarans->links() }}</div>
    </div>
</section>
@endsection
