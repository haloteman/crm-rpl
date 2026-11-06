@extends('layouts.website')
@section('title', 'Beranda')

@section('content')
<section class="bg-gradient-to-b from-tint to-white">
    <div class="mx-auto grid max-w-6xl items-center gap-10 px-4 py-14 sm:px-6 md:py-20 lg:grid-cols-[1.2fr_1fr]">
        <div>
            <p class="eyebrow">PT TipeCreative</p>
            <h1 class="mt-3 text-[32px] font-bold leading-tight sm:text-5xl">Ide Anda. Bentuk baru. Cerita berarti.</h1>
            <p class="mt-4 max-w-xl text-[15px] text-slate-600">PT TipeCreative membantu mengolah gagasan menjadi desain logo, kaos, video, foto, poster, banner, dan flyer.</p>
            <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                <a href="{{ route('website.formulir') }}" class="btn-primary">Ajukan Permintaan Layanan <x-icon name="arrow-right" class="size-4" /></a>
                <a href="{{ route('website.layanan') }}" class="btn-outline">Lihat Layanan</a>
            </div>
        </div>
        <div class="hidden grid-cols-2 gap-4 lg:grid" aria-hidden="true">
            <div class="h-40 rounded-2xl bg-brand-dark"></div>
            <div class="h-40 rounded-2xl bg-white shadow-sm ring-1 ring-line"></div>
            <div class="h-40 rounded-2xl bg-tint ring-1 ring-line"></div>
            <div class="h-40 rounded-2xl bg-brand"></div>
        </div>
    </div>
</section>

<section class="mx-auto max-w-6xl px-4 py-14 sm:px-6">
    <p class="eyebrow">Layanan</p>
    <h2 class="mt-2 text-2xl font-bold sm:text-3xl">Temukan medium untuk gagasan Anda.</h2>
    <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @foreach (['Desain Logo', 'Desain Kaos', 'Editing Video', 'Editing Foto', 'Poster', 'Banner', 'Flyer'] as $nama)
            <a href="{{ route('website.layanan') }}" class="card flex items-center justify-between p-4 text-[13px] font-semibold hover:border-brand-dark">
                {{ $nama }} <x-icon name="arrow-up-right" class="size-4 text-brand-dark" />
            </a>
        @endforeach
    </div>
</section>

<section class="mx-auto max-w-6xl px-4 pb-16 sm:px-6">
    <div class="rounded-2xl bg-brand p-8 text-white sm:p-10">
        <h2 class="text-2xl font-bold">Kebutuhan kreatif Anda, titik awal kami.</h2>
        <p class="mt-2 max-w-xl text-[13px] text-white/80">Tidak perlu login atau membuat akun. Isi formulir, tim kami akan menghubungi Anda.</p>
        <a href="{{ route('website.formulir') }}" class="btn-outline mt-6">Ajukan Permintaan Layanan</a>
    </div>
</section>
@endsection