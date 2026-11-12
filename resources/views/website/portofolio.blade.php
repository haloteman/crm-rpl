@extends('layouts.website')
@section('title', 'Portofolio')

@php
    $kategori = [['Desain Logo', 'logo'], ['Desain Kaos', 'kaos'], ['Editing Video', 'video'], ['Editing Foto', 'foto'], ['Poster & Flyer', 'poster'], ['Banner', 'banner']];
@endphp

@section('content')
<section class="overflow-hidden bg-forest bg-[radial-gradient(ellipse_60%_80%_at_90%_0%,rgb(15_28_63/.95),transparent_65%),radial-gradient(ellipse_40%_50%_at_0%_100%,rgb(198_146_66/.08),transparent_70%)] text-white">
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 md:py-24 lg:px-8">
        <span class="inline-flex items-center gap-2 rounded-full border border-lime/25 bg-lime/10 px-3 py-1 text-[11px] font-bold uppercase tracking-[0.08em] text-[#e8c07a]"><span class="size-1.5 rounded-full bg-lime"></span> Showcase resmi PT TipeCreative</span>
        <h1 class="mt-6 max-w-3xl font-display text-[34px] font-semibold leading-[1.15] tracking-[-0.02em] sm:text-5xl lg:text-[56px] lg:leading-[1.2]">Galeri Karya <span class="italic text-lime">Kreatif</span></h1>
        <p class="mt-5 max-w-xl text-[15px] leading-7 text-white/70">Bentuk, warna, dan cerita yang bertemu. Galeri karya belum diisi, materi akan disediakan oleh PT TipeCreative.</p>
        <div class="mt-8">
            <a href="{{ route('website.formulir') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-lime px-6 py-3 text-sm font-bold text-forest transition hover:-translate-y-px hover:bg-[#d4a359] hover:shadow-[0_6px_20px_rgb(198_146_66/.3)]">Mulai Konsultasi Proyek <x-icon name="arrow-right" class="size-4" /></a>
        </div>
    </div>
</section>

<section class="bg-paper" x-data="{ pilih: 'semua' }">
    {{-- filter --}}
    <div class="border-b border-forest/5">
        <div class="mx-auto flex max-w-7xl gap-2 overflow-x-auto px-4 py-4 sm:px-6 lg:px-8">
            <button type="button" @click="pilih = 'semua'" :class="pilih === 'semua' ? 'border-forest bg-forest text-white hover:bg-forest' : ''" class="inline-flex shrink-0 items-center rounded-lg border border-forest/10 px-4 py-1.5 text-xs font-semibold text-slate-600 transition hover:bg-mist">Semua ({{ count($kategori) }})</button>
            @foreach ($kategori as [$nama])
                <button type="button" @click="pilih = @js($nama)" :class="pilih === @js($nama) ? 'border-forest bg-forest text-white hover:bg-forest' : ''" class="inline-flex shrink-0 items-center rounded-lg border border-forest/10 px-4 py-1.5 text-xs font-semibold text-slate-600 transition hover:bg-mist">{{ $nama }}</button>
            @endforeach
        </div>
    </div>

    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($kategori as [$nama, $jenis])
                <div x-show="pilih === 'semua' || pilih === @js($nama)" class="overflow-hidden rounded-2xl border border-forest/5 bg-white shadow-[0_4px_6px_-1px_rgb(11_20_38/.04),0_16px_32px_-4px_rgb(11_20_38/.07)]">
                    <div class="relative h-56">
                        <x-media :nama="'portofolio-'.$jenis" :video="$jenis === 'video'" kontrol :alt="$nama">
                            <x-ilustrasi :jenis="$jenis" class="h-56 w-full" />
                        </x-media>
                        <span class="pointer-events-none absolute left-4 top-4 rounded-full bg-forest/70 px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-lime backdrop-blur">{{ $nama }}</span>
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
    <div class="mx-auto flex max-w-7xl flex-col gap-8 rounded-[28px] border border-white/10 bg-[radial-gradient(ellipse_70%_120%_at_100%_100%,rgb(198_146_66/.16),transparent_65%),linear-gradient(135deg,#0f1c3f,#0b1426)] px-6 py-12 text-white shadow-[inset_0_1px_0_rgb(255_255_255/.1)] sm:px-12 md:flex-row md:items-center md:justify-between">
        <div>
            <span class="inline-flex items-center gap-2 rounded-full border border-lime/25 bg-lime/10 px-3 py-1 text-[11px] font-bold uppercase tracking-[0.08em] text-[#e8c07a]">Solusi kreatif tanpa batas</span>
            <h2 class="mt-4 font-display text-[28px] font-semibold leading-[1.2] tracking-[-0.015em] sm:text-[40px]">Tertarik membuat karya serupa untuk bisnis Anda?</h2>
            <p class="mt-3 max-w-lg text-sm text-white/70">Diskusikan visi visual Anda bersama tim desainer, fotografer, dan sinematografer kami.</p>
        </div>
        <div class="flex flex-col gap-3 sm:flex-row md:flex-col">
            <a href="{{ route('website.formulir') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-lime px-6 py-3 text-sm font-bold text-forest transition hover:-translate-y-px hover:bg-[#d4a359] hover:shadow-[0_6px_20px_rgb(198_146_66/.3)]">Ajukan Permintaan Layanan</a>
            <a href="{{ route('website.kontak') }}" class="inline-flex items-center justify-center gap-2 rounded-lg border border-white/25 px-6 py-3 text-sm font-bold text-white transition hover:bg-white/10">Hubungi Studio</a>
        </div>
    </div>
</section>
@endsection