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
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,600&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<div class="font-jakarta flex min-h-screen flex-col bg-paper text-forest" x-data="{ menu: false }" @keydown.escape.window="menu = false">

    {{-- header: navy kaca, pip emas di menu aktif --}}
    <header class="sticky top-0 z-40 border-b border-white/10 bg-forest/95 text-white backdrop-blur-xl">
        <div class="mx-auto flex h-[72px] max-w-7xl items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
            <a href="{{ route('website.beranda') }}" class="flex items-center gap-3">
                <span class="flex size-9 items-center justify-center rounded-lg bg-lime text-forest"><svg viewBox="0 0 24 24" class="size-5" fill="currentColor" aria-hidden="true"><path d="M12 2l2.2 6.8L21 11l-6.8 2.2L12 20l-2.2-6.8L3 11l6.8-2.2z"/></svg></span>
                <span class="leading-none">
                    <span class="font-display block text-[21px] font-semibold tracking-tight">TipeCreative</span>
                    <span class="mt-1 hidden text-[8px] font-semibold uppercase tracking-[0.2em] text-white/50 sm:block">Production House &amp; Agency</span>
                </span>
            </a>

            <nav class="hidden items-center gap-1 text-[13px] font-semibold lg:flex">
                @foreach ($menu as $item)
                    @php $aktif = request()->routeIs($item['route']); @endphp
                    <a href="{{ route($item['route']) }}"
                       class="relative px-4 py-2 transition {{ $aktif ? 'text-white' : 'text-white/70 hover:text-white' }}">
                        {{ $item['label'] }}
                        @if ($aktif)<span class="absolute inset-x-4 -bottom-[17px] h-0.5 rounded-full bg-lime"></span>@endif
                    </a>
                @endforeach
            </nav>

            <a href="{{ route('website.formulir') }}" class="hidden items-center justify-center gap-2 rounded-lg bg-lime px-5 py-2.5 text-[13px] font-bold text-forest transition hover:-translate-y-px hover:bg-[#d4a359] hover:shadow-[0_6px_20px_rgb(198_146_66/.3)] lg:inline-flex">
                Ajukan Permintaan <x-icon name="arrow-right" class="size-4" />
            </a>

            <button type="button" @click="menu = ! menu" :aria-expanded="menu" aria-label="Buka menu"
                    class="flex size-11 items-center justify-center rounded-lg border border-white/15 lg:hidden">
                <x-icon name="menu" class="size-5" x-show="! menu" />
                <x-icon name="x-mark" class="size-5" x-show="menu" x-cloak />
            </button>
        </div>

        <nav x-show="menu" x-cloak x-transition.opacity class="flex flex-col gap-1 border-t border-white/10 px-4 pb-4 pt-3 text-sm font-semibold lg:hidden">
            @foreach ($menu as $item)
                <a href="{{ route($item['route']) }}"
                   class="rounded-lg px-4 py-3 {{ request()->routeIs($item['route']) ? 'bg-white/10 text-lime' : 'text-white/75' }}">{{ $item['label'] }}</a>
            @endforeach
            <a href="{{ route('website.formulir') }}" class="mt-2 inline-flex items-center justify-center gap-2 rounded-lg bg-lime px-6 py-3 text-sm font-bold text-forest">Ajukan Permintaan Layanan</a>
        </nav>
    </header>

    <main class="flex-1">
        @yield('content')
    </main>

    {{-- footer --}}
    <footer class="bg-forest text-white">
        <div class="mx-auto grid max-w-7xl gap-10 px-4 pb-10 pt-16 sm:px-6 md:grid-cols-2 lg:grid-cols-[1.5fr_1fr_1fr_1.3fr] lg:px-8">
            <div>
                <a href="{{ route('website.beranda') }}" class="flex items-center gap-3">
                    <span class="flex size-9 items-center justify-center rounded-lg bg-lime text-forest"><svg viewBox="0 0 24 24" class="size-5" fill="currentColor" aria-hidden="true"><path d="M12 2l2.2 6.8L21 11l-6.8 2.2L12 20l-2.2-6.8L3 11l6.8-2.2z"/></svg></span>
                    <span class="font-display text-[22px] font-semibold tracking-tight">TipeCreative</span>
                </a>
                <p class="mt-5 max-w-sm text-[13px] leading-6 text-white/60">PT TipeCreative adalah agensi produksi media kreatif yang berfokus pada desain identitas visual, produksi apparel, kampanye sinematik, dan strategi cetak modern untuk meningkatkan nilai brand.</p>
            </div>

            <div>
                <div class="text-sm font-bold">Layanan Unggulan</div>
                <ul class="mt-4 space-y-2.5 text-[13px] text-white/60">
                    @foreach ($layananFooter as $nama)
                        <li><a href="{{ route('website.layanan') }}" class="hover:text-lime">{{ $nama }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div>
                <div class="text-sm font-bold">Tautan Cepat</div>
                <ul class="mt-4 space-y-2.5 text-[13px] text-white/60">
                    @foreach ($menu as $item)
                        <li><a href="{{ route($item['route']) }}" class="hover:text-lime">{{ $item['label'] }}</a></li>
                    @endforeach
                    <li><a href="{{ route('website.formulir') }}" class="font-semibold text-lime hover:underline">Ajukan Permintaan Layanan</a></li>
                </ul>
            </div>

            <div>
                <div class="text-sm font-bold">Kontak Studio</div>
                <ul class="mt-4 space-y-3 text-[13px] text-white/60">
                    <li class="flex items-start gap-2.5"><x-icon name="map-pin" class="mt-0.5 size-4 shrink-0 text-lime" /> Alamat belum diisi</li>
                    <li class="flex items-start gap-2.5"><x-icon name="envelope" class="mt-0.5 size-4 shrink-0 text-lime" /> Email belum diisi</li>
                    <li class="flex items-start gap-2.5"><x-icon name="phone" class="mt-0.5 size-4 shrink-0 text-lime" /> WhatsApp belum diisi</li>
                </ul>
            </div>
        </div>

        <div class="mx-auto max-w-7xl px-4 pb-8 sm:px-6 lg:px-8">
            <div class="border-t border-white/10 pt-6 text-xs text-white/45">
                &copy; {{ date('Y') }} PT TipeCreative. Hak Cipta Dilindungi Undang-Undang.
            </div>
        </div>
    </footer>
</div>
@endsection