@extends('layouts.guest')
@section('title', 'Login')

@section('content')
<p class="text-xs font-semibold uppercase tracking-wide text-brand-dark">Selamat datang</p>
<h1 class="mt-1 text-[28px] font-semibold leading-tight">Login ke akun Anda</h1>
<p class="mt-2 text-sm text-slate-500">Masukkan NIP dan password untuk mengakses CRM PT TipeCreative.</p>

<form method="POST" action="{{ route('login') }}" novalidate class="mt-7" x-data="{ lihat: false }">
    @csrf

    <label for="nip" class="block text-sm font-semibold">NIP</label>
    <input id="nip" name="nip" type="text" inputmode="numeric" autocomplete="username" autofocus
           value="{{ old('nip') }}" placeholder="Masukkan NIP Anda"
           class="field mt-2 py-3.5">

    <label for="password" class="mt-5 block text-sm font-semibold">Password</label>
    <div class="relative mt-2">
        <input id="password" name="password" :type="lihat ? 'text' : 'password'" type="password"
               autocomplete="current-password" placeholder="Masukkan password Anda"
               class="field py-3.5 pr-12">
        <button type="button" @click="lihat = ! lihat"
                :aria-label="lihat ? 'Sembunyikan password' : 'Tampilkan password'"
                class="absolute inset-y-0 right-0 flex w-12 items-center justify-center text-slate-500 hover:text-ink">
            <x-icon name="eye" x-show="! lihat" class="size-5" />
            <x-icon name="eye-slash" x-show="lihat" x-cloak class="size-5" />
        </button>
    </div>

    @if ($errors->any())
        <div class="mt-4 flex items-start gap-2 rounded-lg bg-lost-tint px-4 py-3 text-sm text-lost" role="alert">
            <x-icon name="exclamation-circle" class="mt-0.5 size-5 shrink-0" />
            <p>{{ $errors->first() }}</p>
        </div>
    @endif

    <button type="submit" class="btn-primary mt-6 w-full py-3.5">
        Login <x-icon name="arrow-right" class="size-4" />
    </button>

    <p class="mt-5 flex items-center gap-2 text-xs text-slate-500">
        <x-icon name="question-circle" class="size-4 shrink-0" />
        Lupa Password? hubungi Admin IT untuk meminta reset password
    </p>
</form>
@endsection