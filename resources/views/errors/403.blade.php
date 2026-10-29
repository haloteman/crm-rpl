@extends('layouts.app')
@section('title', 'Tidak Ada Akses')

@section('content')
<div class="card mx-auto mt-10 max-w-md p-8 text-center">
    <x-icon name="info" class="mx-auto size-12 text-slate-400" />
    <h2 class="mt-4 text-xl font-semibold">Kamu tidak punya akses ke halaman ini</h2>
    <p class="mt-2 text-slate-500">Halaman ini bukan untuk role kamu.</p>
    <a href="{{ url('/') }}" class="mt-6 inline-block rounded-full bg-brand px-6 py-2.5 font-semibold text-white hover:bg-brand-dark">Kembali ke beranda</a>
</div>
@endsection
