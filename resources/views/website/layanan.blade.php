@extends('layouts.website')
@section('title', 'Layanan')

@php
    $layanans = ['Desain Logo', 'Desain Kaos', 'Editing Video', 'Editing Foto', 'Poster', 'Banner', 'Flyer'];
@endphp

@section('content')
<section class="mx-auto max-w-6xl px-4 py-16 sm:px-6">
    <p class="text-xs font-semibold uppercase tracking-wide text-brand-dark">Layanan</p>
    <h1 class="mt-2 text-4xl font-bold">Temukan medium untuk gagasan Anda.</h1>

    <div class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($layanans as $layanan)
            <div class="card p-5">
                <h2 class="font-semibold">{{ $layanan }}</h2>
                <p class="mt-1 text-sm text-slate-500">Deskripsi layanan belum diisi.</p>
            </div>
        @endforeach
    </div>

    <a href="{{ route('website.formulir') }}" class="btn-primary mt-10">Ajukan Permintaan Layanan</a>
</section>
@endsection
