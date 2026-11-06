@extends('layouts.website')
@section('title', 'Kontak')

@section('content')
<section class="bg-gradient-to-b from-tint to-white">
    <div class="mx-auto max-w-6xl px-4 py-14 sm:px-6 md:py-16">
        <p class="eyebrow">Kontak</p>
        <h1 class="mt-2 text-[30px] font-bold leading-tight sm:text-4xl">Percakapan kreatif dimulai di sini.</h1>
        <p class="mt-4 max-w-2xl text-[15px] text-slate-600">Punya kebutuhan desain atau media kreatif? Sampaikan melalui formulir permintaan layanan kami.</p>
    </div>
</section>

<section class="mx-auto grid max-w-6xl gap-6 px-4 py-12 sm:px-6 lg:grid-cols-2">
    <dl class="card divide-y">
        @foreach ([['envelope', 'Email'], ['phone', 'WhatsApp'], ['camera', 'Instagram'], ['map-pin', 'Alamat']] as [$ikon, $label])
            <div class="flex items-center gap-4 p-5">
                <div class="flex size-10 shrink-0 items-center justify-center rounded-lg bg-tint text-brand-dark"><x-icon :name="$ikon" class="size-5" /></div>
                <div>
                    <dt class="text-[13px] font-semibold">{{ $label }}</dt>
                    <dd class="text-[13px] text-slate-500">Belum diisi</dd>
                </div>
            </div>
        @endforeach
    </dl>

    <div class="flex flex-col justify-center rounded-2xl bg-brand p-8 text-white">
        <h2 class="text-2xl font-bold">Kebutuhan kreatif Anda, titik awal kami.</h2>
        <p class="mt-3 text-[13px] text-white/80">Anda dapat memilih lebih dari satu layanan. Tidak perlu login atau membuat akun.</p>
        <a href="{{ route('website.formulir') }}" class="btn-outline mt-6 w-full sm:w-fit">Ajukan Permintaan Layanan</a>
    </div>
</section>
@endsection