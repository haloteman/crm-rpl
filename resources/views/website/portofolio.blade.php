@extends('layouts.website')
@section('title', 'Portofolio')

@php
    $kategori = ['Desain Logo', 'Desain Kaos', 'Editing Video', 'Editing Foto', 'Poster & Flyer', 'Banner'];
@endphp

@section('content')
<section class="w-hero overflow-hidden">
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 md:py-24 lg:px-8">
        <span class="w-eyebrow"><span class="size-1.5 rounded-full bg-lime"></span> Showcase resmi PT TipeCreative</span>
        <h1 class="w-display mt-6 max-w-3xl">Galeri Karya <span class="text-lime">Kreatif</span></h1>
        <p class="mt-5 max-w-xl text-[15px] leading-7 text-white/70">Bentuk, warna, dan cerita yang bertemu. Galeri karya belum diisi, materi akan disediakan oleh PT TipeCreative.</p>
        <div class="mt-8">
            <a href="{{ route('website.formulir') }}" class="w-btn-lime">Mulai Konsultasi Proyek <x-icon name="arrow-right" class="size-4" /></a>
        </div>
    </div>
</section>

<section class="bg-paper" x-data="{ pilih: 'semua' }">
    {{-- filter --}}
    <div class="border-b border-forest/5">
        <div class="mx-auto flex max-w-7xl gap-2 overflow-x-auto px-4 py-4 sm:px-6 lg:px-8">
            <button type="button" @click="pilih = 'semua'" :class="pilih === 'semua' ? 'w-chip-on' : ''" class="w-chip shrink-0">Semua ({{ count($kategori) }})</button>
            @foreach ($kategori as $nama)
                <button type="button" @click="pilih = @js($nama)" :class="pilih === @js($nama) ? 'w-chip-on' : ''" class="w-chip shrink-0">{{ $nama }}</button>
            @endforeach
        </div>
    </div>

    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($kategori as $nama)
                <div x-show="pilih === 'semua' || pilih === @js($nama)" class="w-card overflow-hidden">
                    <div class="flex h-48 items-start bg-gradient-to-br from-moss to-forest p-4">
                        <span class="rounded-full bg-forest/60 px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-lime">{{ $nama }}</span>
                    </div>
                    <div class="p-5">
                        <div class="text-sm font-bold">Karya belum diisi</div>
                        <p class="mt-1 text-[13px] text-slate-500">Materi akan disediakan oleh PT TipeCreative.</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="px-4 pb-16 pt-4 sm:px-6 lg:px-8">
    <div class="w-glow mx-auto flex max-w-7xl flex-col gap-8 rounded-[28px] px-6 py-12 sm:px-12 md:flex-row md:items-center md:justify-between">
        <div>
            <span class="w-eyebrow">Solusi kreatif tanpa batas</span>
            <h2 class="w-h2 mt-4">Tertarik membuat karya serupa untuk bisnis Anda?</h2>
            <p class="mt-3 max-w-lg text-sm text-white/70">Diskusikan visi visual Anda bersama tim desainer, fotografer, dan sinematografer kami.</p>
        </div>
        <div class="flex flex-col gap-3 sm:flex-row md:flex-col">
            <a href="{{ route('website.formulir') }}" class="w-btn-lime">Ajukan Permintaan Layanan</a>
            <a href="{{ route('website.kontak') }}" class="w-btn-ghost">Hubungi Studio</a>
        </div>
    </div>
</section>
@endsection