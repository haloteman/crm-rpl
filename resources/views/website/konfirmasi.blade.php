@extends('layouts.website')
@section('title', 'Permintaan Terkirim')

@php
    $langkah = [
        ['Validasi & bedah brief', 'Tim kami meninjau kebutuhan, preferensi estetika, dan layanan yang Anda pilih.'],
        ['Diskusi lanjutan', 'Kami menghubungi Anda melalui email atau nomor HP yang Anda berikan.'],
        ['Kickoff & eksekusi visual', 'Setelah kebutuhan disepakati, pengerjaan dimulai oleh tim kreatif kami.'],
    ];
@endphp

@section('content')
<section class="overflow-hidden bg-forest bg-[radial-gradient(ellipse_60%_80%_at_90%_0%,rgb(15_28_63/.95),transparent_65%),radial-gradient(ellipse_40%_50%_at_0%_100%,rgb(198_146_66/.08),transparent_70%)] text-white">
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 md:py-24 lg:px-8">
        <span class="inline-flex items-center gap-2 rounded-full border border-lime/25 bg-lime/10 px-3 py-1 text-[11px] font-bold uppercase tracking-[0.08em] text-[#e8c07a]"><span class="size-1.5 rounded-full bg-lime"></span> Konfirmasi resmi &bull; Terima kasih telah menghubungi kami</span>
        <h1 class="mt-6 max-w-3xl font-display text-[34px] font-semibold leading-[1.15] tracking-[-0.02em] sm:text-5xl lg:text-[56px] lg:leading-[1.2]">Permintaan Layanan <span class="italic text-lime">Berhasil Dikirim!</span></h1>
        <p class="mt-5 max-w-xl text-[15px] leading-7 text-white/70">Kebutuhan kreatif Anda telah kami terima. Tim PT TipeCreative akan meninjau informasi yang Anda sampaikan.</p>
        <div class="mt-8 flex flex-col gap-3 sm:flex-row">
            <a href="{{ route('website.beranda') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-lime px-6 py-3 text-sm font-bold text-forest transition hover:-translate-y-px hover:bg-[#d4a359] hover:shadow-[0_6px_20px_rgb(198_146_66/.3)]">Kembali ke Beranda</a>
            <a href="{{ route('website.layanan') }}" class="inline-flex items-center justify-center gap-2 rounded-lg border border-white/25 px-6 py-3 text-sm font-bold text-white transition hover:bg-white/10">Lihat Layanan</a>
        </div>
    </div>
</section>

<section class="bg-paper">
    <div class="mx-auto max-w-3xl px-4 py-16 sm:px-6 md:py-20">
        <div class="rounded-2xl border border-forest/5 bg-white p-7 shadow-[0_4px_6px_-1px_rgb(11_20_38/.04),0_16px_32px_-4px_rgb(11_20_38/.07)] sm:p-9">
            <div class="flex items-center gap-3">
                <span class="flex size-11 items-center justify-center rounded-full bg-lime"><x-icon name="check" class="size-6" /></span>
                <div>
                    <h2 class="text-lg font-extrabold">Apa langkah selanjutnya?</h2>
                    <p class="text-xs text-slate-500">Tiga fase setelah formulir terkirim</p>
                </div>
            </div>

            <ol class="mt-7 space-y-5">
                @foreach ($langkah as $i => [$judul, $isi])
                    <li class="flex gap-4">
                        <span class="flex size-8 shrink-0 items-center justify-center rounded-full text-sm font-extrabold {{ $i === 0 ? 'bg-lime' : 'bg-mist' }}">{{ $i + 1 }}</span>
                        <div>
                            <div class="text-sm font-bold">{{ $judul }}</div>
                            <p class="mt-1 text-[13px] leading-6 text-slate-500">{{ $isi }}</p>
                        </div>
                    </li>
                @endforeach
            </ol>
        </div>
    </div>
</section>
@endsection