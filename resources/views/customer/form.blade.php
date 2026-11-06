@extends('layouts.app')
@section('title', 'Ubah Pelanggan')
@section('heading', 'Customer')

@section('content')
<a href="{{ route('customer.show', $pelanggan) }}" class="inline-flex items-center gap-1.5 text-xs font-medium text-brand-dark hover:underline">
    <x-icon name="arrow-left" class="size-3.5" /> Kembali ke Profil Pelanggan
</a>

<div class="mt-3">
    <h1 class="page-title">Ubah Pelanggan</h1>
    <p class="page-sub">Isi minimal satu kontak: nomor HP, email, atau Instagram.</p>
</div>

<form method="POST" action="{{ route('customer.update', $pelanggan) }}" class="card mt-5 max-w-3xl p-5 sm:p-7">
    @csrf

    <h2 class="text-base font-semibold">Informasi pelanggan</h2>

    <div class="mt-4 grid gap-4 sm:grid-cols-2">
        <div>
            <label for="nama" class="text-xs font-semibold">Nama</label>
            <input id="nama" name="nama" value="{{ old('nama', $pelanggan->nama) }}" class="field mt-1.5 @error('nama') border-lost @enderror">
            @error('nama') <p class="mt-1 text-xs text-lost">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="instansi" class="text-xs font-semibold">Asal/Instansi (opsional)</label>
            <input id="instansi" name="instansi" value="{{ old('instansi', $pelanggan->instansi) }}" class="field mt-1.5 @error('instansi') border-lost @enderror">
            @error('instansi') <p class="mt-1 text-xs text-lost">{{ $message }}</p> @enderror
        </div>
    </div>

    <hr class="my-6">

    <h2 class="text-base font-semibold">Kontak</h2>

    <div class="mt-4 grid gap-4 sm:grid-cols-3">
        <div>
            <label for="no_hp" class="text-xs font-semibold">Nomor HP/WhatsApp</label>
            <input id="no_hp" name="no_hp" type="tel" value="{{ old('no_hp', $pelanggan->no_hp) }}" class="field mt-1.5 @error('no_hp') border-lost @enderror">
        </div>
        <div>
            <label for="email" class="text-xs font-semibold">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email', $pelanggan->email) }}" class="field mt-1.5 @error('email') border-lost @enderror">
        </div>
        <div>
            <label for="instagram" class="text-xs font-semibold">Instagram</label>
            <input id="instagram" name="instagram" value="{{ old('instagram', $pelanggan->instagram) }}" class="field mt-1.5 @error('instagram') border-lost @enderror">
        </div>
    </div>
    @error('no_hp') <p class="mt-1.5 text-xs text-lost">{{ $message }}</p> @enderror
    @error('email') <p class="mt-1.5 text-xs text-lost">{{ $message }}</p> @enderror
    @error('instagram') <p class="mt-1.5 text-xs text-lost">{{ $message }}</p> @enderror

    <hr class="my-6">

    <div>
        <label for="catatan" class="text-xs font-semibold">Catatan</label>
        <textarea id="catatan" name="catatan" rows="4" class="field mt-1.5 @error('catatan') border-lost @enderror">{{ old('catatan', $pelanggan->catatan) }}</textarea>
        @error('catatan') <p class="mt-1 text-xs text-lost">{{ $message }}</p> @enderror
    </div>

    <div class="mt-7 flex flex-col-reverse gap-3 border-t pt-5 sm:flex-row sm:justify-end">
        <a href="{{ route('customer.show', $pelanggan) }}" class="btn-outline">Batal</a>
        <button type="submit" class="btn-primary">Simpan</button>
    </div>
</form>
@endsection