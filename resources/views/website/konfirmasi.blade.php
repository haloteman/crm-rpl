@extends('layouts.website')
@section('title', 'Permintaan Terkirim')

@section('content')
<section class="mx-auto max-w-2xl px-4 py-16 text-center sm:px-6 sm:py-24">
    <div class="mx-auto flex size-16 items-center justify-center rounded-full bg-won-tint text-won">
        <x-icon name="check-circle" class="size-8" />
    </div>
    <p class="eyebrow mt-6">Terima kasih telah menghubungi kami</p>
    <h1 class="mt-2 text-[28px] font-bold leading-tight sm:text-4xl">Permintaan layanan berhasil dikirim.</h1>
    <p class="mt-4 text-[15px] text-slate-600">Kebutuhan kreatif Anda telah kami terima. Tim PT TipeCreative akan meninjau informasi yang Anda sampaikan.</p>
    <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
        <a href="{{ route('website.beranda') }}" class="btn-primary">Kembali ke Beranda</a>
        <a href="{{ route('website.layanan') }}" class="btn-outline">Lihat Layanan</a>
    </div>
</section>
@endsection