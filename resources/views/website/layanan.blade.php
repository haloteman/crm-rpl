@extends('layouts.website')
@section('title', 'Layanan')

@php
    $layanans = [['Desain Logo', 'logo'], ['Desain Kaos', 'kaos'], ['Editing Video', 'video'], ['Editing Foto', 'foto'], ['Poster', 'poster'], ['Banner', 'banner'], ['Flyer', 'flyer']];
    $alur = [
        ['Pengajuan Brief', 'Isi formulir permintaan layanan berisi kebutuhan Anda.'],
        ['Konfirmasi & Rencana', 'Tim kami meninjau brief dan menghubungi Anda.'],
        ['Produksi & Review', 'Karya dikerjakan dan ditinjau bersama sesuai brief.'],
        ['Handover Master File', 'Hasil akhir diserahkan dalam format siap pakai.'],
    ];
@endphp

@section('content')
<section class="overflow-hidden bg-forest bg-[radial-gradient(ellipse_60%_80%_at_90%_0%,rgb(15_28_63/.95),transparent_65%),radial-gradient(ellipse_40%_50%_at_0%_100%,rgb(198_146_66/.08),transparent_70%)] text-white">
    <div class="mx-auto grid max-w-7xl items-center gap-10 px-4 py-16 sm:px-6 md:py-24 lg:grid-cols-[minmax(0,1.2fr)_minmax(0,1fr)] lg:px-8">
        <div>
            <span class="inline-flex items-center gap-2 rounded-full border border-lime/25 bg-lime/10 px-3 py-1 text-[11px] font-bold uppercase tracking-[0.08em] text-[#e8c07a]"><span class="size-1.5 rounded-full bg-lime"></span> 7 layanan media kreatif</span>
            <h1 class="mt-6 font-display text-[34px] font-semibold leading-[1.15] tracking-[-0.02em] sm:text-5xl lg:text-[46px] lg:leading-[1.2] xl:text-[52px]">Layanan media <span class="italic text-lime">kreatif profesional</span></h1>
            <p class="mt-5 max-w-xl text-[15px] leading-7 text-white/70">Temukan medium untuk gagasan Anda. Pilih satu atau beberapa layanan, lalu sampaikan kebutuhan Anda melalui formulir.</p>
            <div class="mt-8">
                <a href="{{ route('website.formulir') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-lime px-6 py-3 text-sm font-bold text-forest transition hover:-translate-y-px hover:bg-[#d4a359] hover:shadow-[0_6px_20px_rgb(198_146_66/.3)]">Mulai Konsultasi Proyek <x-icon name="arrow-right" class="size-4" /></a>
            </div>
        </div>
        <div class="relative">
            <div class="aspect-[4/3] overflow-hidden rounded-[28px] border border-white/10 shadow-2xl shadow-black/30">
                <x-media nama="layanan-hero" alt="Tim kreatif PT TipeCreative">
                    <x-ilustrasi jenis="flyer" class="size-full" />
                </x-media>
            </div>
            <x-ilustrasi jenis="foto" class="absolute -bottom-5 -left-3 hidden h-28 w-36 animate-float rounded-2xl border border-white/15 shadow-xl shadow-black/30 sm:block" />
        </div>
    </div>
</section>

