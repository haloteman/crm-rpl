@extends('layouts.base')

@php
    $menu = [
        ['route' => 'website.beranda', 'label' => 'Beranda'],
        ['route' => 'website.tentang-kami', 'label' => 'Tentang Kami'],
        ['route' => 'website.layanan', 'label' => 'Layanan'],
        ['route' => 'website.portofolio', 'label' => 'Portofolio'],
        ['route' => 'website.kontak', 'label' => 'Kontak'],
    ];
@endphp

@section('body')
<div class="flex min-h-screen flex-col bg-white" x-data="{ menu: false }" @keydown.escape.window="menu = false">
    <header class="sticky top-0 z-40 border-b bg-white/95 backdrop-blur">
        <div class="mx-auto flex h-16 max-w-6xl items-center justify-between gap-4 px-4 sm:px-6">
            <a href="{{ route('website.beranda') }}" class="flex items-center gap-2.5 text-[15px] font-bold">
                <span class="flex size-8 shrink-0 items-center justify-center rounded-lg bg-brand-dark"><svg viewBox="0 0 24 24" class="size-5" fill="none" aria-hidden="true"><path d="M4 5.5A1.5 1.5 0 0 1 5.5 4h13A1.5 1.5 0 0 1 20 5.5V8h-5.25v11h-3.5V8H4V5.5Z" fill="#fff" /></svg></span>
                <span>PT TipeCreative</span>
            </a>

            <nav class="hidden items-center gap-7 text-[13px] font-medium md:flex">
                @foreach ($menu as $item)
                    <a href="{{ route($item['route']) }}"
                       class="{{ request()->routeIs($item['route']) ? 'text-brand-dark' : 'text-slate-600 hover:text-brand-dark' }}">{{ $item['label'] }}</a>
                @endforeach
            </nav>

            <a href="{{ route('website.formulir') }}" class="btn-primary hidden md:inline-flex">Ajukan Permintaan Layanan</a>

            <button type="button" @click="menu = ! menu" :aria-expanded="menu" aria-label="Buka menu"
                    class="flex size-10 items-center justify-center rounded-lg border md:hidden">
                <x-icon name="menu" class="size-5" x-show="! menu" />
                <x-icon name="x-mark" class="size-5" x-show="menu" x-cloak />
            </button>
        </div>

        <nav x-show="menu" x-cloak class="flex flex-col gap-1 border-t px-4 py-3 text-sm md:hidden">
            @foreach ($menu as $item)
                <a href="{{ route($item['route']) }}"
                   class="rounded-lg px-3 py-2.5 {{ request()->routeIs($item['route']) ? 'bg-tint font-semibold text-brand-dark' : 'text-slate-600' }}">{{ $item['label'] }}</a>
            @endforeach
            <a href="{{ route('website.formulir') }}" class="btn-primary mt-2">Ajukan Permintaan Layanan</a>
        </nav>
    </header>

    <main class="flex-1">
        @yield('content')
    </main>

    <footer class="bg-brand text-sm text-white/80">
        <div class="mx-auto grid max-w-6xl gap-8 px-4 py-12 sm:px-6 md:grid-cols-[1.4fr_1fr_1fr]">
            <div>
                <div class="flex items-center gap-2.5 text-base font-bold text-white">
                    <span class="flex size-8 shrink-0 items-center justify-center rounded-lg bg-white/15"><svg viewBox="0 0 24 24" class="size-5" fill="none" aria-hidden="true"><path d="M4 5.5A1.5 1.5 0 0 1 5.5 4h13A1.5 1.5 0 0 1 20 5.5V8h-5.25v11h-3.5V8H4V5.5Z" fill="#fff" /></svg></span> PT TipeCreative
                </div>
                <p class="mt-3 max-w-sm text-[13px]">Jasa media kreatif untuk mengolah gagasan menjadi komunikasi visual yang bermakna.</p>
            </div>
            <div>
                <div class="text-[13px] font-semibold text-white">Jelajahi</div>
                @foreach ($menu as $item)
                    <a href="{{ route($item['route']) }}" class="mt-2.5 block text-[13px] hover:text-white">{{ $item['label'] }}</a>
                @endforeach
            </div>
            <div>
                <div class="text-[13px] font-semibold text-white">Kontak</div>
                <p class="mt-2.5 flex items-center gap-2 text-[13px]"><x-icon name="envelope" class="size-4 shrink-0" /> Email belum diisi</p>
                <p class="mt-2.5 flex items-center gap-2 text-[13px]"><x-icon name="phone" class="size-4 shrink-0" /> WhatsApp belum diisi</p>
                <p class="mt-2.5 flex items-center gap-2 text-[13px]"><x-icon name="map-pin" class="size-4 shrink-0" /> Alamat belum diisi</p>
            </div>
        </div>
        <div class="border-t border-white/15 px-4 py-4 text-center text-xs">
            &copy; {{ date('Y') }} PT TipeCreative. Seluruh hak cipta dilindungi.
        </div>
    </footer>
</div>
@endsection