@extends('layouts.website')
@section('title', 'Kontak')

@section('content')
<section class="mx-auto max-w-6xl px-4 py-16 sm:px-6">
    <p class="text-xs font-semibold uppercase tracking-wide text-brand-dark">Kontak</p>
    <h1 class="mt-2 text-4xl font-bold">Percakapan kreatif dimulai di sini.</h1>
    <p class="mt-4 max-w-2xl text-slate-500">Punya kebutuhan desain atau media kreatif? Sampaikan melalui formulir permintaan layanan kami.</p>

    <div class="mt-10 grid gap-8 lg:grid-cols-2">
        <dl class="divide-y">
            <div class="py-4"><dt class="text-sm font-medium">Email</dt><dd class="text-slate-500">Belum diisi</dd></div>
            <div class="py-4"><dt class="text-sm font-medium">WhatsApp</dt><dd class="text-slate-500">Belum diisi</dd></div>
            <div class="py-4"><dt class="text-sm font-medium">Instagram</dt><dd class="text-slate-500">Belum diisi</dd></div>
            <div class="py-4"><dt class="text-sm font-medium">Alamat</dt><dd class="text-slate-500">Belum diisi</dd></div>
        </dl>

        <div class="rounded-xl bg-brand p-8 text-white">
            <h2 class="text-2xl font-bold">Kebutuhan kreatif Anda, titik awal kami.</h2>
            <p class="mt-3 text-white/80">Anda dapat memilih lebih dari satu layanan. Tidak perlu login atau membuat akun.</p>
            <a href="{{ route('website.formulir') }}" class="btn-outline mt-6">Ajukan Permintaan Layanan</a>
        </div>
    </div>
</section>
@endsection
