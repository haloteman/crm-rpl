@extends('layouts.website')
@section('title', 'Layanan')

@php
    $layanans = ['Desain Logo', 'Desain Kaos', 'Editing Video', 'Editing Foto', 'Poster', 'Banner', 'Flyer'];
    $alur = [
        ['Pengajuan Brief', 'Isi formulir permintaan layanan berisi kebutuhan Anda.'],
        ['Konfirmasi & Rencana', 'Tim kami meninjau brief dan menghubungi Anda.'],
        ['Produksi & Review', 'Karya dikerjakan dan ditinjau bersama sesuai brief.'],
        ['Handover Master File', 'Hasil akhir diserahkan dalam format siap pakai.'],
    ];
@endphp

@section('content')
<section class="w-hero overflow-hidden">
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 md:py-24 lg:px-8">
        <span class="w-eyebrow"><span class="size-1.5 rounded-full bg-lime"></span> 7 layanan media kreatif</span>
        <h1 class="w-display mt-6 max-w-3xl uppercase">Layanan media <span class="text-lime">kreatif profesional</span></h1>
        <p class="mt-5 max-w-xl text-[15px] leading-7 text-white/70">Temukan medium untuk gagasan Anda. Pilih satu atau beberapa layanan, lalu sampaikan kebutuhan Anda melalui formulir.</p>
        <div class="mt-8">
            <a href="{{ route('website.formulir') }}" class="w-btn-lime">Mulai Konsultasi Proyek <x-icon name="arrow-right" class="size-4" /></a>
        </div>
    </div>
</section>

<section class="bg-white">
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 md:py-24 lg:px-8">
        <span class="w-eyebrow-light">Katalog layanan resmi</span>
        <h2 class="w-h2 mt-4 uppercase">Daftar lengkap 7 layanan unggulan</h2>

        <div class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($layanans as $i => $layanan)
                <div class="w-card flex flex-col bg-paper p-7">
                    <div class="flex items-center justify-between">
                        <span class="flex size-11 items-center justify-center rounded-full bg-moss text-sm font-extrabold text-lime">{{ $i + 1 }}</span>
                        <span class="rounded-full bg-mist px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-slate-500">Layanan 0{{ $i + 1 }}</span>
                    </div>
                    <h3 class="mt-5 text-lg font-bold">{{ $layanan }}</h3>
                    <p class="mt-2 flex-1 text-[13px] leading-6 text-slate-500">Deskripsi layanan belum diisi.</p>
                    <a href="{{ route('website.formulir') }}" class="w-btn-lime mt-6 !py-3">Pilih Layanan Ini <x-icon name="arrow-right" class="size-4" /></a>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="bg-mist">
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 md:py-24 lg:px-8">
        <div class="text-center">
            <h2 class="w-h2 uppercase">Alur pelayanan proyek</h2>
            <p class="mt-3 text-sm text-slate-500">Dari pengajuan formulir hingga penyerahan hasil akhir.</p>
        </div>
        <ol class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($alur as $i => [$judul, $isi])
                <li class="w-card p-6">
                    <span class="text-3xl font-extrabold text-forest/15">0{{ $i + 1 }}</span>
                    <div class="mt-3 text-sm font-bold">{{ $judul }}</div>
                    <p class="mt-1.5 text-[13px] leading-6 text-slate-500">{{ $isi }}</p>
                </li>
            @endforeach
        </ol>
    </div>
</section>

<section class="px-4 pb-16 pt-4 sm:px-6 lg:px-8">
    <div class="w-glow mx-auto max-w-7xl rounded-[28px] px-6 py-14 sm:px-12 sm:py-16">
        <span class="w-eyebrow">Siap memulai proyek Anda?</span>
        <h2 class="w-h2 mt-5 max-w-2xl uppercase">Bawa identitas brand &amp; media visual Anda ke level tertinggi</h2>
        <p class="mt-4 max-w-xl text-sm text-white/70">Kirimkan brief Anda melalui formulir permintaan layanan. Tidak perlu login atau membuat akun.</p>
        <div class="mt-8 flex flex-col gap-3 sm:flex-row">
            <a href="{{ route('website.formulir') }}" class="w-btn-lime">Buka Formulir Permintaan Layanan <x-icon name="arrow-right" class="size-4" /></a>
            <a href="{{ route('website.portofolio') }}" class="w-btn-ghost">Lihat Contoh Portofolio</a>
        </div>
    </div>
</section>
@endsection