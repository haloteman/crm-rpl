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
<section class="overflow-hidden bg-forest bg-[radial-gradient(ellipse_60%_80%_at_90%_0%,rgb(15_28_63/.95),transparent_65%),radial-gradient(ellipse_40%_50%_at_0%_100%,rgb(198_146_66/.08),transparent_70%)] text-white">
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 md:py-24 lg:px-8">
        <span class="inline-flex items-center gap-2 rounded-full border border-lime/25 bg-lime/10 px-3 py-1 text-[11px] font-bold uppercase tracking-[0.08em] text-[#e8c07a]"><span class="size-1.5 rounded-full bg-lime"></span> Tentang PT TipeCreative</span>
        <h1 class="mt-6 max-w-3xl font-display text-[34px] font-semibold leading-[1.15] tracking-[-0.02em] sm:text-5xl lg:text-[56px] lg:leading-[1.2]">Membentuk ide. <span class="italic text-lime">Menghubungkan cerita.</span></h1>
        <p class="mt-5 max-w-xl text-[15px] leading-7 text-white/70">Profil perusahaan belum diisi. Materi akan disediakan oleh PT TipeCreative.</p>
        <div class="mt-8 flex flex-col gap-3 sm:flex-row">
            <a href="{{ route('website.formulir') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-lime px-6 py-3 text-sm font-bold text-forest transition hover:-translate-y-px hover:bg-[#d4a359] hover:shadow-[0_6px_20px_rgb(198_146_66/.3)]">Ajukan Permintaan Layanan <x-icon name="arrow-right" class="size-4" /></a>
            <a href="{{ route('website.layanan') }}" class="inline-flex items-center justify-center gap-2 rounded-lg border border-white/25 px-6 py-3 text-sm font-bold text-white transition hover:bg-white/10">Lihat Layanan</a>
        </div>
    </div>
</section>

<section class="bg-paper">
    <div class="mx-auto grid max-w-7xl gap-4 px-4 py-12 sm:grid-cols-3 sm:px-6 lg:px-8">
        @foreach ([['tentang-1', 'foto'], ['tentang-2', 'video'], ['tentang-3', 'poster']] as [$berkas, $jenis])
            <div class="aspect-[4/3] overflow-hidden rounded-3xl border border-forest/10">
                <x-media :nama="$berkas" :video="$jenis === 'video'" alt="Suasana studio PT TipeCreative">
                    <x-ilustrasi :jenis="$jenis" class="size-full" />
                </x-media>
            </div>
        @endforeach
    </div>
</section>

<section class="bg-white">
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 md:py-24 lg:px-8">
        <div class="mx-auto max-w-2xl text-center">
            <span class="inline-flex items-center gap-2 text-[11px] font-bold uppercase tracking-[0.12em] text-olive">Fondasi strategis</span>
            <h2 class="mt-4 font-display text-[28px] font-semibold leading-[1.2] tracking-[-0.015em] sm:text-[40px]">Visi &amp; Misi Kami</h2>
        </div>

        <div class="mt-12 grid gap-5 md:grid-cols-2">
            <div class="rounded-2xl border border-forest/5 bg-paper p-7 shadow-[0_4px_6px_-1px_rgb(11_20_38/.04),0_16px_32px_-4px_rgb(11_20_38/.07)]">
                <div class="flex size-11 items-center justify-center rounded-full bg-moss text-lime"><x-icon name="eye" class="size-5" /></div>
                <h3 class="mt-5 text-xl font-bold">Visi Perusahaan</h3>
                <p class="mt-2 text-[13px] text-slate-500">Belum diisi.</p>
            </div>
            <div class="rounded-2xl border border-forest/5 bg-mist p-7 shadow-[0_4px_6px_-1px_rgb(11_20_38/.04),0_16px_32px_-4px_rgb(11_20_38/.07)]">
                <div class="flex size-11 items-center justify-center rounded-full bg-lime text-forest"><x-icon name="check-circle" class="size-5" /></div>
                <h3 class="mt-5 text-xl font-bold">Misi Perusahaan</h3>
                <p class="mt-2 text-[13px] text-slate-500">Belum diisi.</p>
            </div>
        </div>
    </div>
</section>

<section class="bg-mist">
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 md:py-24 lg:px-8">
        <span class="inline-flex items-center gap-2 text-[11px] font-bold uppercase tracking-[0.12em] text-olive">Spesialisasi</span>
        <h2 class="mt-4 font-display text-[28px] font-semibold leading-[1.2] tracking-[-0.015em] sm:text-[40px]">Ekosistem Produksi Visual</h2>
        <div class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($layanans as $nama)
                <div class="flex items-center justify-between rounded-2xl border border-forest/5 bg-white p-5 text-sm font-bold shadow-[0_4px_6px_-1px_rgb(11_20_38/.04),0_16px_32px_-4px_rgb(11_20_38/.07)]">
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
            <span class="inline-flex items-center gap-2 text-[11px] font-bold uppercase tracking-[0.12em] text-olive">Metodologi kerja</span>
            <h2 class="mt-4 font-display text-[28px] font-semibold leading-[1.2] tracking-[-0.015em] sm:text-[40px]">Alur Kolaborasi yang Efisien</h2>
        </div>
        <ol class="mt-12 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($langkah as $i => [$judul, $isi])
                <li class="rounded-2xl border border-forest/5 bg-paper p-6 shadow-[0_4px_6px_-1px_rgb(11_20_38/.04),0_16px_32px_-4px_rgb(11_20_38/.07)]">
                    <span class="text-xs font-extrabold text-olive">TAHAP 0{{ $i + 1 }}</span>
                    <div class="mt-3 text-base font-bold">{{ $judul }}</div>
                    <p class="mt-2 text-[13px] leading-6 text-slate-500">{{ $isi }}</p>
                </li>
            @endforeach
        </ol>
    </div>
</section>

<section class="px-4 pb-16 pt-4 sm:px-6 lg:px-8">
    <div class="mx-auto max-w-7xl rounded-[28px] border border-white/10 bg-[radial-gradient(ellipse_70%_120%_at_100%_100%,rgb(198_146_66/.16),transparent_65%),linear-gradient(135deg,#0f1c3f,#0b1426)] px-6 py-14 text-center text-white shadow-[inset_0_1px_0_rgb(255_255_255/.1)] sm:px-12 sm:py-20">
        <h2 class="mx-auto max-w-2xl font-display text-[28px] font-semibold leading-[1.2] tracking-[-0.015em] sm:text-[40px]">Siap mentransformasi identitas visual brand Anda?</h2>
        <p class="mx-auto mt-4 max-w-xl text-sm text-white/70">Konsultasikan kebutuhan desain, produksi apparel, atau media promosi Anda bersama tim kreatif kami.</p>
        <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
            <a href="{{ route('website.formulir') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-lime px-6 py-3 text-sm font-bold text-forest transition hover:-translate-y-px hover:bg-[#d4a359] hover:shadow-[0_6px_20px_rgb(198_146_66/.3)]">Ajukan Permintaan Layanan <x-icon name="arrow-right" class="size-4" /></a>
            <a href="{{ route('website.kontak') }}" class="inline-flex items-center justify-center gap-2 rounded-lg border border-white/25 px-6 py-3 text-sm font-bold text-white transition hover:bg-white/10">Hubungi Tim Studio</a>
        </div>
    </div>
</section>
@endsection