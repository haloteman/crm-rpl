@extends('layouts.app')
@section('title', 'Customer')
@section('heading', 'Customer')

@section('content')
<div>
    <h1 class="page-title">Customer</h1>
    <p class="page-sub">Pelanggan hasil konversi lead.</p>
</div>

<div class="card mt-6 px-5 py-4 md:w-64">
    <div class="text-xs text-slate-500">Total Pelanggan</div>
    <div class="mt-2 text-[28px] font-semibold leading-none text-brand-dark">{{ $totalPelanggan }}</div>
</div>

<section class="card mt-6">
    <div class="flex items-center justify-between gap-3 px-4 pt-4 sm:px-5">
        <h2 class="text-base font-semibold">Semua pelanggan</h2>
        <span class="text-xs font-medium text-brand-dark">{{ $semuaPelanggan->total() }} pelanggan</span>
    </div>

    <form method="GET" action="{{ route('customer') }}" class="flex flex-col gap-3 px-4 pt-3.5 sm:flex-row sm:px-5">
        <div class="relative flex-1">
            <x-icon name="search" class="pointer-events-none absolute left-3 top-1/2 size-[18px] -translate-y-1/2 text-slate-400" />
            <input type="search" name="cari" value="{{ request('cari') }}" placeholder="Cari nama atau kontak" class="field pl-10">
        </div>
        <button type="submit" class="btn-outline">Cari</button>
    </form>

    {{-- tabel di layar lebar, jadi kartu di HP --}}
    <table class="mt-4 block w-full text-left text-xs md:table">
        <thead class="hidden bg-thead text-[11px] text-slate-500 md:table-header-group">
            <tr>
                <th class="px-[18px] py-2.5 font-medium">Nama</th>
                <th class="px-[18px] py-2.5 font-medium">Kontak</th>
                <th class="px-[18px] py-2.5 font-medium">Sumber Awal</th>
                <th class="px-[18px] py-2.5 font-medium">Menjadi Pelanggan</th>
                <th class="px-[18px] py-2.5 font-medium">Aksi</th>
            </tr>
        </thead>
        <tbody class="block md:table-row-group">
            @forelse ($semuaPelanggan as $pelanggan)
                <tr class="block border-t px-4 py-3 hover:bg-thead md:table-row md:p-0 md:align-top">
                    <td class="block pb-1.5 md:table-cell md:px-[18px] md:py-3">
                        <a href="{{ route('customer.show', $pelanggan) }}" class="text-[13px] font-semibold hover:underline">{{ $pelanggan->nama }}</a>
                        @if ($pelanggan->instansi)
                            <div class="text-[11px] text-slate-500">{{ $pelanggan->instansi }}</div>
                        @endif
                    </td>
                    <td class="flex justify-between gap-3 py-1 md:table-cell md:px-[18px] md:py-3">
                        <span class="text-[11px] text-slate-500 md:hidden">Kontak</span>
                        <span class="text-right md:text-left">
                            @if ($pelanggan->no_hp) <div>{{ $pelanggan->no_hp }}</div> @endif
                            @if ($pelanggan->email) <div class="text-slate-500">{{ $pelanggan->email }}</div> @endif
                            @if ($pelanggan->instagram) <div class="text-slate-500">{{ $pelanggan->instagram }}</div> @endif
                        </span>
                    </td>
                    <td class="flex justify-between gap-3 py-1 md:table-cell md:px-[18px] md:py-3">
                        <span class="text-[11px] text-slate-500 md:hidden">Sumber Awal</span>
                        <span>{{ $pelanggan->sumber_awal }}</span>
                    </td>
                    <td class="flex justify-between gap-3 py-1 text-slate-500 md:table-cell md:px-[18px] md:py-3">
                        <span class="text-[11px] md:hidden">Menjadi Pelanggan</span>
                        <span>{{ $pelanggan->tanggal_menjadi_pelanggan->format('d/m/Y') }}</span>
                    </td>
                    <td class="flex justify-end pt-2 md:table-cell md:px-[18px] md:py-3 md:pt-3">
                        <a href="{{ route('customer.show', $pelanggan) }}" class="inline-flex items-center gap-1 font-semibold text-brand-dark hover:underline">
                            Detail <x-icon name="arrow-right" class="size-3.5" />
                        </a>
                    </td>
                </tr>
            @empty
                <tr class="block border-t md:table-row">
                    <td colspan="5" class="block px-5 py-10 text-center text-[13px] text-slate-500 md:table-cell">
                        {{ request('cari') ? 'Data tidak ditemukan' : 'Belum ada pelanggan' }}
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="flex flex-col gap-3 border-t px-4 py-3.5 text-[11px] text-slate-500 sm:flex-row sm:items-center sm:justify-between sm:px-5">
        <span>Menampilkan {{ $semuaPelanggan->firstItem() ?? 0 }}–{{ $semuaPelanggan->lastItem() ?? 0 }} dari {{ $semuaPelanggan->total() }} pelanggan</span>
        <div>{{ $semuaPelanggan->links() }}</div>
    </div>
</section>
@endsection