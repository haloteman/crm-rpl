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
<section class="overflow-hidden bg-forest bg-[radial-gradient(ellipse_60%_80%_at_90%_0%,rgb(15_28_63/.95),transparent_65%),radial-gradient(ellipse_40%_50%_at_0%_100%,rgb(198_146_66/.08),transparent_70%)] text-white">
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 md:py-24 lg:px-8">
        <span class="inline-flex items-center gap-2 rounded-full border border-lime/25 bg-lime/10 px-3 py-1 text-[11px] font-bold uppercase tracking-[0.08em] text-[#e8c07a]"><span class="size-1.5 rounded-full bg-lime"></span> Studio produksi &amp; media visual</span>
        <h1 class="mt-6 max-w-3xl font-display text-[34px] font-semibold leading-[1.15] tracking-[-0.02em] sm:text-5xl lg:text-[56px] lg:leading-[1.2]">Hubungi Studio <span class="italic text-lime">Kreatif Kami.</span></h1>
        <p class="mt-5 max-w-xl text-[15px] leading-7 text-white/70">Percakapan kreatif dimulai di sini. Punya kebutuhan desain atau media kreatif? Sampaikan melalui formulir permintaan layanan kami.</p>
        <div class="mt-8">
            <a href="{{ route('website.formulir') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-lime px-6 py-3 text-sm font-bold text-forest transition hover:-translate-y-px hover:bg-[#d4a359] hover:shadow-[0_6px_20px_rgb(198_146_66/.3)]">Ajukan Permintaan Layanan <x-icon name="arrow-right" class="size-4" /></a>
        </div>
    </div>
</section>

<section class="bg-white">
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 md:py-24 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
            <span class="inline-flex items-center gap-2 text-[11px] font-bold uppercase tracking-[0.12em] text-olive">Kanal komunikasi resmi</span>
            <h2 class="mt-4 font-display text-[28px] font-semibold leading-[1.2] tracking-[-0.015em] sm:text-[40px]">Akses Langsung ke Tim TipeCreative</h2>
        </div>

        <dl class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($kanal as [$ikon, $label])
                <div class="rounded-2xl border border-forest/5 bg-paper p-6 shadow-[0_4px_6px_-1px_rgb(11_20_38/.04),0_16px_32px_-4px_rgb(11_20_38/.07)]">
                    <div class="flex size-11 items-center justify-center rounded-full bg-[#f7e9cf] text-moss"><x-icon :name="$ikon" class="size-5" /></div>
                    <dt class="mt-5 text-[10px] font-bold uppercase tracking-[0.08em] text-slate-500">{{ $label }}</dt>
                    <dd class="mt-1.5 text-base font-bold">Belum diisi</dd>
                </div>
            @endforeach
        </dl>
    </div>
</section>

<section class="px-4 py-16 sm:px-6 lg:px-8">
    <div class="mx-auto grid max-w-7xl items-center gap-8 rounded-[28px] border border-white/10 bg-[radial-gradient(ellipse_70%_120%_at_100%_100%,rgb(198_146_66/.16),transparent_65%),linear-gradient(135deg,#0f1c3f,#0b1426)] px-6 py-12 text-white shadow-[inset_0_1px_0_rgb(255_255_255/.1)] sm:px-12 md:grid-cols-[1fr_auto]">
        <div>
            <span class="inline-flex items-center gap-2 rounded-full border border-lime/25 bg-lime/10 px-3 py-1 text-[11px] font-bold uppercase tracking-[0.08em] text-[#e8c07a]">Fast-track proyek baru</span>
            <h2 class="mt-4 font-display text-[28px] font-semibold leading-[1.2] tracking-[-0.015em] sm:text-[40px]">Sudah punya kebutuhan proyek spesifik?</h2>
            <p class="mt-3 max-w-xl text-sm text-white/70">Anda dapat memilih lebih dari satu layanan. Tidak perlu login atau membuat akun. Kebutuhan kreatif Anda, titik awal kami.</p>
        </div>
        <a href="{{ route('website.formulir') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-lime px-9 py-5 text-sm font-bold text-forest transition hover:-translate-y-px hover:bg-[#d4a359] hover:shadow-[0_6px_20px_rgb(198_146_66/.3)]">Ajukan Permintaan Layanan <x-icon name="arrow-right" class="size-4" /></a>
    </div>
</section>
@endsection