@extends('layouts.base')

@php
    $menu = [
        ['route' => 'website.beranda', 'label' => 'Beranda'],
        ['route' => 'website.tentang-kami', 'label' => 'Tentang Kami'],
        ['route' => 'website.layanan', 'label' => 'Layanan'],
        ['route' => 'website.portofolio', 'label' => 'Portofolio'],
        ['route' => 'website.kontak', 'label' => 'Kontak'],
    ];

    $layananFooter = ['Desain Logo & Identitas Brand', 'Desain Kaos & Apparel', 'Editing Video', 'Editing Foto', 'Poster, Banner & Flyer'];
@endphp

@section('body')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<div class="w-font flex min-h-screen flex-col bg-paper text-forest" x-data="{ menu: false }" @keydown.escape.window="menu = false">

    {{-- header --}}
    <header class="sticky top-0 z-40 border-b border-forest/5 bg-paper/85 backdrop-blur-xl">
        <div class="mx-auto flex h-[72px] max-w-7xl items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
            <a href="{{ route('website.beranda') }}" class="flex items-center gap-1 text-[22px] font-extrabold tracking-tight">
                TipeCreative<span class="mb-3 size-2 rounded-full bg-lime ring-2 ring-forest/10"></span>
            </a>

            <nav class="hidden items-center gap-1 text-[13px] font-semibold lg:flex">
                @foreach ($menu as $item)
                    <a href="{{ route($item['route']) }}"
                       class="rounded-full px-4 py-2 transition {{ request()->routeIs($item['route']) ? 'bg-[#d3e3de] text-forest' : 'text-slate-600 hover:text-forest' }}">{{ $item['label'] }}</a>
                @endforeach
            </nav>

            <a href="{{ route('website.formulir') }}" class="w-btn-lime hidden !px-5 !py-2.5 !text-[13px] lg:inline-flex">
                Ajukan Permintaan <x-icon name="arrow-up-right" class="size-4" />
            </a>

            <button type="button" @click="menu = ! menu" :aria-expanded="menu" aria-label="Buka menu"
                    class="flex size-11 items-center justify-center rounded-full border border-forest/10 bg-white lg:hidden">
                <x-icon name="menu" class="size-5" x-show="! menu" />
                <x-icon name="x-mark" class="size-5" x-show="menu" x-cloak />
            </button>
        </div>

        <nav x-show="menu" x-cloak x-transition.opacity class="flex flex-col gap-1 border-t border-forest/5 px-4 pb-4 pt-3 text-sm font-semibold lg:hidden">
            @foreach ($menu as $item)
                <a href="{{ route($item['route']) }}"
                   class="rounded-xl px-4 py-3 {{ request()->routeIs($item['route']) ? 'bg-[#d3e3de]' : 'text-slate-600' }}">{{ $item['label'] }}</a>
            @endforeach
            <a href="{{ route('website.formulir') }}" class="w-btn-lime mt-2">Ajukan Permintaan Layanan</a>
        </nav>
    </header>

    <main class="flex-1">
        @yield('content')
    </main>

    {{-- footer --}}
    <footer class="border-t border-forest/5 bg-paper">
        <div class="mx-auto grid max-w-7xl gap-10 px-4 pb-10 pt-14 sm:px-6 md:grid-cols-2 lg:grid-cols-[1.5fr_1fr_1fr_1.3fr] lg:px-8">
            <div>
                <a href="{{ route('website.beranda') }}" class="flex items-center gap-1 text-[22px] font-extrabold tracking-tight">
                    TipeCreative<span class="mb-3 size-2 rounded-full bg-lime ring-2 ring-forest/10"></span>
                </a>
                <p class="mt-4 max-w-sm text-[13px] leading-6 text-slate-500">PT TipeCreative adalah agensi produksi media kreatif terdepan yang berfokus pada desain identitas visual, produksi apparel, kampanye sinematik, dan strategi cetak modern untuk meningkatkan nilai brand.</p>
            </div>

            <div>
                <div class="text-sm font-extrabold">Layanan Unggulan</div>
                <ul class="mt-4 space-y-2.5 text-[13px] text-slate-500">
                    @foreach ($layananFooter as $nama)
                        <li><a href="{{ route('website.layanan') }}" class="hover:text-forest">{{ $nama }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div>
                <div class="text-sm font-extrabold">Tautan Cepat</div>
                <ul class="mt-4 space-y-2.5 text-[13px] text-slate-500">
                    @foreach ($menu as $item)
                        <li><a href="{{ route($item['route']) }}" class="hover:text-forest">{{ $item['label'] }}</a></li>
                    @endforeach

                </ul>
            </div>

            <div>
                <div class="text-sm font-extrabold">Kontak Studio</div>
                <ul class="mt-4 space-y-3 text-[13px] text-slate-500">
                    <li class="flex items-start gap-2.5"><x-icon name="map-pin" class="mt-0.5 size-4 shrink-0 text-moss" /> Alamat belum diisi</li>
                    <li class="flex items-start gap-2.5"><x-icon name="envelope" class="mt-0.5 size-4 shrink-0 text-moss" /> Email belum diisi</li>
                    <li class="flex items-start gap-2.5"><x-icon name="phone" class="mt-0.5 size-4 shrink-0 text-moss" /> WhatsApp belum diisi</li>
                </ul>
            </div>
        </div>

    </footer>
</div>
@endsection