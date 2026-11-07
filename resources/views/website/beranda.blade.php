@extends('layouts.website')
@section('title', 'Beranda')

@php
    $layananUtama = [
        ['Brand Identity & Logo', 'Desain logo dan identitas visual yang konsisten, dari konsep hingga file siap pakai.', 'folder'],
        ['Video & Motion Production', 'Editing video sinematik untuk konten promosi, kampanye, dan media sosial.', 'camera'],
        ['Apparel & Print Media', 'Desain kaos, poster, banner, dan flyer yang siap dicetak untuk kebutuhan brand Anda.', 'shopping-bag'],
    ];
    $alur = [
        ['Kirim brief & permintaan layanan', 'Isi formulir online berisi kebutuhan layanan, tenggat waktu, dan preferensi gaya yang Anda inginkan.'],
        ['Tinjauan & diskusi konsep', 'Tim kami meninjau permintaan Anda, lalu menghubungi Anda untuk membahas arah kreatif.'],
        ['Eksekusi produksi', 'Desainer, videografer, dan fotografer mengerjakan sesuai brief yang telah disepakati.'],
        ['Final handover', 'Hasil akhir diserahkan dalam format yang siap digunakan.'],
    ];
@endphp

@section('content')
{{-- hero --}}
<section class="w-hero overflow-hidden">
    <div class="mx-auto grid max-w-7xl items-center gap-12 px-4 py-16 sm:px-6 md:py-24 lg:grid-cols-[1.1fr_1fr] lg:px-8">
        <div>
            <span class="w-eyebrow"><span class="size-1.5 rounded-full bg-lime"></span> Agensi produksi media kreatif &amp; visual</span>
            <h1 class="w-display mt-6 uppercase">Solusi kreatif terbaik untuk brand &amp; bisnis Anda</h1>
            <p class="mt-5 max-w-xl text-[15px] leading-7 text-white/70">PT TipeCreative membantu mengolah gagasan menjadi desain logo, kaos, video, foto, poster, banner, dan flyer.</p>
            <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                <a href="{{ route('website.formulir') }}" class="w-btn-lime">Ajukan Permintaan Layanan <x-icon name="arrow-right" class="size-4" /></a>
                <a href="{{ route('website.portofolio') }}" class="w-btn-ghost">Lihat Portofolio</a>
            </div>
        </div>

        {{-- ilustrasi hero (tanpa foto) --}}
        <div class="relative hidden lg:block" aria-hidden="true">
            <div class="rounded-[28px] border border-white/10 bg-white/5 p-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="h-48 rounded-2xl bg-lime"></div>
                    <div class="h-48 rounded-2xl bg-moss"></div>
                    <div class="h-40 rounded-2xl bg-white/10"></div>
                    <div class="h-40 rounded-2xl bg-gradient-to-br from-moss to-forest ring-1 ring-white/10"></div>
                </div>
            </div>
            
        </div>
    </div>
</section>

{{-- layanan --}}
<section class="bg-white">
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 md:py-24 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
            <span class="w-eyebrow-light">Pilar kapabilitas studio</span>
            <h2 class="w-h2 mt-4">Layanan Kreatif Holistik Berstandar Tinggi</h2>
            <p class="mt-3 text-sm text-slate-500">Dari permintaan identitas visual hingga produksi multimedia, semua dalam satu studio.</p>
        </div>

        <div class="mt-12 grid gap-5 md:grid-cols-3">
            @foreach ($layananUtama as [$judul, $isi, $ikon])
                <div class="w-card bg-paper p-7">
                    <div class="flex size-12 items-center justify-center rounded-full bg-moss text-lime"><x-icon :name="$ikon" class="size-6" /></div>
                    <h3 class="mt-5 text-lg font-bold">{{ $judul }}</h3>
                    <p class="mt-2 text-[13px] leading-6 text-slate-500">{{ $isi }}</p>
                    <a href="{{ route('website.layanan') }}" class="mt-5 inline-flex items-center gap-1.5 text-xs font-bold text-olive hover:underline">Pelajari Detail <x-icon name="arrow-right" class="size-3.5" /></a>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- portofolio --}}
