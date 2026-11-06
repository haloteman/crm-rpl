@extends('layouts.website')
@section('title', 'Portofolio')

@section('content')
<section class="bg-gradient-to-b from-tint to-white">
    <div class="mx-auto max-w-6xl px-4 py-14 sm:px-6 md:py-16">
        <p class="eyebrow">Portofolio</p>
        <h1 class="mt-2 text-[30px] font-bold leading-tight sm:text-4xl">Bentuk, warna, dan cerita yang bertemu.</h1>
        <p class="mt-4 max-w-2xl text-[15px] text-slate-600">Galeri karya belum diisi. Materi akan disediakan oleh PT TipeCreative.</p>
    </div>
</section>

<section class="mx-auto max-w-6xl px-4 py-12 sm:px-6">
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
        @foreach (range(1, 6) as $i)
            <div class="card overflow-hidden">
                <div class="flex h-40 items-center justify-center bg-thead text-slate-300"><x-icon name="folder" class="size-10" /></div>
                <div class="p-4 text-[13px] text-slate-500">Karya belum diisi</div>
            </div>
        @endforeach
    </div>
</section>
@endsection