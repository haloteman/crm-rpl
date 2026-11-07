@extends('layouts.website')
@section('title', 'Kontak')

@php
    $kanal = [
        ['map-pin', 'Alamat studio'],
        ['phone', 'WhatsApp & telepon'],
        ['envelope', 'Email resmi'],
        ['clock', 'Jam kerja'],
    ];
@endphp

@section('content')
<section class="w-hero overflow-hidden">
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 md:py-24 lg:px-8">
        <span class="w-eyebrow"><span class="size-1.5 rounded-full bg-lime"></span> Studio produksi &amp; media visual</span>
        <h1 class="w-display mt-6 max-w-3xl">Hubungi Studio <span class="text-lime">Kreatif Kami.</span></h1>
        <p class="mt-5 max-w-xl text-[15px] leading-7 text-white/70">Percakapan kreatif dimulai di sini. Punya kebutuhan desain atau media kreatif? Sampaikan melalui formulir permintaan layanan kami.</p>
        <div class="mt-8">
            <a href="{{ route('website.formulir') }}" class="w-btn-lime">Ajukan Permintaan Layanan <x-icon name="arrow-right" class="size-4" /></a>
        </div>
    </div>
</section>

<section class="bg-white">
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 md:py-24 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
            <span class="w-eyebrow-light">Kanal komunikasi resmi</span>
            <h2 class="w-h2 mt-4">Akses Langsung ke Tim TipeCreative</h2>
        </div>

        <dl class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($kanal as [$ikon, $label])
                <div class="w-card bg-paper p-6">
                    <div class="flex size-11 items-center justify-center rounded-full bg-[#caf1e7] text-moss"><x-icon :name="$ikon" class="size-5" /></div>
                    <dt class="mt-5 text-[10px] font-bold uppercase tracking-[0.08em] text-slate-500">{{ $label }}</dt>
                    <dd class="mt-1.5 text-base font-bold">Belum diisi</dd>
                </div>
            @endforeach
        </dl>
    </div>
</section>

<section class="px-4 py-16 sm:px-6 lg:px-8">
    <div class="w-glow mx-auto grid max-w-7xl items-center gap-8 rounded-[28px] px-6 py-12 sm:px-12 md:grid-cols-[1fr_auto]">
        <div>
            <span class="w-eyebrow">Fast-track proyek baru</span>
            <h2 class="w-h2 mt-4">Sudah punya kebutuhan proyek spesifik?</h2>
            <p class="mt-3 max-w-xl text-sm text-white/70">Anda dapat memilih lebih dari satu layanan. Tidak perlu login atau membuat akun. Kebutuhan kreatif Anda, titik awal kami.</p>
        </div>
        <a href="{{ route('website.formulir') }}" class="w-btn-lime !px-9 !py-5">Ajukan Permintaan Layanan <x-icon name="arrow-right" class="size-4" /></a>
    </div>
</section>
@endsection