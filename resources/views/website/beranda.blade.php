@extends('layouts.website')
@section('title', 'Beranda')

@php
    $layananUtama = [
        ['01 / Brand', 'Brand Identity & Logo', 'Desain logo dan identitas visual yang konsisten, dari konsep hingga file siap pakai.'],
        ['02 / Video', 'Video & Motion Production', 'Editing video sinematik untuk konten promosi, kampanye, dan media sosial.'],
        ['03 / Apparel', 'Apparel & Print Media', 'Desain kaos, poster, banner, dan flyer yang siap dicetak untuk kebutuhan brand Anda.'],
    ];
    $alur = [
        ['Kirim brief & permintaan layanan', 'Isi formulir online berisi kebutuhan layanan, tenggat waktu, dan preferensi gaya yang Anda inginkan.'],
        ['Tinjauan & diskusi konsep', 'Tim kami meninjau permintaan Anda, lalu menghubungi Anda untuk membahas arah kreatif.'],
        ['Eksekusi produksi', 'Desainer, videografer, dan fotografer mengerjakan sesuai brief yang telah disepakati.'],
        ['Final handover', 'Hasil akhir diserahkan dalam format yang siap digunakan.'],
    ];
    $nilai = [
        ['Tanpa login', 'Cukup isi formulir permintaan', 'check-circle'],
        ['7 layanan kreatif', 'Logo, kaos, video, foto, cetak', 'eye'],
        ['Tim multidisiplin', 'Desainer, videografer, fotografer', 'camera'],
    ];
    $ikonPilar = ['eye', 'camera', 'check-circle'];
@endphp

@section('content')
{{-- hero --}}
<section class="overflow-hidden bg-forest bg-[radial-gradient(ellipse_60%_80%_at_90%_0%,rgb(15_28_63/.95),transparent_65%),radial-gradient(ellipse_40%_50%_at_0%_100%,rgb(198_146_66/.08),transparent_70%)] pb-28 text-white md:pb-32">
    <div class="mx-auto grid max-w-7xl items-center gap-12 px-4 py-16 sm:px-6 md:py-24 lg:grid-cols-[minmax(0,1.1fr)_minmax(0,1fr)] lg:px-8">
        <div>
            <span class="inline-flex items-center gap-2 rounded-full border border-lime/25 bg-lime/10 px-3 py-1 text-[11px] font-bold uppercase tracking-[0.08em] text-[#e8c07a]"><span class="size-1.5 rounded-full bg-lime"></span> Agensi multimedia &amp; desain strategis</span>
            <h1 class="mt-6 font-display text-[34px] font-semibold leading-[1.15] tracking-[-0.02em] sm:text-5xl lg:text-[46px] lg:leading-[1.2] xl:text-[52px]">Mewujudkan Prestasi Visual &amp; <em class="italic text-lime">Nilai Merek</em> Berdaya Saing</h1>
            <p class="mt-5 max-w-xl text-[15px] leading-7 text-white/70">Rumah produksi kreatif yang mengolah gagasan menjadi desain logo, kaos, video, foto, poster, banner, dan flyer untuk mendongkrak reputasi serta konversi bisnis Anda.</p>
            <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                <a href="{{ route('website.formulir') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-lime px-6 py-3 text-sm font-bold text-forest transition hover:-translate-y-px hover:bg-[#d4a359] hover:shadow-[0_6px_20px_rgb(198_146_66/.3)]">Ajukan Permintaan Layanan <x-icon name="arrow-right" class="size-4" /></a>
                <a href="{{ route('website.portofolio') }}" class="inline-flex items-center justify-center gap-2 rounded-lg border border-white/25 px-6 py-3 text-sm font-bold text-white transition hover:bg-white/10">Lihat Portofolio</a>
            </div>
        </div>

        {{-- visual hero: video/foto asli kalau ada di public/media, kalau tidak tampil ilustrasi --}}
        <div class="relative mx-2 mt-2 lg:mx-0 lg:mt-0">
            <div class="relative aspect-[4/3] overflow-hidden rounded-3xl border border-lime/25 shadow-2xl shadow-black/40">
                <x-media nama="hero" video alt="Studio kreatif PT TipeCreative">
                    <x-ilustrasi jenis="video" class="size-full" />
                </x-media>
                <span class="absolute bottom-4 left-4 inline-flex items-center gap-2 rounded-full bg-forest/75 px-3 py-1.5 text-[11px] font-bold text-white backdrop-blur">
                    <span class="relative flex size-2"><span class="absolute inline-flex size-full animate-ping rounded-full bg-lime"></span><span class="relative size-2 rounded-full bg-lime"></span></span>
                    Showreel studio
                </span>
            </div>

        </div>
    </div>
