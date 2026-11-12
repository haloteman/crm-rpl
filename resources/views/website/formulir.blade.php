@extends('layouts.website')
@section('title', 'Formulir Permintaan Layanan')

@php
    $alur = [
        ['Form Intake', 'Data yang Anda isikan tercatat di sistem tim kreatif.'],
        ['Discovery & Moodboard', 'Tim meninjau referensi dan menghubungi Anda.'],
        ['Produksi Eksklusif', 'Eksekusi desain, apparel, video, atau cetak sesuai brief.'],
        ['Handover Final', 'Hasil akhir diserahkan dalam format siap pakai.'],
    ];
@endphp

@section('content')
<section class="overflow-hidden bg-forest bg-[radial-gradient(ellipse_60%_80%_at_90%_0%,rgb(15_28_63/.95),transparent_65%),radial-gradient(ellipse_40%_50%_at_0%_100%,rgb(198_146_66/.08),transparent_70%)] text-white">
    <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 md:py-20 lg:px-8">
        <span class="inline-flex items-center gap-2 rounded-full border border-lime/25 bg-lime/10 px-3 py-1 text-[11px] font-bold uppercase tracking-[0.08em] text-[#e8c07a]"><span class="size-1.5 rounded-full bg-lime"></span> Mulai berkolaborasi</span>
        <h1 class="mt-6 max-w-3xl font-display text-[34px] font-semibold leading-[1.15] tracking-[-0.02em] sm:text-5xl lg:text-[56px] lg:leading-[1.2]">Mulai Kolaborasi Kreatif Bersama <span class="italic text-lime">TipeCreative</span></h1>
        <p class="mt-5 max-w-xl text-[15px] leading-7 text-white/70">Pilih layanan yang Anda minati dan bagikan kebutuhan kreatif Anda. Tidak perlu membuat akun.</p>
    </div>
</section>

