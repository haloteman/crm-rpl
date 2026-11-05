@extends('layouts.website')
@section('title', 'Permintaan Terkirim')

@section('content')
<section class="mx-auto max-w-2xl px-4 py-20 text-center sm:px-6">
    <p class="text-xs font-semibold uppercase tracking-wide text-brand-dark">Terima kasih telah menghubungi kami</p>
    <h1 class="mt-2 text-4xl font-bold">Permintaan layanan berhasil dikirim.</h1>
    <p class="mt-4 text-slate-500">Kebutuhan kreatif Anda telah kami terima. Tim PT TipeCreative akan meninjau informasi yang Anda sampaikan.</p>
    <div class="mt-8 flex flex-wrap justify-center gap-3">
        <a href="{{ route('website.beranda') }}" class="btn-primary">Kembali ke Beranda</a>
        <a href="{{ route('website.layanan') }}" class="btn-outline">Lihat Layanan</a>
    </div>
</section>
@endsection