</section>

{{-- tiga pilar: kartu menumpuk di batas hero --}}
<section class="relative z-10 -mt-20 md:-mt-24">
    <div class="mx-auto grid max-w-7xl gap-5 px-4 sm:px-6 md:grid-cols-3 lg:px-8">
        @foreach ($layananUtama as [$nomor, $judul, $isi])
            <div class="flex flex-col rounded-2xl border border-forest/5 bg-white p-6 shadow-[0_4px_6px_-1px_rgb(11_20_38/.04),0_16px_32px_-4px_rgb(11_20_38/.07)] transition duration-300 hover:-translate-y-1 hover:shadow-[0_8px_16px_-2px_rgb(11_20_38/.06),0_24px_48px_-6px_rgb(198_146_66/.14)]">
                <div class="flex items-center justify-between">
                    <span class="flex size-10 items-center justify-center rounded-full bg-paper text-lime ring-1 ring-forest/5"><x-icon :name="$ikonPilar[$loop->index]" class="size-5" /></span>
                    <span class="text-[10px] font-bold uppercase tracking-[0.12em] text-slate-400">{{ $nomor }}</span>
                </div>
                <h3 class="mt-5 text-[17px] font-bold">{{ $judul }}</h3>
                <p class="mt-2 flex-1 text-[13px] leading-6 text-slate-500">{{ $isi }}</p>
                <a href="{{ route('website.layanan') }}" class="mt-5 inline-flex items-center gap-1.5 text-xs font-bold text-olive hover:underline">Pelajari Layanan <x-icon name="arrow-right" class="size-3.5" /></a>
            </div>
        @endforeach
    </div>
</section>

{{-- solusi unggulan (kartu foto) --}}
<section>
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 md:py-24 lg:px-8">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div class="max-w-2xl">
                <span class="inline-flex items-center gap-2 text-[11px] font-bold uppercase tracking-[0.12em] text-olive">Keahlian terintegrasi</span>
                <h2 class="mt-3 font-display text-[28px] font-semibold leading-[1.2] tracking-[-0.015em] sm:text-[40px]">Solusi Kreatif Unggulan Kami</h2>
                <p class="mt-3 text-sm text-slate-500">Dari permintaan identitas visual hingga produksi multimedia, semua dalam satu studio.</p>
            </div>
            <a href="{{ route('website.layanan') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-olive hover:underline">Eksplorasi Seluruh Layanan <x-icon name="arrow-right" class="size-3.5" /></a>
        </div>

        <div class="mt-10 grid gap-6 md:grid-cols-3">
            @foreach ([['Identitas Visual', 'Desain Logo & Identitas Visual', 'Penciptaan identitas visual autentik: logo, tipografi korporat, palet warna, dan panduan penggunaan brand.', 'logo', 'eye'], ['Multimedia & Motion', 'Produksi Video Sinematik & Iklan', 'Editing video komersial, color grading, motion graphics, dan penyesuaian format untuk berbagai platform.', 'video', 'camera'], ['Apparel & Cetak', 'Desain Kaos & Merchandise', 'Desain sablon, kaos, dan materi cetak siap produksi untuk merchandise brand Anda.', 'kaos', 'check-circle']] as [$kat, $judul, $isi, $jenis, $ikon])
                <article class="overflow-hidden rounded-2xl border border-forest/5 bg-white shadow-[0_4px_6px_-1px_rgb(11_20_38/.04),0_16px_32px_-4px_rgb(11_20_38/.07)] transition duration-300 hover:-translate-y-1 hover:shadow-[0_8px_16px_-2px_rgb(11_20_38/.06),0_24px_48px_-6px_rgb(198_146_66/.14)]">
                    <div class="relative h-52">
                        <x-media :nama="'layanan-'.$jenis" :alt="$judul">
                            <x-ilustrasi :jenis="$jenis" class="h-52 w-full" />
                        </x-media>
                        <span class="absolute -bottom-5 right-5 flex size-11 items-center justify-center rounded-full bg-lime text-forest ring-4 ring-white"><x-icon :name="$ikon" class="size-5" /></span>
                    </div>
                    <div class="p-6 pt-7">
                        <div class="text-[10px] font-bold uppercase tracking-[0.12em] text-olive">{{ $kat }}</div>
                        <h3 class="mt-2 text-[17px] font-bold">{{ $judul }}</h3>
                        <p class="mt-2 text-[13px] leading-6 text-slate-500">{{ $isi }}</p>
                        <a href="{{ route('website.layanan') }}" class="mt-5 flex w-full items-center justify-center rounded-lg bg-mist py-2.5 text-xs font-bold text-olive transition hover:bg-lime/15">Pelajari Layanan</a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

