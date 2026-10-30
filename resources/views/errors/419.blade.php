@extends('layouts.guest')
@section('title', 'Sesi Berakhir')

@section('content')
<div class="text-center">
    <div class="mx-auto flex size-[88px] items-center justify-center rounded-2xl bg-tint text-brand-dark">
        <x-icon name="arrow-path" class="size-10" />
    </div>
    <p class="mt-6 text-xs font-semibold uppercase tracking-wide text-brand-dark">Keamanan Akun</p>
    <h1 class="mt-1 text-[28px] font-semibold leading-tight">Sesi login telah berakhir</h1>
    <p class="mt-3 text-sm text-slate-500">Untuk menjaga keamanan akun, sesi Anda telah berakhir. Silakan login kembali untuk melanjutkan aktivitas di CRM.</p>

    <div class="mt-6 border-t pt-6">
        <a href="{{ route('login') }}" class="btn-primary w-full py-3.5">
            Kembali ke halaman Login <x-icon name="login" class="size-5" />
        </a>
        <p class="mt-4 text-xs text-slate-500">Gunakan NIP dan password Anda untuk masuk kembali.</p>
    </div>
</div>
@endsection

@section('luar-kartu')
    <span class="inline-flex items-center gap-2">
        <x-icon name="question-circle" class="size-4" /> Butuh bantuan? Hubungi administrator perusahaan.
    </span>
@endsection