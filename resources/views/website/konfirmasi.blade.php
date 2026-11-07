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
<section class="w-hero overflow-hidden">
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 md:py-24 lg:px-8">
        <span class="w-eyebrow"><span class="size-1.5 rounded-full bg-lime"></span> Konfirmasi resmi &bull; Terima kasih telah menghubungi kami</span>
        <h1 class="w-display mt-6 max-w-3xl">Permintaan Layanan <span class="text-lime">Berhasil Dikirim!</span></h1>
        <p class="mt-5 max-w-xl text-[15px] leading-7 text-white/70">Kebutuhan kreatif Anda telah kami terima. Tim PT TipeCreative akan meninjau informasi yang Anda sampaikan.</p>
        <div class="mt-8 flex flex-col gap-3 sm:flex-row">
            <a href="{{ route('website.beranda') }}" class="w-btn-lime">Kembali ke Beranda</a>
            <a href="{{ route('website.layanan') }}" class="w-btn-ghost">Lihat Layanan</a>
        </div>
    </div>
</section>

<section class="bg-paper">
    <div class="mx-auto max-w-3xl px-4 py-16 sm:px-6 md:py-20">
        <div class="w-card bg-white p-7 sm:p-9">
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