@extends('layouts.website')
@section('title', 'Tentang Kami')

@php
    $layanans = ['Desain Logo', 'Desain Kaos', 'Editing Video', 'Editing Foto', 'Poster', 'Banner', 'Flyer'];
    $langkah = [
        ['Konsultasi & Brief', 'Anda menyampaikan kebutuhan melalui formulir permintaan layanan.'],
        ['Eksplorasi Konsep', 'Tim kami meninjau kebutuhan dan menyiapkan arah kreatif.'],
        ['Produksi & Iterasi', 'Karya dikerjakan sesuai brief dan disempurnakan bersama.'],
        ['Serah Terima Final', 'Hasil akhir diserahkan dalam format yang siap digunakan.'],
    ];
@endphp

@section('content')
<section class="w-hero overflow-hidden">
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 md:py-24 lg:px-8">
        <span class="w-eyebrow"><span class="size-1.5 rounded-full bg-lime"></span> Tentang PT TipeCreative</span>
        <h1 class="w-display mt-6 max-w-3xl uppercase">Membentuk ide. <span class="text-lime">Menghubungkan cerita.</span></h1>
        <p class="mt-5 max-w-xl text-[15px] leading-7 text-white/70">Profil perusahaan belum diisi. Materi akan disediakan oleh PT TipeCreative.</p>
        <div class="mt-8 flex flex-col gap-3 sm:flex-row">
            <a href="{{ route('website.formulir') }}" class="w-btn-lime">Ajukan Permintaan Layanan <x-icon name="arrow-right" class="size-4" /></a>
            <a href="{{ route('website.layanan') }}" class="w-btn-ghost">Lihat Layanan</a>
        </div>
    </div>
</section>

<section class="bg-white">
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 md:py-24 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
            <span class="w-eyebrow-light">Fondasi strategis</span>
            <h2 class="w-h2 mt-4">Visi &amp; Misi Kami</h2>
        </div>

        <div class="mt-12 grid gap-5 md:grid-cols-2">
            <div class="w-card bg-paper p-7">
                <div class="flex size-11 items-center justify-center rounded-full bg-moss text-lime"><x-icon name="eye" class="size-5" /></div>
                <h3 class="mt-5 text-xl font-bold">Visi Perusahaan</h3>
                <p class="mt-2 text-[13px] text-slate-500">Belum diisi.</p>
            </div>
            <div class="w-card bg-mist p-7">
                <div class="flex size-11 items-center justify-center rounded-full bg-lime text-forest"><x-icon name="check-circle" class="size-5" /></div>
                <h3 class="mt-5 text-xl font-bold">Misi Perusahaan</h3>
                <p class="mt-2 text-[13px] text-slate-500">Belum diisi.</p>
            </div>
        </div>
    </div>
</section>

<section class="bg-mist">
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 md:py-24 lg:px-8">
        <span class="w-eyebrow-light">Spesialisasi</span>
        <h2 class="w-h2 mt-4">Ekosistem Produksi Visual</h2>
        <div class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($layanans as $nama)
                <div class="w-card flex items-center justify-between p-5 text-sm font-bold">
                    {{ $nama }} <x-icon name="arrow-up-right" class="size-4 text-olive" />
                </div>
            @endforeach
            <a href="{{ route('website.formulir') }}" class="flex flex-col justify-between rounded-3xl bg-forest p-5 text-white">
                <span class="text-sm font-bold">Konsultasi &amp; briefing kustom</span>
                <span class="mt-4 inline-flex items-center gap-1.5 text-xs font-bold text-lime">Ajukan Permintaan <x-icon name="arrow-right" class="size-3.5" /></span>
            </a>
        </div>
    </div>
</section>

<section class="bg-white">
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 md:py-24 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
            <span class="w-eyebrow-light">Metodologi kerja</span>
            <h2 class="w-h2 mt-4">Alur Kolaborasi yang Efisien</h2>
        </div>
        <ol class="mt-12 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($langkah as $i => [$judul, $isi])
                <li class="w-card bg-paper p-6">
                    <span class="text-xs font-extrabold text-olive">TAHAP 0{{ $i + 1 }}</span>
                    <div class="mt-3 text-base font-bold">{{ $judul }}</div>
                    <p class="mt-2 text-[13px] leading-6 text-slate-500">{{ $isi }}</p>
                </li>
            @endforeach
        </ol>
    </div>
</section>

<section class="px-4 pb-16 pt-4 sm:px-6 lg:px-8">
    <div class="w-glow mx-auto max-w-7xl rounded-[28px] px-6 py-14 text-center sm:px-12 sm:py-20">
        <h2 class="w-h2 mx-auto max-w-2xl uppercase">Siap mentransformasi identitas visual brand Anda?</h2>
        <p class="mx-auto mt-4 max-w-xl text-sm text-white/70">Konsultasikan kebutuhan desain, produksi apparel, atau media promosi Anda bersama tim kreatif kami.</p>
        <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
            <a href="{{ route('website.formulir') }}" class="w-btn-lime">Ajukan Permintaan Layanan <x-icon name="arrow-right" class="size-4" /></a>
            <a href="{{ route('website.kontak') }}" class="w-btn-ghost">Hubungi Tim Studio</a>
        </div>
    </div>
</section>
@endsection