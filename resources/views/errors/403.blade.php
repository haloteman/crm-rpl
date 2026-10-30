@extends('layouts.app')
@section('title', 'Tidak Ada Akses')
@section('heading', 'Tidak Ada Akses')

@section('content')
<div class="mx-auto mt-6 max-w-md sm:mt-12">
    <div class="card p-6 text-center sm:p-8">
        <div class="mx-auto flex size-20 items-center justify-center rounded-2xl bg-tint text-brand-dark">
            <x-icon name="shield-check" class="size-10" />
        </div>
        <p class="mt-6 text-xs font-semibold uppercase tracking-wide text-brand-dark">Akses Ditolak</p>
        <h2 class="mt-1 text-2xl font-semibold">Kamu tidak punya akses ke halaman ini</h2>
        <p class="mt-3 text-sm text-slate-500">Halaman ini bukan untuk role kamu. Kembali ke beranda untuk melanjutkan aktivitas di CRM.</p>

        <div class="mt-6 border-t pt-6">
            <a href="{{ route('beranda') }}" class="btn-primary w-full py-3">Kembali ke beranda</a>
        </div>
    </div>
    <p class="mt-4 text-center text-xs text-slate-500">Butuh bantuan? Hubungi administrator perusahaan.</p>
</div>
@endsection