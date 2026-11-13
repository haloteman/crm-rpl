@extends('layouts.app')
@section('title', $penawaran ? 'Ubah Penawaran' : 'Buat Penawaran')
@section('heading', 'Penawaran')

@section('content')
<a href="{{ $penawaran ? route('penawaran.show', $penawaran) : route('penawaran') }}" class="inline-flex items-center gap-1.5 text-xs font-medium text-brand-dark hover:underline">
    <x-icon name="arrow-left" class="size-3.5" /> {{ $penawaran ? 'Kembali ke Detail Penawaran' : 'Kembali ke Daftar Penawaran' }}
</a>

<h1 class="page-title mt-3">{{ $penawaran ? 'Ubah Penawaran '.$penawaran->nomor_penawaran : 'Buat Penawaran' }}</h1>

<form method="POST" action="{{ $penawaran ? route('penawaran.update', $penawaran) : route('penawaran.store') }}" class="card mt-5 grid max-w-3xl gap-5 p-5 sm:p-7">
    @csrf

    <div>
        <label for="lead_id" class="text-xs font-semibold">Lead</label>
        @if ($penawaran)
            <p class="mt-1.5 text-[13px]">{{ $penawaran->lead->nama }} <span class="text-slate-500">(tidak dapat diganti)</span></p>
        @else
            <select id="lead_id" name="lead_id" class="field mt-1.5 @error('lead_id') border-lost @enderror">
                <option value="">Pilih lead</option>
                @foreach ($pilihanLead as $lead)
                    <option value="{{ $lead->id }}" @selected(old('lead_id') == $lead->id)>{{ $lead->nama }} ({{ $lead->status }})</option>
                @endforeach
            </select>
            <p class="mt-1 text-[11px] text-slate-500">Hanya lead berstatus Negosiasi atau Deal yang belum memiliki penawaran aktif.</p>
            @error('lead_id') <p class="mt-1 text-xs text-lost">{{ $message }}</p> @enderror
        @endif
    </div>

    <div>
        <span class="text-xs font-semibold">Jenis Layanan</span>
        <div class="mt-2 grid gap-2 sm:grid-cols-2">
            @foreach ($semuaLayanan as $layanan)
                <label class="flex cursor-pointer items-center gap-3 rounded-lg border bg-white px-4 py-2.5 text-[13px] has-[:checked]:border-brand-dark has-[:checked]:bg-tint">
                    <input type="checkbox" name="layanan[]" value="{{ $layanan->id }}" class="size-4 accent-brand-dark" @checked(in_array($layanan->id, old('layanan', $penawaran ? $penawaran->layanans->pluck('id')->all() : [])))>
                    {{ $layanan->nama }}
                </label>
            @endforeach
        </div>
        @error('layanan') <p class="mt-1 text-xs text-lost">{{ $message }}</p> @enderror
        @error('layanan.*') <p class="mt-1 text-xs text-lost">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="ruang_lingkup" class="text-xs font-semibold">Ruang Lingkup Layanan</label>
        <textarea id="ruang_lingkup" name="ruang_lingkup" rows="4" class="field mt-1.5 @error('ruang_lingkup') border-lost @enderror">{{ old('ruang_lingkup', $penawaran->ruang_lingkup ?? '') }}</textarea>
        @error('ruang_lingkup') <p class="mt-1 text-xs text-lost">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="nilai_penawaran" class="text-xs font-semibold">Nilai Penawaran (Rp)</label>
        <input id="nilai_penawaran" name="nilai_penawaran" type="number" min="1" value="{{ old('nilai_penawaran', $penawaran->nilai_penawaran ?? '') }}" placeholder="Contoh: 1500000"
               class="field mt-1.5 sm:max-w-xs @error('nilai_penawaran') border-lost @enderror">
        @error('nilai_penawaran') <p class="mt-1 text-xs text-lost">{{ $message }}</p> @enderror
    </div>

    <div>
        <label for="catatan_negosiasi" class="text-xs font-semibold">Catatan Negosiasi (opsional)</label>
        <textarea id="catatan_negosiasi" name="catatan_negosiasi" rows="3" class="field mt-1.5 @error('catatan_negosiasi') border-lost @enderror">{{ old('catatan_negosiasi', $penawaran->catatan_negosiasi ?? '') }}</textarea>
        @error('catatan_negosiasi') <p class="mt-1 text-xs text-lost">{{ $message }}</p> @enderror
    </div>

    <div class="flex gap-3">
        <button type="submit" class="btn-primary">{{ $penawaran ? 'Simpan Perubahan' : 'Buat Penawaran' }}</button>
        <a href="{{ $penawaran ? route('penawaran.show', $penawaran) : route('penawaran') }}" class="btn-outline">Batal</a>
    </div>
</form>
@endsection