<section class="bg-paper">
    <div class="mx-auto grid max-w-7xl items-start gap-6 px-4 py-12 sm:px-6 md:py-16 lg:grid-cols-[1fr_340px] lg:px-8">

        <div>
            @error('formulir')
                <div class="mb-5 rounded-2xl bg-lost-tint px-5 py-4 text-sm font-medium text-lost" role="alert">{{ $message }}</div>
            @enderror

            <form method="POST" action="{{ route('website.formulir') }}" novalidate class="rounded-2xl border border-forest/5 bg-white p-6 shadow-sm sm:p-9">
                @csrf

                {{-- kolom jebakan bot, jangan dihapus --}}
                <input type="text" name="website" tabindex="-1" autocomplete="off" class="hidden">

                <div class="flex flex-wrap items-start justify-between gap-2">
                    <div>
                        <div class="text-[10px] font-extrabold uppercase tracking-[0.08em] text-olive">Formulir permintaan layanan</div>
                        <h2 class="mt-1 text-2xl font-extrabold tracking-tight">Ceritakan kebutuhan Anda</h2>
                    </div>
                    <span class="text-[11px] text-slate-500"><span class="text-lost">*</span> Tanda bintang wajib diisi</span>
                </div>

                <div class="mt-7 grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="nama" class="text-xs font-bold">1. Nama Lengkap <span class="text-lost">*</span></label>
                        <input id="nama" name="nama" value="{{ old('nama') }}" placeholder="Masukkan nama Anda"
                               class="mt-2 h-[52px] w-full rounded-lg border border-forest/10 bg-mist px-4 text-sm text-forest outline-none placeholder:text-slate-400 focus:border-lime focus:ring-4 focus:ring-lime/15 @error('nama') !border-lost @enderror">
                        @error('nama') <p class="mt-1.5 text-xs text-lost">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="instansi" class="text-xs font-bold">2. Asal/Instansi <span class="font-normal text-slate-400">(opsional)</span></label>
                        <input id="instansi" name="instansi" value="{{ old('instansi') }}" placeholder="Nama instansi atau komunitas"
                               class="mt-2 h-[52px] w-full rounded-lg border border-forest/10 bg-mist px-4 text-sm text-forest outline-none placeholder:text-slate-400 focus:border-lime focus:ring-4 focus:ring-lime/15 @error('instansi') !border-lost @enderror">
                        @error('instansi') <p class="mt-1.5 text-xs text-lost">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="mt-6">
                    <p class="text-xs font-bold">3. Status Pemohon <span class="text-lost">*</span></p>
                    <div class="mt-2 grid gap-3 sm:grid-cols-2">
                        @foreach (\App\Models\Lead::TIPE_PEMOHON as $tipe)
                            <label class="flex cursor-pointer items-center justify-between gap-3 rounded-2xl border border-forest/10 bg-[#f2f4f7] px-5 py-4 text-sm font-bold transition has-[:checked]:border-moss has-[:checked]:bg-[#f7e9cf]">
                                {{ $tipe }}
                                <input type="radio" name="tipe_pemohon" value="{{ $tipe }}" class="size-5 accent-moss" @checked(old('tipe_pemohon') === $tipe)>
                            </label>
                        @endforeach
                    </div>
                    @error('tipe_pemohon') <p class="mt-1.5 text-xs text-lost">{{ $message }}</p> @enderror
                </div>

                <div class="mt-6">
                    <p class="text-xs font-bold">4. Layanan yang Diminati <span class="text-lost">*</span></p>
                    <p class="text-[11px] text-slate-500">Pilih minimal satu. Boleh lebih dari satu layanan.</p>
                    <div class="mt-3 grid grid-cols-2 gap-3 md:grid-cols-4">
                        @foreach ($layanans as $layanan)
                            <label class="flex cursor-pointer items-end justify-between gap-2 rounded-2xl border border-forest/10 bg-[#f2f4f7] px-4 pb-3.5 pt-6 text-[13px] font-bold transition has-[:checked]:border-moss has-[:checked]:bg-lime">
                                {{ $layanan->nama }}
                                <input type="checkbox" name="layanan[]" value="{{ $layanan->id }}" class="size-4 shrink-0 accent-moss" @checked(in_array($layanan->id, old('layanan', [])))>
                            </label>
                        @endforeach
                    </div>
                    @error('layanan') <p class="mt-1.5 text-xs text-lost">{{ $message }}</p> @enderror
                    @error('layanan.*') <p class="mt-1.5 text-xs text-lost">{{ $message }}</p> @enderror
                </div>

                <div class="mt-7 rounded-2xl bg-mist px-5 py-4 text-xs text-slate-600">
                    Isi <strong>email atau nomor HP</strong>, minimal salah satu, agar tim kami bisa menghubungi Anda.
                </div>

                <div class="mt-4 grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="email" class="text-xs font-bold">5. Alamat Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="nama@example.com"
                               class="mt-2 h-[52px] w-full rounded-lg border border-forest/10 bg-mist px-4 text-sm text-forest outline-none placeholder:text-slate-400 focus:border-lime focus:ring-4 focus:ring-lime/15 @error('email') !border-lost @enderror">
                        @error('email') <p class="mt-1.5 text-xs text-lost">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="no_hp" class="text-xs font-bold">6. Nomor HP / WhatsApp</label>
                        <input id="no_hp" name="no_hp" type="tel" value="{{ old('no_hp') }}" placeholder="Contoh: 08xxxxxxxxxx"
                               class="mt-2 h-[52px] w-full rounded-lg border border-forest/10 bg-mist px-4 text-sm text-forest outline-none placeholder:text-slate-400 focus:border-lime focus:ring-4 focus:ring-lime/15 @error('no_hp') !border-lost @enderror">
                        @error('no_hp') <p class="mt-1.5 text-xs text-lost">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="mt-5">
                    <label for="pesan" class="text-xs font-bold">7. Pesan Kebutuhan <span class="font-normal text-slate-400">(opsional)</span></label>
                    <textarea id="pesan" name="pesan" rows="4" placeholder="Ceritakan tujuan, ide, atau kebutuhan visual Anda."
                              class="mt-2 h-auto w-full rounded-lg border border-forest/10 bg-mist px-4 py-3.5 text-sm text-forest outline-none placeholder:text-slate-400 focus:border-lime focus:ring-4 focus:ring-lime/15 @error('pesan') !border-lost @enderror">{{ old('pesan') }}</textarea>
                    @error('pesan') <p class="mt-1.5 text-xs text-lost">{{ $message }}</p> @enderror
                </div>

                <div class="mt-7 flex flex-col gap-4 border-t border-forest/5 pt-6 sm:flex-row sm:items-center sm:justify-between">
                    <p class="text-[11px] text-slate-500 sm:max-w-xs">Data Anda hanya kami pakai untuk menghubungi Anda terkait permintaan layanan ini.</p>
                    <button type="submit" class="inline-flex items-center justify-center gap-2 rounded-lg bg-lime px-6 py-3 text-sm font-bold text-forest transition hover:-translate-y-px hover:bg-[#d4a359] hover:shadow-[0_6px_20px_rgb(198_146_66/.3)]">Kirim Permintaan Layanan <x-icon name="arrow-right" class="size-4" /></button>
                </div>
            </form>
        </div>

        {{-- samping --}}
        <aside class="grid gap-5">
            <div class="rounded-2xl border border-forest/5 bg-white p-6 shadow-[0_4px_6px_-1px_rgb(11_20_38/.04),0_16px_32px_-4px_rgb(11_20_38/.07)]">
                <div class="flex size-11 items-center justify-center rounded-full bg-[#f7e9cf] text-moss"><x-icon name="shield-check" class="size-5" /></div>
                <h3 class="mt-4 text-base font-extrabold">Tanpa perlu login</h3>
                <p class="mt-1.5 text-[13px] leading-6 text-slate-500">Isi formulir ini langsung, tanpa membuat akun. Permintaan Anda diterima oleh tim kami.</p>
            </div>
            <div class="rounded-3xl bg-forest p-6 text-white">
                <div class="text-[10px] font-extrabold uppercase tracking-[0.08em] text-lime">Butuh jawaban cepat?</div>
                <p class="mt-2 text-[13px] leading-6 text-white/70">Lihat halaman kontak untuk jalur komunikasi lainnya.</p>
                <a href="{{ route('website.kontak') }}" class="mt-4 inline-flex w-full items-center justify-center gap-2 rounded-lg border border-white/25 px-6 py-3 text-sm font-bold text-white transition hover:bg-white/10">Halaman Kontak</a>
            </div>
        </aside>
    </div>
</section>

<section class="bg-mist">
    <div class="mx-auto max-w-7xl px-4 py-14 sm:px-6 md:py-20 lg:px-8">
        <h2 class="text-center font-display text-[28px] font-semibold leading-[1.2] tracking-[-0.015em] sm:text-[40px]">Bagaimana Kami Memproses Ide Anda</h2>
        <ol class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ($alur as $i => [$judul, $isi])
                <li class="rounded-2xl border border-forest/5 bg-white p-6 shadow-[0_4px_6px_-1px_rgb(11_20_38/.04),0_16px_32px_-4px_rgb(11_20_38/.07)]">
                    <span class="flex size-9 items-center justify-center rounded-full bg-mist text-xs font-extrabold">0{{ $i + 1 }}</span>
                    <div class="mt-4 text-sm font-extrabold">{{ $judul }}</div>
                    <p class="mt-1.5 text-[13px] leading-6 text-slate-500">{{ $isi }}</p>
                </li>
            @endforeach
        </ol>
    </div>
</section>
@endsection