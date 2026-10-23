@extends('layouts.guest')
@section('title', 'Login')

@section('content')
<form method="POST" action="{{ route('login') }}" novalidate>
    @csrf

    <label for="nip" class="block text-lg">NIP</label>
    <input id="nip" name="nip" type="text" inputmode="numeric" autocomplete="username" autofocus
           value="{{ old('nip') }}" placeholder="Masukkan NIP"
           class="mt-2 w-full rounded-full border border-slate-400 bg-white px-4 py-3.5 font-light outline-none placeholder:text-slate-400 focus:border-brand focus:ring-2 focus:ring-brand/30">

    <label for="password" class="mt-5 block text-lg">Password:</label>
    <input id="password" name="password" type="password" autocomplete="current-password" placeholder="Masukkan Password"
           class="mt-2 w-full rounded-full border border-slate-400 bg-white px-4 py-3.5 font-light outline-none placeholder:text-slate-400 focus:border-brand focus:ring-2 focus:ring-brand/30">

    @if ($errors->any())
        <p class="mt-4 text-sm text-red-600" role="alert">{{ $errors->first() }}</p>
    @endif

    <button type="submit" class="mt-12 w-full rounded-full bg-brand py-3.5 text-lg font-semibold text-white hover:bg-brand-dark">LOGIN</button>
</form>
@endsection