<section class="bg-white">
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 md:py-24 lg:px-8">
        <span class="inline-flex items-center gap-2 text-[11px] font-bold uppercase tracking-[0.12em] text-olive">Katalog layanan resmi</span>
        <h2 class="mt-4 font-display text-[28px] font-semibold leading-[1.2] tracking-[-0.015em] sm:text-[40px]">Daftar lengkap 7 layanan unggulan</h2>

        <div class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($layanans as $i => [$layanan, $jenis])
                <div class="flex flex-col overflow-hidden rounded-2xl border border-forest/5 bg-paper shadow-[0_4px_6px_-1px_rgb(11_20_38/.04),0_16px_32px_-4px_rgb(11_20_38/.07)]">
                    <div class="relative h-48">
                        <x-media :nama="'layanan-'.$jenis" :alt="$layanan">
                            <x-ilustrasi :jenis="$jenis" class="h-48 w-full" />
                        </x-media>
                        <span class="absolute left-4 top-4 rounded-full bg-forest/70 px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-lime backdrop-blur">Layanan 0{{ $i + 1 }}</span>
                    </div>
                    <div class="flex flex-1 flex-col p-6">
                        <h3 class="text-lg font-bold">{{ $layanan }}</h3>
                        <p class="mt-2 flex-1 text-[13px] leading-6 text-slate-500">Deskripsi layanan belum diisi.</p>
                        <a href="{{ route('website.formulir') }}" class="mt-6 inline-flex items-center justify-center gap-2 rounded-lg bg-lime px-6 py-3 text-sm font-bold text-forest transition hover:-translate-y-px hover:bg-[#d4a359] hover:shadow-[0_6px_20px_rgb(198_146_66/.3)]">Pilih Layanan Ini <x-icon name="arrow-right" class="size-4" /></a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="bg-mist">
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 md:py-24 lg:px-8">
        <div class="text-center">
            <h2 class="font-display text-[28px] font-semibold leading-[1.2] tracking-[-0.015em] sm:text-[40px]">Alur pelayanan proyek</h2>
            <p class="mt-3 text-sm text-slate-500">Dari pengajuan formulir hingga penyerahan hasil akhir.</p>
        </div>
        <ol class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($alur as $i => [$judul, $isi])
                <li class="rounded-2xl border border-forest/5 bg-white p-6 shadow-[0_4px_6px_-1px_rgb(11_20_38/.04),0_16px_32px_-4px_rgb(11_20_38/.07)]">
                    <span class="text-3xl font-extrabold text-forest/15">0{{ $i + 1 }}</span>
                    <div class="mt-3 text-sm font-bold">{{ $judul }}</div>
                    <p class="mt-1.5 text-[13px] leading-6 text-slate-500">{{ $isi }}</p>
                </li>
            @endforeach
        </ol>
    </div>
</section>

<section class="px-4 pb-16 pt-4 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-7xl rounded-[28px] border border-white/10 bg-[radial-gradient(ellipse_70%_120%_at_100%_100%,rgb(198_146_66/.16),transparent_65%),linear-gradient(135deg,#0f1c3f,#0b1426)] px-6 py-14 text-white shadow-[inset_0_1px_0_rgb(255_255_255/.1)] sm:px-12 sm:py-16">
        <span class="inline-flex items-center gap-2 rounded-full border border-lime/25 bg-lime/10 px-3 py-1 text-[11px] font-bold uppercase tracking-[0.08em] text-[#e8c07a]">Siap memulai proyek Anda?</span>
        <h2 class="mt-5 max-w-2xl font-display text-[28px] font-semibold leading-[1.2] tracking-[-0.015em] sm:text-[40px]">Bawa identitas brand &amp; media visual Anda ke level tertinggi</h2>
        <p class="mt-4 max-w-xl text-sm text-white/70">Kirimkan brief Anda melalui formulir permintaan layanan. Tidak perlu login atau membuat akun.</p>
        <div class="mt-8 flex flex-col gap-3 sm:flex-row">
            <a href="{{ route('website.formulir') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-lime px-6 py-3 text-sm font-bold text-forest transition hover:-translate-y-px hover:bg-[#d4a359] hover:shadow-[0_6px_20px_rgb(198_146_66/.3)]">Buka Formulir Permintaan Layanan <x-icon name="arrow-right" class="size-4" /></a>
            <a href="{{ route('website.portofolio') }}" class="inline-flex items-center justify-center gap-2 rounded-lg border border-white/25 px-6 py-3 text-sm font-bold text-white transition hover:bg-white/10">Lihat Contoh Portofolio</a>
        </div>
    </div>
</section>
@endsection