<section class="bg-mist">
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 md:py-24 lg:px-8">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <span class="w-eyebrow-light">Karya unggulan</span>
                <h2 class="w-h2 mt-4">Portofolio Kreasi Pilihan</h2>
                <p class="mt-2 text-sm text-slate-500">Galeri karya belum diisi. Materi akan disediakan oleh PT TipeCreative.</p>
            </div>
            <a href="{{ route('website.portofolio') }}" class="w-btn-line self-start sm:self-auto">Jelajahi Seluruh Proyek <x-icon name="arrow-right" class="size-4" /></a>
        </div>

        <div class="mt-10 grid gap-5 sm:grid-cols-2">
            @foreach (['Brand Identity & Logo', 'Apparel & Kaos', 'Video & Sinematografi', 'Poster & Billboard'] as $kategori)
                <div class="w-card overflow-hidden">
                    <div class="flex h-48 items-end bg-gradient-to-br from-moss to-forest p-5">
                        <span class="rounded-full bg-forest/60 px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-lime">{{ $kategori }}</span>
                    </div>
                    <div class="p-5 text-[13px] text-slate-500">Karya belum diisi</div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- alur kolaborasi --}}
<section class="bg-white">
    <div class="mx-auto grid max-w-7xl gap-10 px-4 py-16 sm:px-6 md:py-24 lg:grid-cols-[1fr_1.2fr] lg:px-8">
        <div>
            <span class="w-eyebrow-light">Alur kolaborasi transparan</span>
            <h2 class="w-h2 mt-4">Bagaimana Kami Merealisasikan Visi Anda</h2>
            <p class="mt-3 max-w-md text-sm text-slate-500">Tanpa kerumitan teknis. Dari brief pertama hingga penyerahan materi, kami pandu setiap tahapnya.</p>
            <a href="{{ route('website.formulir') }}" class="w-btn-dark mt-6">Mulai Konsultasi Gratis <x-icon name="arrow-right" class="size-4" /></a>
        </div>

        <ol class="grid gap-3">
            @foreach ($alur as $i => [$judul, $isi])
                <li class="flex gap-4 rounded-2xl border border-forest/10 bg-paper p-5">
                    <span class="flex size-9 shrink-0 items-center justify-center rounded-full text-sm font-extrabold {{ $i === 0 ? 'bg-lime' : 'bg-mist' }}">{{ $i + 1 }}</span>
                    <div>
                        <div class="text-sm font-bold">{{ $judul }}</div>
                        <p class="mt-1 text-[13px] leading-6 text-slate-500">{{ $isi }}</p>
                    </div>
                </li>
            @endforeach
        </ol>
    </div>
</section>

{{-- ajakan --}}
<section class="px-4 pb-16 sm:px-6 lg:px-8">
    <div class="w-glow mx-auto max-w-7xl rounded-[28px] px-6 py-14 text-center sm:px-12 sm:py-20">
        <span class="w-eyebrow">Siap mewujudkan brand impian Anda?</span>
        <h2 class="w-h2 mx-auto mt-5 max-w-2xl uppercase">Wujudkan visual impian Anda bersama PT TipeCreative</h2>
        <p class="mx-auto mt-4 max-w-xl text-sm text-white/70">Konsultasikan ide brand, produksi seragam apparel, video profil, atau desain materi promosi Anda hari ini.</p>
        <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
            <a href="{{ route('website.formulir') }}" class="w-btn-lime">Ajukan Permintaan Sekarang <x-icon name="arrow-right" class="size-4" /></a>
            <a href="{{ route('website.kontak') }}" class="w-btn-ghost">Hubungi Tim Studio</a>
        </div>
    </div>
</section>
@endsection