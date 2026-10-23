@extends('layouts.app')
@section('title', 'Dashboard')
@section('heading', 'Dashboard')

@php $rp = fn ($n) => 'Rp.'.number_format($n, 0, ',', '.'); @endphp

@section('content')
<div class="flex flex-wrap items-center justify-between gap-3">
    <div class="flex items-center gap-8 text-xs">
        <span class="flex items-center gap-2"><span class="size-6 bg-[#12a01e]"></span> Won</span>
        <span class="flex items-center gap-2"><span class="size-6 bg-[#ff0000]"></span> Lost</span>
    </div>
    <div class="card flex items-center gap-3 px-3 py-2 text-xs">
        {{ $periode }}
        <x-icon name="calendar" class="size-6" />
    </div>
</div>

<div class="mt-4 grid grid-cols-2 gap-4 lg:grid-cols-[repeat(4,minmax(0,217px))]">
    <div class="card p-4 lg:h-[124px]">
        <div class="font-medium">Won Revenue</div>
        <div class="mt-2 text-2xl font-bold text-won">{{ $rp($stats['won_revenue']) }}</div>
    </div>
    <div class="card p-4 lg:h-[124px]">
        <div class="font-medium">Lost Revenue</div>
        <div class="mt-2 text-2xl font-bold text-lost">{{ $rp($stats['lost_revenue']) }}</div>
    </div>
    <div class="card p-4 lg:h-[124px]">
        <div class="font-medium">Deals Won</div>
        <div class="mt-2 flex items-center gap-3 text-2xl font-bold">{{ $stats['deals_won'] }} <x-icon name="trend-up" class="size-6 text-won" /></div>
    </div>
    <div class="card p-4 lg:h-[124px]">
        <div class="font-medium">Deals Lost</div>
        <div class="mt-2 flex items-center gap-3 text-2xl font-bold">{{ $stats['deals_lost'] }} <x-icon name="trend-down" class="size-6 text-lost" /></div>
    </div>
</div>


@php
    $panel = 'flex min-h-[200px] items-end rounded-lg p-4 text-sm text-slate-500';
@endphp
<div class="mt-6 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
    <div class="card {{ $panel }}">Grafik Won vs Lost</div>
    <div class="card {{ $panel }}">Tren pendapatan</div>
    <div class="{{ $panel }} bg-thead">Ringkasan</div>
    <div class="{{ $panel }} bg-thead">Follow up terdekat</div>
    <div class="{{ $panel }} bg-thead">Penawaran terbaru</div>
    <div class="{{ $panel }} bg-thead">Pembayaran terbaru</div>
</div>
@endsection