@extends('layouts.website')
@section('title', 'Layanan')

@php
    $layanans = ['Desain Logo', 'Desain Kaos', 'Editing Video', 'Editing Foto', 'Poster', 'Banner', 'Flyer'];
@endphp

@section('content')
<section class="bg-gradient-to-b from-tint to-white">
    <div class="mx-auto max-w-6xl px-4 py-14 sm:px-6 md:py-16">
        <p class="eyebrow">Layanan</p>
        <h1 class="mt-2 text-[30px] font-bold leading-tight sm:text-4xl">Temukan medium untuk gagasan Anda.</h1>
    </div>
</section>

<section class="mx-auto max-w-6xl px-4 py-12 sm:px-6">
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($layanans as $layanan)
            <div class="card p-5">
                <div class="flex size-10 items-center justify-center rounded-lg bg-tint text-brand-dark"><x-icon name="folder" class="size-5" /></div>
                <h2 class="mt-4 text-base font-semibold">{{ $layanan }}</h2>
                <p class="mt-1 text-[13px] text-slate-500">Deskripsi layanan belum diisi.</p>
            </div>
        @endforeach
    </div>

    <a href="{{ route('website.formulir') }}" class="btn-primary mt-10">Ajukan Permintaan Layanan</a>
</section>
@endsection