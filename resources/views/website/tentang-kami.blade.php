@extends('layouts.website')
@section('title', 'Tentang Kami')

@section('content')
<section class="bg-gradient-to-b from-tint to-white">
    <div class="mx-auto max-w-6xl px-4 py-14 sm:px-6 md:py-16">
        <p class="eyebrow">Tentang Kami</p>
        <h1 class="mt-2 text-[30px] font-bold leading-tight sm:text-4xl">Membentuk ide. Menghubungkan cerita.</h1>
        <p class="mt-4 max-w-2xl text-[15px] text-slate-600">Profil perusahaan belum diisi. Materi akan disediakan oleh PT TipeCreative.</p>
    </div>
</section>

<section class="mx-auto grid max-w-6xl gap-4 px-4 py-12 sm:px-6 md:grid-cols-3">
    @foreach (['Visi', 'Misi', 'Nilai'] as $judul)
        <div class="card p-5">
            <h2 class="text-base font-semibold">{{ $judul }}</h2>
            <p class="mt-1.5 text-[13px] text-slate-500">Belum diisi.</p>
        </div>
    @endforeach
</section>
@endsection