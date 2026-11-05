@extends('layouts.website')
@section('title', 'Beranda')

@section('content')
<section class="mx-auto max-w-6xl px-4 py-16 sm:px-6">
    <h1 class="text-4xl font-bold sm:text-5xl">Ide Anda. Bentuk baru. Cerita berarti.</h1>
    <p class="mt-4 max-w-2xl text-slate-500">PT TipeCreative membantu mengolah gagasan menjadi desain logo, kaos, video, foto, poster, banner, dan flyer.</p>
    <div class="mt-8 flex flex-wrap gap-3">
        <a href="{{ route('website.formulir') }}" class="btn-primary">Ajukan Permintaan Layanan</a>
        <a href="{{ route('website.layanan') }}" class="btn-outline">Lihat Layanan</a>
    </div>
</section>
@endsection
