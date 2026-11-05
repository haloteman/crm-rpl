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
<div class="flex min-h-screen flex-col bg-white" x-data="{ menu: false }">
    <header class="border-b">
        <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4 sm:px-6">
            <a href="{{ route('website.beranda') }}" class="text-lg font-bold">PT TipeCreative</a>

            <button type="button" @click="menu = ! menu" class="rounded-lg border px-3 py-1.5 text-sm sm:hidden">Menu</button>

            <nav class="hidden gap-6 text-sm sm:flex">
                @foreach ($menu as $item)
                    <a href="{{ route($item['route']) }}"
                       class="{{ request()->routeIs($item['route']) ? 'font-semibold text-brand-dark' : 'hover:text-brand-dark' }}">{{ $item['label'] }}</a>
                @endforeach
            </nav>
        </div>

        <nav x-show="menu" x-cloak class="flex flex-col border-t px-4 py-2 text-sm sm:hidden">
            @foreach ($menu as $item)
                <a href="{{ route($item['route']) }}" class="py-2">{{ $item['label'] }}</a>
            @endforeach
        </nav>
    </header>

    <main class="flex-1">
        @yield('content')
    </main>

    <footer class="bg-ink text-sm text-white/80">
        <div class="mx-auto grid max-w-6xl gap-8 px-4 py-10 sm:grid-cols-3 sm:px-6">
            <div>
                <div class="text-base font-bold text-white">PT TipeCreative</div>
                <p class="mt-2">Jasa media kreatif untuk mengolah gagasan menjadi komunikasi visual yang bermakna.</p>
            </div>
            <div>
                <div class="font-semibold text-white">Jelajahi</div>
                @foreach ($menu as $item)
                    <a href="{{ route($item['route']) }}" class="mt-2 block hover:text-white">{{ $item['label'] }}</a>
                @endforeach
            </div>
            <div>
                <div class="font-semibold text-white">Kontak</div>
                <p class="mt-2">Email belum diisi</p>
                <p class="mt-2">WhatsApp belum diisi</p>
                <p class="mt-2">Alamat belum diisi</p>
            </div>
        </div>
        <div class="border-t border-white/10 px-4 py-4 text-center text-xs">
            &copy; {{ date('Y') }} PT TipeCreative. Seluruh hak cipta dilindungi.
        </div>
    </footer>
</div>
@endsection
