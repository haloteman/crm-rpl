@extends('layouts.app')
@section('title', $lead ? 'Ubah Lead' : 'Tambah Lead')
@section('heading', 'Leads')

@section('content')
<a href="{{ $lead ? route('leads.show', $lead) : route('leads') }}" class="inline-flex items-center gap-1.5 text-xs font-medium text-brand-dark hover:underline">
    <x-icon name="arrow-left" class="size-3.5" /> {{ $lead ? 'Kembali ke Detail Lead' : 'Kembali ke Daftar Lead' }}
</a>

<div class="mt-3">
    <h1 class="page-title">{{ $lead ? 'Ubah Lead' : 'Tambah Lead' }}</h1>
    <p class="page-sub">Isi minimal satu kontak: nomor HP, email, atau Instagram.</p>
</div>

<form method="POST" action="{{ $lead ? route('leads.update', $lead) : route('leads.store') }}" class="card mt-5 max-w-3xl p-5 sm:p-7">
    @csrf

    {{-- peringatan data ganda --}}
    @if (session('leadMirip') || session('pelangganMirip'))
        <div class="mb-6 flex items-start gap-3 rounded-xl bg-warn-tint px-4 py-4 text-warn" role="alert">
            <x-icon name="exclamation-triangle" class="mt-0.5 size-5 shrink-0" />
            <div class="min-w-0 text-[13px]">
                <div class="font-semibold">Kemungkinan data ganda</div>
                <p class="mt-0.5">Nomor HP atau email ini sudah dipakai data berikut:</p>
                <ul class="mt-1.5 list-disc space-y-0.5 pl-5">
                    @foreach (session('leadMirip', []) as $id => $nama)
                        <li>Lead: <a href="{{ route('leads.show', $id) }}" target="_blank" class="font-medium underline">{{ $nama }}</a></li>
                    @endforeach
                    @foreach (session('pelangganMirip', []) as $id => $nama)
                        <li>Pelanggan: <a href="{{ route('customer.show', $id) }}" target="_blank" class="font-medium underline">{{ $nama }}</a></li>
                    @endforeach
                </ul>
                <p class="mt-2.5 font-medium">Tetap simpan data ini?</p>
                <div class="mt-3 flex flex-col gap-3 sm:flex-row">
                    <button type="submit" name="tetap_simpan" value="1" class="btn-primary">Tetap Simpan</button>
                    <a href="{{ route('leads') }}" class="btn-outline">Batal</a>
                </div>
            </div>
        </div>
    @endif

    <h2 class="text-base font-semibold">Informasi pemohon</h2>

    <div class="mt-4 grid gap-4 sm:grid-cols-2">
        <div>
            <label for="nama" class="text-xs font-semibold">Nama</label>
            <input id="nama" name="nama" value="{{ old('nama', $lead->nama ?? '') }}" placeholder="Masukkan nama lead"
                   class="field mt-1.5 @error('nama') border-lost @enderror">
            @error('nama') <p class="mt-1 text-xs text-lost">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="instansi" class="text-xs font-semibold">Asal/Instansi (opsional)</label>
            <input id="instansi" name="instansi" value="{{ old('instansi', $lead->instansi ?? '') }}" placeholder="Nama instansi atau komunitas"
                   class="field mt-1.5 @error('instansi') border-lost @enderror">
            @error('instansi') <p class="mt-1 text-xs text-lost">{{ $message }}</p> @enderror
        </div>
    </div>

    <div class="mt-5">
        <span class="text-xs font-semibold">Tipe Pemohon</span>
        <div class="mt-1.5 grid gap-2 sm:grid-cols-2">
            @foreach (\App\Models\Lead::TIPE_PEMOHON as $tipe)
                <label class="flex cursor-pointer items-center gap-3 rounded-lg border bg-white px-4 py-2.5 text-[13px] has-[:checked]:border-brand-dark has-[:checked]:bg-tint">
                    <input type="radio" name="tipe_pemohon" value="{{ $tipe }}" class="size-4 accent-brand-dark" @checked(old('tipe_pemohon', $lead->tipe_pemohon ?? '') === $tipe)>
                    {{ $tipe }}
                </label>
            @endforeach
        </div>
        @error('tipe_pemohon') <p class="mt-1 text-xs text-lost">{{ $message }}</p> @enderror
    </div>

    <hr class="my-6">

    <h2 class="text-base font-semibold">Kontak</h2>

    <div class="mt-4 grid gap-4 sm:grid-cols-3">
        <div>
            <label for="no_hp" class="text-xs font-semibold">Nomor HP/WhatsApp</label>
            <input id="no_hp" name="no_hp" type="tel" value="{{ old('no_hp', $lead->no_hp ?? '') }}" placeholder="08xxxxxxxxxx"
                   class="field mt-1.5 @error('no_hp') border-lost @enderror">
        </div>
        <div>
            <label for="email" class="text-xs font-semibold">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email', $lead->email ?? '') }}" placeholder="nama@example.com"
                   class="field mt-1.5 @error('email') border-lost @enderror">
        </div>
        <div>
            <label for="instagram" class="text-xs font-semibold">Instagram</label>
            <input id="instagram" name="instagram" value="{{ old('instagram', $lead->instagram ?? '') }}" placeholder="@akun"
                   class="field mt-1.5 @error('instagram') border-lost @enderror">
        </div>
    </div>
    @error('no_hp') <p class="mt-1.5 text-xs text-lost">{{ $message }}</p> @enderror
    @error('email') <p class="mt-1.5 text-xs text-lost">{{ $message }}</p> @enderror
    @error('instagram') <p class="mt-1.5 text-xs text-lost">{{ $message }}</p> @enderror

    <div class="mt-5">
        @if ($lead)
            <span class="text-xs font-semibold">Sumber</span>
            <p class="mt-1.5 text-[13px]">{{ $lead->sumber }} <span class="text-slate-500">(tidak dapat diubah)</span></p>
        @else
            <label for="sumber" class="text-xs font-semibold">Sumber</label>
            <select id="sumber" name="sumber" class="field mt-1.5 sm:max-w-xs @error('sumber') border-lost @enderror">
                <option value="">Pilih sumber</option>
                @foreach (\App\Models\Lead::SUMBER_MANUAL as $sumber)
                    <option value="{{ $sumber }}" @selected(old('sumber') === $sumber)>{{ $sumber }}</option>
                @endforeach
            </select>
            @error('sumber') <p class="mt-1 text-xs text-lost">{{ $message }}</p> @enderror
        @endif
    </div>

    <hr class="my-6">

    <h2 class="text-base font-semibold">Kebutuhan</h2>

    <div class="mt-4">
        <span class="text-xs font-semibold">Layanan yang Diminati</span>
        <p class="text-[11px] text-slate-500">Pilih minimal satu. Boleh lebih dari satu layanan.</p>
        <div class="mt-2 grid gap-2 sm:grid-cols-2">
            @foreach ($semuaLayanan as $layanan)
                <label class="flex cursor-pointer items-center gap-3 rounded-lg border bg-white px-4 py-2.5 text-[13px] has-[:checked]:border-brand-dark has-[:checked]:bg-tint">
                    <input type="checkbox" name="layanan[]" value="{{ $layanan->id }}" class="size-4 accent-brand-dark" @checked(in_array($layanan->id, old('layanan', $lead ? $lead->layanans->pluck('id')->all() : [])))>
                    {{ $layanan->nama }}
                </label>
            @endforeach
        </div>
        @error('layanan') <p class="mt-1 text-xs text-lost">{{ $message }}</p> @enderror
        @error('layanan.*') <p class="mt-1 text-xs text-lost">{{ $message }}</p> @enderror
    </div>

    <div class="mt-5">
        <label for="catatan_kebutuhan" class="text-xs font-semibold">Catatan Kebutuhan</label>
        <textarea id="catatan_kebutuhan" name="catatan_kebutuhan" rows="4" placeholder="Ceritakan tujuan, ide, atau kebutuhan visual."
                  class="field mt-1.5 @error('catatan_kebutuhan') border-lost @enderror">{{ old('catatan_kebutuhan', $lead->catatan_kebutuhan ?? '') }}</textarea>
        @error('catatan_kebutuhan') <p class="mt-1 text-xs text-lost">{{ $message }}</p> @enderror
    </div>

    <div class="mt-7 flex flex-col-reverse gap-3 border-t pt-5 sm:flex-row sm:justify-end">
        <a href="{{ $lead ? route('leads.show', $lead) : route('leads') }}" class="btn-outline">Batal</a>
        <button type="submit" class="btn-primary">Simpan</button>
    </div>
</form>
@endsection