{{-- showreel --}}
<section class="bg-forest bg-[radial-gradient(ellipse_60%_80%_at_90%_0%,rgb(15_28_63/.95),transparent_65%),radial-gradient(ellipse_40%_50%_at_0%_100%,rgb(198_146_66/.08),transparent_70%)] text-white">
    <div class="mx-auto grid max-w-7xl items-center gap-10 px-4 py-16 sm:px-6 md:py-24 lg:grid-cols-[minmax(0,1fr)_minmax(0,1.3fr)] lg:px-8">
        <div>
            <span class="inline-flex items-center gap-2 rounded-full border border-lime/25 bg-lime/10 px-3 py-1 text-[11px] font-bold uppercase tracking-[0.08em] text-[#e8c07a]">Showreel</span>
            <h2 class="mt-4 font-display text-[28px] font-semibold leading-[1.2] tracking-[-0.015em] sm:text-[40px]">Lihat cara kami bercerita <em class="italic text-lime">lewat visual.</em></h2>
            <p class="mt-3 max-w-md text-sm leading-6 text-white/70">Cuplikan karya video, foto, dan desain dari studio kami. Video showreel belum diisi, materi akan disediakan oleh PT TipeCreative.</p>
            <a href="{{ route('website.portofolio') }}" class="mt-6 inline-flex items-center justify-center gap-2 rounded-lg bg-lime px-6 py-3 text-sm font-bold text-forest transition hover:-translate-y-px hover:bg-[#d4a359] hover:shadow-[0_6px_20px_rgb(198_146_66/.3)]">Lihat Portofolio <x-icon name="arrow-right" class="size-4" /></a>
        </div>
        <div class="relative aspect-video overflow-hidden rounded-3xl border border-lime/25 shadow-2xl shadow-black/40">
            <x-media nama="showreel" video kontrol alt="Showreel PT TipeCreative">
                <x-ilustrasi jenis="video" class="size-full" />
            </x-media>
        </div>
    </div>
</section>

{{-- portofolio --}}
<section>
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 md:py-24 lg:px-8">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <span class="inline-flex items-center gap-2 text-[11px] font-bold uppercase tracking-[0.12em] text-olive">Karya unggulan</span>
                <h2 class="mt-3 font-display text-[28px] font-semibold leading-[1.2] tracking-[-0.015em] sm:text-[40px]">Portofolio Kreasi Pilihan</h2>
                <p class="mt-2 text-sm text-slate-500">Galeri karya belum diisi. Materi akan disediakan oleh PT TipeCreative.</p>
            </div>
            <a href="{{ route('website.portofolio') }}" class="inline-flex items-center justify-center gap-2 self-start rounded-lg border border-forest/15 bg-white px-6 py-3 text-sm font-bold text-forest transition hover:bg-forest/5 sm:self-auto">Jelajahi Seluruh Proyek <x-icon name="arrow-right" class="size-4" /></a>
        </div>

        <div class="mt-10 grid gap-6 sm:grid-cols-2">
            @foreach ([['Brand Identity & Logo', 'logo'], ['Apparel & Kaos', 'kaos'], ['Video & Sinematografi', 'video'], ['Poster & Billboard', 'poster']] as [$kategori, $jenis])
                <div class="overflow-hidden rounded-2xl border border-forest/5 bg-white shadow-[0_4px_6px_-1px_rgb(11_20_38/.04),0_16px_32px_-4px_rgb(11_20_38/.07)] transition duration-300 hover:-translate-y-1 hover:shadow-[0_8px_16px_-2px_rgb(11_20_38/.06),0_24px_48px_-6px_rgb(198_146_66/.14)]">
                    <div class="relative h-52">
                        <x-media :nama="'beranda-'.$jenis" :alt="$kategori">
                            <x-ilustrasi :jenis="$jenis" class="h-52 w-full" />
                        </x-media>
                        <span class="absolute left-4 top-4 rounded-full bg-forest/75 px-3 py-1 text-[10px] font-bold uppercase tracking-wider text-lime backdrop-blur">{{ $kategori }}</span>
                    </div>
                    <div class="p-5 text-[13px] text-slate-500">Karya belum diisi</div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- alur kolaborasi --}}
