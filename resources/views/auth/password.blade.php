@extends('layouts.guest')
@section('title', 'Ubah Password')

@section('content')
<p class="text-xs font-semibold uppercase tracking-wide text-brand-dark">Keamanan Akun</p>
<h1 class="mt-1 text-2xl font-semibold">Ubah Password</h1>

@if (auth()->user()->must_change_password)
    <div class="mt-4 flex items-start gap-3 rounded-lg bg-amber-50 px-4 py-3 text-sm text-amber-800">
        <x-icon name="info" class="mt-0.5 size-5 shrink-0" />
        <p>Kamu masih pakai password sementara. Ganti dulu sebelum lanjut.</p>
    </div>
@endif

<form method="POST" action="{{ route('password.update') }}" novalidate class="mt-6" x-data="{ lihat: false }">
    @csrf

    <label for="password_lama" class="block text-sm font-medium">Password Lama</label>
    <input id="password_lama" name="password_lama" :type="lihat ? 'text' : 'password'" type="password" autocomplete="current-password"
           placeholder="Masukkan password lama"
           class="field mt-1.5 @error('password_lama') border-lost @else border-slate-300 @enderror">
    @error('password_lama') <p class="mt-1 text-sm text-lost">{{ $message }}</p> @enderror

    <label for="password_baru" class="mt-5 block text-sm font-medium">Password Baru</label>
    <input id="password_baru" name="password_baru" :type="lihat ? 'text' : 'password'" type="password" autocomplete="new-password"
           placeholder="Masukkan password baru"
           class="field mt-1.5 @error('password_baru') border-lost @else border-slate-300 @enderror">
    @error('password_baru') <p class="mt-1 text-sm text-lost">{{ $message }}</p> @enderror

    <label for="password_baru_confirmation" class="mt-5 block text-sm font-medium">Konfirmasi Password Baru</label>
    <input id="password_baru_confirmation" name="password_baru_confirmation" :type="lihat ? 'text' : 'password'" type="password" autocomplete="new-password"
           placeholder="Ulangi password baru"
           class="field mt-1.5 border-slate-300">

    <label class="mt-4 flex cursor-pointer items-center gap-2 text-sm text-slate-500">
        <input type="checkbox" x-model="lihat" class="size-4 rounded border-slate-300 accent-brand-dark">
        Tampilkan password
    </label>

    <button type="submit" class="btn-primary mt-8 w-full rounded-lg py-3 text-base font-semibold">Simpan</button>
</form>

@if (auth()->user()->must_change_password)
    <form method="POST" action="{{ route('logout') }}" class="mt-4 text-center">
        @csrf
        <button type="submit" class="text-sm text-slate-500 hover:underline">Logout</button>
    </form>
@else
    <a href="{{ route('beranda') }}" class="mt-4 block text-center text-sm text-slate-500 hover:underline">Kembali</a>
@endif
@endsection