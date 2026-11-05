@extends('layouts.app')
@section('title', 'Customer')
@section('heading', 'Customer')

@section('content')
<div>
    <h1 class="text-[28px] font-bold leading-tight">Customer</h1>
    <p class="mt-1 text-sm text-slate-500">Pelanggan hasil konversi lead.</p>
</div>

<div class="card mt-5 px-5 py-4 md:w-64">
    <div class="text-sm text-slate-500">Total Pelanggan</div>
    <div class="text-3xl font-semibold">{{ $totalPelanggan }}</div>
</div>

<section class="card mt-5">
    <form method="GET" action="{{ route('customer') }}" class="flex flex-col gap-3 px-4 pt-4 sm:flex-row sm:px-5">
        <input type="search" name="cari" value="{{ request('cari') }}" placeholder="Cari nama atau kontak" class="field flex-1">
        <button type="submit" class="btn-outline">Cari</button>
    </form>

    <div class="mt-4 overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-thead text-xs text-slate-500">
                <tr>
                    <th class="px-5 py-3 font-medium">Nama</th>
                    <th class="px-5 py-3 font-medium">Kontak</th>
                    <th class="px-5 py-3 font-medium">Sumber Awal</th>
                    <th class="px-5 py-3 font-medium">Menjadi Pelanggan</th>
                    <th class="px-5 py-3 font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($semuaPelanggan as $pelanggan)
                    <tr class="border-t align-top">
                        <td class="px-5 py-3">
                            <a href="{{ route('customer.show', $pelanggan) }}" class="font-medium hover:underline">{{ $pelanggan->nama }}</a>
                            @if ($pelanggan->instansi)
                                <div class="text-xs text-slate-500">{{ $pelanggan->instansi }}</div>
                            @endif
                        </td>
                        <td class="px-5 py-3">
                            @if ($pelanggan->no_hp) <div>{{ $pelanggan->no_hp }}</div> @endif
                            @if ($pelanggan->email) <div>{{ $pelanggan->email }}</div> @endif
                            @if ($pelanggan->instagram) <div>{{ $pelanggan->instagram }}</div> @endif
                        </td>
                        <td class="px-5 py-3">{{ $pelanggan->sumber_awal }}</td>
                        <td class="px-5 py-3">{{ $pelanggan->tanggal_menjadi_pelanggan->format('d/m/Y') }}</td>
                        <td class="px-5 py-3">
                            <a href="{{ route('customer.show', $pelanggan) }}" class="text-xs font-medium text-brand-dark hover:underline">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr class="border-t">
                        <td colspan="5" class="px-5 py-8 text-center text-slate-500">
                            {{ request('cari') ? 'Data tidak ditemukan' : 'Belum ada pelanggan' }}
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="flex flex-col gap-3 border-t px-4 py-4 text-xs text-slate-500 sm:flex-row sm:items-center sm:justify-between sm:px-5">
        <span>Menampilkan {{ $semuaPelanggan->firstItem() ?? 0 }}–{{ $semuaPelanggan->lastItem() ?? 0 }} dari {{ $semuaPelanggan->total() }} pelanggan</span>
        <div>{{ $semuaPelanggan->links() }}</div>
    </div>
</section>
@endsection
