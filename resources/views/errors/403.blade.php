@extends('layouts.app')
@section('title', 'Tidak Ada Akses')
@section('heading', 'Tidak Ada Akses')

@section('content')
<div class="mx-auto mt-6 max-w-md sm:mt-12">
    <div class="card p-6 text-center sm:p-8">
        <div class="mx-auto flex size-16 items-center justify-center rounded-2xl bg-lost-tint text-lost">
            <x-icon name="shield-check" class="size-8" />
        </div>
        <p class="eyebrow mt-6">Akses Ditolak</p>
        <h1 class="mt-1 text-xl font-semibold sm:text-2xl">Kamu tidak punya akses ke halaman ini</h1>
        <p class="mt-3 text-[13px] text-slate-500">Halaman ini bukan untuk role kamu. Kembali ke beranda untuk melanjutkan aktivitas di CRM.</p>

        <div class="mt-6 border-t pt-6">
            <a href="{{ route('beranda') }}" class="btn-primary w-full">Kembali ke beranda</a>
        </div>
    </div>
    <p class="mt-4 text-center text-xs text-slate-500">Butuh bantuan? Hubungi administrator perusahaan.</p>
</div>
@endsection