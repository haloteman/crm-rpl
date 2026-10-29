@extends('layouts.guest')
@section('title', 'Ubah Password')

@section('content')
<h1 class="text-center text-xl font-semibold">Ubah Password</h1>

@if (auth()->user()->must_change_password)
    <p class="mt-2 text-center text-sm text-slate-500">Kamu masih pakai password sementara. Ganti dulu sebelum lanjut.</p>
@endif

<form method="POST" action="{{ route('password.update') }}" novalidate class="mt-6">
    @csrf

    <label for="password_lama" class="block text-lg">Password Lama</label>
    <input id="password_lama" name="password_lama" type="password" autocomplete="current-password"
           class="mt-2 w-full rounded-full border border-slate-400 bg-white px-4 py-3.5 font-light outline-none focus:border-brand focus:ring-2 focus:ring-brand/30">
    @error('password_lama') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror

    <label for="password_baru" class="mt-5 block text-lg">Password Baru</label>
    <input id="password_baru" name="password_baru" type="password" autocomplete="new-password"
           class="mt-2 w-full rounded-full border border-slate-400 bg-white px-4 py-3.5 font-light outline-none focus:border-brand focus:ring-2 focus:ring-brand/30">
    @error('password_baru') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror

    <label for="password_baru_confirmation" class="mt-5 block text-lg">Konfirmasi Password Baru</label>
    <input id="password_baru_confirmation" name="password_baru_confirmation" type="password" autocomplete="new-password"
           class="mt-2 w-full rounded-full border border-slate-400 bg-white px-4 py-3.5 font-light outline-none focus:border-brand focus:ring-2 focus:ring-brand/30">

    <button type="submit" class="mt-10 w-full rounded-full bg-brand py-3.5 text-lg font-semibold text-white hover:bg-brand-dark">SIMPAN</button>
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