<section class="bg-mist">
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 md:py-24 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
            <span class="inline-flex items-center gap-2 text-[11px] font-bold uppercase tracking-[0.12em] text-olive">Metodologi produksi</span>
            <h2 class="mt-3 font-display text-[28px] font-semibold leading-[1.2] tracking-[-0.015em] sm:text-[40px]">Cara Kami Bekerja</h2>
            <p class="mt-3 text-sm text-slate-500">Tanpa kerumitan teknis. Dari brief pertama hingga penyerahan materi, kami pandu setiap tahapnya.</p>
        </div>

        <ol class="mt-12 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($alur as $i => [$judul, $isi])
                <li class="rounded-2xl border border-forest/5 bg-white p-6 shadow-[0_4px_6px_-1px_rgb(11_20_38/.04),0_16px_32px_-4px_rgb(11_20_38/.07)]">
                    <span class="flex size-12 items-center justify-center rounded-full text-sm font-extrabold {{ $i === 0 ? 'bg-lime text-forest' : 'bg-[#e2e8f0] text-forest' }}">{{ sprintf('%02d', $i + 1) }}</span>
                    <div class="mt-4 text-sm font-bold">{{ $judul }}</div>
                    <p class="mt-1.5 text-[13px] leading-6 text-slate-500">{{ $isi }}</p>
                </li>
            @endforeach
        </ol>

        <div class="mt-10 grid gap-3 sm:grid-cols-3">
            @foreach ($nilai as [$judul, $isi, $ikon])
                <div class="flex items-center gap-3 rounded-2xl border border-forest/5 bg-white px-5 py-4">
                    <span class="flex size-10 shrink-0 items-center justify-center rounded-full bg-lime text-forest"><x-icon :name="$ikon" class="size-5" /></span>
                    <div>
                        <div class="text-sm font-bold">{{ $judul }}</div>
                        <div class="text-[11px] text-slate-500">{{ $isi }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ajakan --}}
<section class="px-4 py-16 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-7xl rounded-3xl border border-white/10 bg-[radial-gradient(ellipse_70%_120%_at_100%_100%,rgb(198_146_66/.16),transparent_65%),linear-gradient(135deg,#0f1c3f,#0b1426)] px-6 py-14 text-center text-white shadow-[inset_0_1px_0_rgb(255_255_255/.1)] sm:px-12 sm:py-20">
        <span class="inline-flex items-center gap-2 rounded-full border border-lime/25 bg-lime/10 px-3 py-1 text-[11px] font-bold uppercase tracking-[0.08em] text-[#e8c07a]">Siap mewujudkan brand impian Anda?</span>
        <h2 class="mx-auto mt-5 max-w-2xl font-display text-[28px] font-semibold leading-[1.2] tracking-[-0.015em] sm:text-[40px]">Wujudkan visual impian Anda bersama <em class="italic text-lime">PT TipeCreative</em></h2>
        <p class="mx-auto mt-4 max-w-xl text-sm text-white/70">Konsultasikan ide brand, produksi seragam apparel, video profil, atau desain materi promosi Anda hari ini.</p>
        <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
            <a href="{{ route('website.formulir') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-lime px-6 py-3 text-sm font-bold text-forest transition hover:-translate-y-px hover:bg-[#d4a359] hover:shadow-[0_6px_20px_rgb(198_146_66/.3)]">Ajukan Permintaan Sekarang <x-icon name="arrow-right" class="size-4" /></a>
            <a href="{{ route('website.kontak') }}" class="inline-flex items-center justify-center gap-2 rounded-lg border border-white/25 px-6 py-3 text-sm font-bold text-white transition hover:bg-white/10">Hubungi Tim Studio</a>
        </div>
    </div>
</section>
@endsection