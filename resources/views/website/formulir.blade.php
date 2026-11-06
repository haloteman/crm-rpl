@extends('layouts.website')
@section('title', 'Formulir Permintaan Layanan')

@section('content')
<section class="mx-auto max-w-3xl px-4 py-12 sm:px-6 md:py-16">
    <p class="eyebrow">Mulai Berkolaborasi</p>
    <h1 class="mt-2 text-[28px] font-bold leading-tight sm:text-4xl">Formulir Permintaan Layanan</h1>
    <p class="mt-3 text-[15px] text-slate-600">Pilih layanan yang Anda minati dan bagikan kebutuhan kreatif Anda. Tidak perlu membuat akun.</p>

    @error('formulir')
        <div class="mt-6 rounded-lg bg-lost-tint px-4 py-3 text-[13px] text-lost" role="alert">{{ $message }}</div>
    @enderror

    <form method="POST" action="{{ route('website.formulir') }}" novalidate class="card mt-8 p-5 sm:p-8">
        @csrf

        {{-- kolom jebakan bot, jangan dihapus --}}
        <input type="text" name="website" tabindex="-1" autocomplete="off" class="hidden">

        <div class="grid gap-5 sm:grid-cols-2">
            <div>
                <label for="nama" class="text-xs font-semibold">Nama *</label>
                <input id="nama" name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama Anda"
                       class="field mt-1.5 @error('nama') border-lost @enderror">
                @error('nama') <p class="mt-1 text-xs text-lost">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="instansi" class="text-xs font-semibold">Asal/Instansi (opsional)</label>
                <input id="instansi" name="instansi" value="{{ old('instansi') }}" placeholder="Nama instansi atau komunitas"
                       class="field mt-1.5 @error('instansi') border-lost @enderror">
                @error('instansi') <p class="mt-1 text-xs text-lost">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="mt-5">
            <p class="text-xs font-semibold">Status Pemohon *</p>
            <div class="mt-1.5 grid gap-2 sm:grid-cols-2">
                @foreach (\App\Models\Lead::TIPE_PEMOHON as $tipe)
                    <label class="flex cursor-pointer items-center gap-3 rounded-lg border bg-white px-4 py-2.5 text-[13px] has-[:checked]:border-brand-dark has-[:checked]:bg-tint">
                        <input type="radio" name="tipe_pemohon" value="{{ $tipe }}" class="size-4 accent-brand-dark" @checked(old('tipe_pemohon') === $tipe)>
                        {{ $tipe }}
                    </label>
                @endforeach
            </div>
            @error('tipe_pemohon') <p class="mt-1 text-xs text-lost">{{ $message }}</p> @enderror
        </div>

        <div class="mt-5">
            <p class="text-xs font-semibold">Layanan yang diminati *</p>
            <p class="text-[11px] text-slate-500">Pilih minimal satu. Boleh lebih dari satu layanan.</p>
            <div class="mt-2 grid gap-2 sm:grid-cols-2">
                @foreach ($layanans as $layanan)
                    <label class="flex cursor-pointer items-center gap-3 rounded-lg border bg-white px-4 py-2.5 text-[13px] has-[:checked]:border-brand-dark has-[:checked]:bg-tint">
                        <input type="checkbox" name="layanan[]" value="{{ $layanan->id }}" class="size-4 accent-brand-dark" @checked(in_array($layanan->id, old('layanan', [])))>
                        {{ $layanan->nama }}
                    </label>
                @endforeach
            </div>
            @error('layanan') <p class="mt-1 text-xs text-lost">{{ $message }}</p> @enderror
            @error('layanan.*') <p class="mt-1 text-xs text-lost">{{ $message }}</p> @enderror
        </div>

        <hr class="my-6">

        <p class="text-[13px] text-slate-500">Isi email atau nomor HP, minimal salah satu.</p>

        <div class="mt-3 grid gap-5 sm:grid-cols-2">
            <div>
                <label for="email" class="text-xs font-semibold">Email</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="nama@example.com"
                       class="field mt-1.5 @error('email') border-lost @enderror">
                @error('email') <p class="mt-1 text-xs text-lost">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="no_hp" class="text-xs font-semibold">Nomor HP</label>
                <input id="no_hp" name="no_hp" type="tel" value="{{ old('no_hp') }}" placeholder="Contoh: 08xxxxxxxxxx"
                       class="field mt-1.5 @error('no_hp') border-lost @enderror">
                @error('no_hp') <p class="mt-1 text-xs text-lost">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="mt-5">
            <label for="pesan" class="text-xs font-semibold">Pesan kebutuhan (opsional)</label>
            <textarea id="pesan" name="pesan" rows="4" placeholder="Ceritakan tujuan, ide, atau kebutuhan visual Anda."
                      class="field mt-1.5 @error('pesan') border-lost @enderror">{{ old('pesan') }}</textarea>
            @error('pesan') <p class="mt-1 text-xs text-lost">{{ $message }}</p> @enderror
        </div>

        <p class="mt-6 text-[11px] text-slate-500">Data Anda hanya kami pakai untuk menghubungi Anda terkait permintaan layanan ini.</p>

        <button type="submit" class="btn-primary mt-4 w-full sm:w-auto">Kirim Permintaan Layanan</button>
    </form>
</section>
@endsection