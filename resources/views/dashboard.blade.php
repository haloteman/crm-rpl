@extends('layouts.app')
@section('title', 'Dashboard')
@section('heading', 'Dashboard')

@php $rp = fn ($n) => 'Rp.'.number_format($n, 0, ',', '.'); @endphp

@section('content')
<div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
    <div>
        <h1 class="text-[28px] font-bold leading-tight">Dashboard</h1>
        <p class="mt-1 text-sm text-slate-500">Ringkasan performa penjualan PT TipeCreative.</p>
    </div>
    <div class="flex items-center gap-2 self-start rounded-lg border bg-white px-3.5 py-2.5 text-sm font-medium">
        <x-icon name="calendar" class="size-5 text-slate-500" />
        {{ $periode }}
    </div>
</div>

<div class="mt-4 flex items-center gap-6 text-xs text-slate-500">
    <span class="flex items-center gap-2"><span class="size-3 rounded-sm bg-won"></span> Won</span>
    <span class="flex items-center gap-2"><span class="size-3 rounded-sm bg-lost"></span> Lost</span>
</div>

<div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
    <div class="card flex items-center gap-4 p-5">
        <div class="flex size-12 shrink-0 items-center justify-center rounded-lg bg-won-tint text-won"><x-icon name="pembayaran" class="size-6" /></div>
        <div class="min-w-0">
            <div class="text-sm text-slate-500">Won Revenue</div>
            <div class="mt-0.5 truncate text-2xl font-bold text-won">{{ $rp($stats['won_revenue']) }}</div>
        </div>
    </div>
    <div class="card flex items-center gap-4 p-5">
        <div class="flex size-12 shrink-0 items-center justify-center rounded-lg bg-lost-tint text-lost"><x-icon name="pembayaran" class="size-6" /></div>
        <div class="min-w-0">
            <div class="text-sm text-slate-500">Lost Revenue</div>
            <div class="mt-0.5 truncate text-2xl font-bold text-lost">{{ $rp($stats['lost_revenue']) }}</div>
        </div>
    </div>
    <div class="card flex items-center gap-4 p-5">
        <div class="flex size-12 shrink-0 items-center justify-center rounded-lg bg-won-tint text-won"><x-icon name="trend-up" class="size-6" /></div>
        <div>
            <div class="text-sm text-slate-500">Deals Won</div>
            <div class="mt-0.5 text-2xl font-bold">{{ $stats['deals_won'] }}</div>
        </div>
    </div>
    <div class="card flex items-center gap-4 p-5">
        <div class="flex size-12 shrink-0 items-center justify-center rounded-lg bg-lost-tint text-lost"><x-icon name="trend-down" class="size-6" /></div>
        <div>
            <div class="text-sm text-slate-500">Deals Lost</div>
            <div class="mt-0.5 text-2xl font-bold">{{ $stats['deals_lost'] }}</div>
        </div>
    </div>
</div>

{{-- panel grafik/ringkasan: kosong dulu, diisi saat modul terkait dibuat --}}
<div class="mt-6 grid gap-4 md:grid-cols-2 xl:grid-cols-3">
    @foreach (['Grafik Won vs Lost', 'Tren pendapatan', 'Ringkasan', 'Follow up terdekat', 'Penawaran terbaru', 'Pembayaran terbaru'] as $judul)
        <section class="card flex min-h-[200px] flex-col p-5">
            <h2 class="font-semibold">{{ $judul }}</h2>
            <div class="mt-3 flex flex-1 items-center justify-center rounded-lg bg-thead text-sm text-slate-500">Belum ada data</div>
        </section>
    @endforeach
</div>
@endsection