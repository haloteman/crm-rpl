@extends('layouts.app')
@section('title', $lead ? 'Ubah Lead' : 'Tambah Lead')
@section('heading', 'Leads')

@section('content')
<div>
    <h1 class="text-[28px] font-bold leading-tight">{{ $lead ? 'Ubah Lead' : 'Tambah Lead' }}</h1>
    <p class="mt-1 text-sm text-slate-500">Isi minimal satu kontak: nomor HP, email, atau Instagram.</p>
</div>

<form method="POST" action="{{ $lead ? route('leads.update', $lead) : route('leads.store') }}" class="card mt-5 grid max-w-2xl gap-5 p-5 sm:p-6">
    @csrf

    @if (session('leadMirip') || session('pelangganMirip'))
        <div class="rounded-lg bg-warn-tint px-4 py-3 text-sm text-warn">
            <div class="font-semibold">Kemungkinan data ganda</div>
            <p>Nomor HP atau email ini sudah dipakai data berikut:</p>
            <ul class="mt-1 list-disc pl-5">
                @foreach (session('leadMirip', []) as $id => $nama)
                    <li>Lead: <a href="{{ route('leads.show', $id) }}" target="_blank" class="underline">{{ $nama }}</a></li>
                @endforeach
                @foreach (session('pelangganMirip', []) as $id => $nama)
                    <li>Pelanggan: <a href="{{ route('customer.show', $id) }}" target="_blank" class="underline">{{ $nama }}</a></li>
                @endforeach
            </ul>
            <p class="mt-2">Tetap simpan data ini?</p>
            <div class="mt-3 flex gap-3">
                <button type="submit" name="tetap_simpan" value="1" class="btn-primary">Tetap Simpan</button>
                <a href="{{ route('leads') }}" class="btn-outline">Batal</a>
            </div>
        </div>
    @endif

    <div>
        <label for="nama" class="text-sm font-medium">Nama</label>
        <input id="nama" name="nama" value="{{ old('nama', $lead->nama ?? '') }}" class="field mt-1.5 @error('nama') border-lost @enderror">
        @error('nama') <p class="mt-1 text-sm text-lost">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="instansi" class="text-sm font-medium">Asal/Instansi (opsional)</label>
        <input id="instansi" name="instansi" value="{{ old('instansi', $lead->instansi ?? '') }}" class="field mt-1.5 @error('instansi') border-lost @enderror">
        @error('instansi') <p class="mt-1 text-sm text-lost">{{ $message }}</p> @enderror
    </div>

    <div>
        <span class="text-sm font-medium">Tipe Pemohon</span>
        <div class="mt-1.5 flex flex-wrap gap-4 text-sm">
            @foreach (\App\Models\Lead::TIPE_PEMOHON as $tipe)
                <label class="flex items-center gap-2">
                    <input type="radio" name="tipe_pemohon" value="{{ $tipe }}" @checked(old('tipe_pemohon', $lead->tipe_pemohon ?? '') === $tipe)>
                    {{ $tipe }}
                </label>
            @endforeach
        </div>
        @error('tipe_pemohon') <p class="mt-1 text-sm text-lost">{{ $message }}</p> @enderror
    </div>

    <div class="grid gap-4 sm:grid-cols-3">
        <div>
            <label for="no_hp" class="text-sm font-medium">Nomor HP/WhatsApp</label>
            <input id="no_hp" name="no_hp" type="tel" value="{{ old('no_hp', $lead->no_hp ?? '') }}" placeholder="08xxxxxxxxxx" class="field mt-1.5 @error('no_hp') border-lost @enderror">
        </div>
        <div>
            <label for="email" class="text-sm font-medium">Email</label>
            <input id="email" name="email" type="email" value="{{ old('email', $lead->email ?? '') }}" class="field mt-1.5 @error('email') border-lost @enderror">
        </div>
        <div>
            <label for="instagram" class="text-sm font-medium">Instagram</label>
            <input id="instagram" name="instagram" value="{{ old('instagram', $lead->instagram ?? '') }}" placeholder="@akun" class="field mt-1.5 @error('instagram') border-lost @enderror">
        </div>
        @error('no_hp') <p class="text-sm text-lost sm:col-span-3">{{ $message }}</p> @enderror
        @error('email') <p class="text-sm text-lost sm:col-span-3">{{ $message }}</p> @enderror
        @error('instagram') <p class="text-sm text-lost sm:col-span-3">{{ $message }}</p> @enderror
    </div>

    <div>
        @if ($lead)
            <span class="text-sm font-medium">Sumber</span>
            <p class="mt-1.5 text-sm">{{ $lead->sumber }} <span class="text-slate-500">(tidak dapat diubah)</span></p>
        @else
            <label for="sumber" class="text-sm font-medium">Sumber</label>
            <select id="sumber" name="sumber" class="field mt-1.5 @error('sumber') border-lost @enderror">
                <option value="">Pilih sumber</option>
                @foreach (\App\Models\Lead::SUMBER_MANUAL as $sumber)
                    <option value="{{ $sumber }}" @selected(old('sumber') === $sumber)>{{ $sumber }}</option>
                @endforeach
            </select>
            @error('sumber') <p class="mt-1 text-sm text-lost">{{ $message }}</p> @enderror
        @endif
    </div>

    <div>
        <span class="text-sm font-medium">Layanan yang Diminati</span>
        <div class="mt-1.5 grid gap-2 text-sm sm:grid-cols-2">
            @foreach ($semuaLayanan as $layanan)
                <label class="flex items-center gap-2">
                    <input type="checkbox" name="layanan[]" value="{{ $layanan->id }}" @checked(in_array($layanan->id, old('layanan', $lead ? $lead->layanans->pluck('id')->all() : [])))>
                    {{ $layanan->nama }}
                </label>
            @endforeach
        </div>
        @error('layanan') <p class="mt-1 text-sm text-lost">{{ $message }}</p> @enderror
        @error('layanan.*') <p class="mt-1 text-sm text-lost">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="catatan_kebutuhan" class="text-sm font-medium">Catatan Kebutuhan</label>
        <textarea id="catatan_kebutuhan" name="catatan_kebutuhan" rows="4" class="field mt-1.5 @error('catatan_kebutuhan') border-lost @enderror">{{ old('catatan_kebutuhan', $lead->catatan_kebutuhan ?? '') }}</textarea>
        @error('catatan_kebutuhan') <p class="mt-1 text-sm text-lost">{{ $message }}</p> @enderror
    </div>

    <div class="flex flex-col-reverse gap-3 border-t pt-5 sm:flex-row sm:justify-end">
        <a href="{{ $lead ? route('leads.show', $lead) : route('leads') }}" class="btn-outline">Batal</a>
        <button type="submit" class="btn-primary">Simpan</button>
    </div>
</form>
@endsection
