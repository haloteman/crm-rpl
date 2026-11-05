@extends('layouts.website')
@section('title', 'Formulir Permintaan Layanan')

@section('content')
<section class="mx-auto max-w-3xl px-4 py-16 sm:px-6">
    <p class="text-xs font-semibold uppercase tracking-wide text-brand-dark">Mulai Berkolaborasi</p>
    <h1 class="mt-2 text-4xl font-bold">Formulir Permintaan Layanan</h1>
    <p class="mt-4 text-slate-500">Pilih layanan yang Anda minati dan bagikan kebutuhan kreatif Anda. Tidak perlu membuat akun.</p>

    @error('formulir')
        <div class="mt-6 rounded-lg bg-lost-tint px-4 py-3 text-sm text-lost" role="alert">{{ $message }}</div>
    @enderror

    <form method="POST" action="{{ route('website.formulir') }}" novalidate class="card mt-8 p-6 sm:p-8">
        @csrf

        {{-- kolom jebakan bot, jangan dihapus --}}
        <input type="text" name="website" tabindex="-1" autocomplete="off" class="hidden">

        <label for="nama" class="block text-sm font-medium">Nama *</label>
        <input id="nama" name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama Anda"
               class="field mt-1.5 @error('nama') border-lost @enderror">
        @error('nama') <p class="mt-1 text-sm text-lost">{{ $message }}</p> @enderror

        <label for="instansi" class="mt-5 block text-sm font-medium">Asal/Instansi (opsional)</label>
        <input id="instansi" name="instansi" value="{{ old('instansi') }}" placeholder="Nama instansi atau komunitas"
               class="field mt-1.5 @error('instansi') border-lost @enderror">
        @error('instansi') <p class="mt-1 text-sm text-lost">{{ $message }}</p> @enderror

        <p class="mt-5 text-sm font-medium">Status Pemohon *</p>
        @foreach (\App\Models\Lead::TIPE_PEMOHON as $tipe)
            <label class="mt-2 flex items-center gap-3 rounded-lg border px-4 py-3 text-sm">
                <input type="radio" name="tipe_pemohon" value="{{ $tipe }}" @checked(old('tipe_pemohon') === $tipe)>
                {{ $tipe }}
            </label>
        @endforeach
        @error('tipe_pemohon') <p class="mt-1 text-sm text-lost">{{ $message }}</p> @enderror

        <p class="mt-5 text-sm font-medium">Layanan yang diminati *</p>
        <p class="text-xs text-slate-500">Pilih minimal satu. Boleh lebih dari satu layanan.</p>
        <div class="mt-2 grid gap-2 sm:grid-cols-2">
            @foreach ($layanans as $layanan)
                <label class="flex items-center gap-3 rounded-lg border px-4 py-3 text-sm">
                    <input type="checkbox" name="layanan[]" value="{{ $layanan->id }}" @checked(in_array($layanan->id, old('layanan', [])))>
                    {{ $layanan->nama }}
                </label>
            @endforeach
        </div>
        @error('layanan') <p class="mt-1 text-sm text-lost">{{ $message }}</p> @enderror
        @error('layanan.*') <p class="mt-1 text-sm text-lost">{{ $message }}</p> @enderror

        <p class="mt-6 text-sm text-slate-500">Isi email atau nomor HP, minimal salah satu.</p>

        <label for="email" class="mt-3 block text-sm font-medium">Email</label>
        <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="nama@example.com"
               class="field mt-1.5 @error('email') border-lost @enderror">
        @error('email') <p class="mt-1 text-sm text-lost">{{ $message }}</p> @enderror

        <label for="no_hp" class="mt-5 block text-sm font-medium">Nomor HP</label>
        <input id="no_hp" name="no_hp" type="tel" value="{{ old('no_hp') }}" placeholder="Contoh: 08xxxxxxxxxx"
               class="field mt-1.5 @error('no_hp') border-lost @enderror">
        @error('no_hp') <p class="mt-1 text-sm text-lost">{{ $message }}</p> @enderror

        <label for="pesan" class="mt-5 block text-sm font-medium">Pesan kebutuhan (opsional)</label>
        <textarea id="pesan" name="pesan" rows="4" placeholder="Ceritakan tujuan, ide, atau kebutuhan visual Anda."
                  class="field mt-1.5 @error('pesan') border-lost @enderror">{{ old('pesan') }}</textarea>
        @error('pesan') <p class="mt-1 text-sm text-lost">{{ $message }}</p> @enderror

        <p class="mt-6 text-xs text-slate-500">Data Anda hanya kami pakai untuk menghubungi Anda terkait permintaan layanan ini.</p>

        <button type="submit" class="btn-primary mt-4">Kirim Permintaan Layanan</button>
    </form>
</section>
@endsection
