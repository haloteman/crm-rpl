@extends('layouts.app')
@section('title', 'Ubah Pelanggan')
@section('heading', 'Customer')

@section('content')
<div>
    <h1 class="text-[28px] font-bold leading-tight">Ubah Pelanggan</h1>
    <p class="mt-1 text-sm text-slate-500">Isi minimal satu kontak: nomor HP, email, atau Instagram.</p>
</div>

<form method="POST" action="{{ route('customer.update', $pelanggan) }}" class="card mt-5 grid max-w-2xl gap-5 p-5 sm:p-6">
    @csrf

    <div>
        <label for="nama" class="text-sm font-medium">Nama</label>
        <input id="nama" name="nama" value="{{ old('nama', $pelanggan->nama) }}" class="field mt-1.5 @error('nama') border-lost @enderror">
        @error('nama') <p class="mt-1 text-sm text-lost">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="instansi" class="text-sm font-medium">Asal/Instansi (opsional)</label>
        <input id="instansi" name="instansi" value="{{ old('instansi', $pelanggan->instansi) }}" class="field mt-1.5 @error('instansi') border-lost @enderror">
        @error('instansi') <p class="mt-1 text-sm text-lost">{{ $message }}</p> @enderror
    </div>

    <div class="grid gap-4 sm:grid-cols-3">
        <div>
            <label for="no_hp" class="text-sm font-medium">Nomor HP/WhatsApp</label>
            <input id="no_hp" name="no_hp" type="tel" value="{{ old('no_hp', $pelanggan->no_hp) }}" class="field mt-1.5 @error('no_hp') border-lost @enderror">
        </div>
        <div>
            <label for="email" class="text-sm font-medium">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email', $pelanggan->email) }}" class="field mt-1.5 @error('email') border-lost @enderror">
        </div>
        <div>
            <label for="instagram" class="text-sm font-medium">Instagram</label>
            <input id="instagram" name="instagram" value="{{ old('instagram', $pelanggan->instagram) }}" class="field mt-1.5 @error('instagram') border-lost @enderror">
        </div>
        @error('no_hp') <p class="text-sm text-lost sm:col-span-3">{{ $message }}</p> @enderror
        @error('email') <p class="text-sm text-lost sm:col-span-3">{{ $message }}</p> @enderror
        @error('instagram') <p class="text-sm text-lost sm:col-span-3">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="catatan" class="text-sm font-medium">Catatan</label>
        <textarea id="catatan" name="catatan" rows="4" class="field mt-1.5 @error('catatan') border-lost @enderror">{{ old('catatan', $pelanggan->catatan) }}</textarea>
        @error('catatan') <p class="mt-1 text-sm text-lost">{{ $message }}</p> @enderror
    </div>

    <div class="flex flex-col-reverse gap-3 border-t pt-5 sm:flex-row sm:justify-end">
        <a href="{{ route('customer.show', $pelanggan) }}" class="btn-outline">Batal</a>
        <button type="submit" class="btn-primary">Simpan</button>
    </div>
</form>
@endsection
