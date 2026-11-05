@extends('layouts.app')
@section('title', 'Profil Pelanggan')
@section('heading', 'Customer')

@section('content')
<a href="{{ route('customer') }}" class="text-sm text-slate-500 hover:underline">&larr; Kembali ke daftar pelanggan</a>

<div class="mt-3 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
    <div>
        <h1 class="text-[28px] font-bold leading-tight">{{ $pelanggan->nama }}</h1>
        <p class="mt-1 text-sm text-slate-500">Pelanggan sejak {{ $pelanggan->tanggal_menjadi_pelanggan->format('d/m/Y') }}</p>
    </div>
    <a href="{{ route('customer.edit', $pelanggan) }}" class="btn-outline">Ubah</a>
</div>

<div class="mt-5 grid gap-5 lg:grid-cols-2">
    <section class="card p-5">
        <h2 class="text-lg font-semibold">Profil</h2>
        <dl class="mt-3 grid grid-cols-[140px_1fr] gap-y-2 text-sm">
            <dt class="text-slate-500">Asal/Instansi</dt><dd>{{ $pelanggan->instansi ?? '—' }}</dd>
            <dt class="text-slate-500">Nomor HP</dt><dd>{{ $pelanggan->no_hp ?? '—' }}</dd>
            <dt class="text-slate-500">Email</dt><dd>{{ $pelanggan->email ?? '—' }}</dd>
            <dt class="text-slate-500">Instagram</dt><dd>{{ $pelanggan->instagram ?? '—' }}</dd>
            <dt class="text-slate-500">Sumber Awal</dt><dd>{{ $pelanggan->sumber_awal }}</dd>
            <dt class="text-slate-500">Layanan</dt><dd>{{ $semuaLayanan->implode(', ') ?: '—' }}</dd>
            <dt class="text-slate-500">Catatan</dt><dd class="whitespace-pre-line">{{ $pelanggan->catatan ?? '—' }}</dd>
        </dl>
    </section>

    <section class="card p-5">
        <h2 class="text-lg font-semibold">Lead Asal</h2>
        <ul class="mt-3 divide-y text-sm">
            @forelse ($pelanggan->leads as $lead)
                <li class="py-2">
                    <a href="{{ route('leads.show', $lead) }}" class="font-medium text-brand-dark hover:underline">{{ $lead->nama }}</a>
                    <span class="text-slate-500">· {{ $lead->sumber }} · {{ $lead->status }} · {{ $lead->created_at->format('d/m/Y') }}</span>
                </li>
            @empty
                <li class="py-2 text-slate-500">Tidak ada lead</li>
            @endforelse
        </ul>
    </section>
</div>

<section class="card mt-5 p-5">
    <h2 class="text-lg font-semibold">Follow-up</h2>

    <ul class="mt-3 divide-y text-sm">
        @forelse ($pelanggan->followUps as $followUp)
            <li class="flex flex-col gap-2 py-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <span class="font-medium">{{ $followUp->tanggal->format('d/m/Y') }}</span>
                    <span class="text-slate-500">· {{ $followUp->jenis }}</span>
                    @if ($followUp->jatuhTempo())
                        <span class="ml-1 rounded-md bg-lost-tint px-1.5 py-0.5 text-[11px] font-medium text-lost">Jatuh tempo</span>
                    @endif
                    @if ($followUp->catatan_tujuan)
                        <div class="text-slate-600">{{ $followUp->catatan_tujuan }}</div>
                    @endif
                </div>
                @if ($followUp->selesai)
                    <span class="text-xs text-won">Selesai {{ $followUp->selesai_pada->format('d/m/Y H:i') }}</span>
                @else
                    <form method="POST" action="{{ route('follow-up.selesai', $followUp) }}">
                        @csrf
                        <button type="submit" class="text-xs font-medium text-brand-dark hover:underline">Tandai selesai</button>
                    </form>
                @endif
            </li>
        @empty
            <li class="py-3 text-slate-500">Belum ada follow-up</li>
        @endforelse
    </ul>

    <form method="POST" action="{{ route('customer.follow-up', $pelanggan) }}" class="mt-3 grid gap-3 border-t pt-4 sm:grid-cols-3">
        @csrf
        <input type="date" name="tanggal" value="{{ old('tanggal') }}" min="{{ today()->format('Y-m-d') }}" class="field @error('tanggal') border-lost @enderror">
        <select name="jenis" class="field @error('jenis') border-lost @enderror">
            @foreach (\App\Models\FollowUp::JENIS as $jenis)
                <option value="{{ $jenis }}" @selected(old('jenis') === $jenis)>{{ $jenis }}</option>
            @endforeach
        </select>
        <input name="catatan_tujuan" value="{{ old('catatan_tujuan') }}" placeholder="Catatan tujuan" class="field @error('catatan_tujuan') border-lost @enderror">
        @error('tanggal') <p class="text-sm text-lost sm:col-span-3">{{ $message }}</p> @enderror
        @error('jenis') <p class="text-sm text-lost sm:col-span-3">{{ $message }}</p> @enderror
        @error('catatan_tujuan') <p class="text-sm text-lost sm:col-span-3">{{ $message }}</p> @enderror
        <button type="submit" class="btn-primary sm:w-fit">Jadwalkan Follow-up</button>
    </form>
</section>

<section class="card mt-5 p-5">
    <h2 class="text-lg font-semibold">Riwayat Interaksi</h2>

    <form method="POST" action="{{ route('customer.interaksi', $pelanggan) }}" class="mt-3 grid gap-3 sm:grid-cols-2">
        @csrf
        <input type="datetime-local" name="waktu" value="{{ old('waktu', now()->format('Y-m-d\TH:i')) }}" class="field @error('waktu') border-lost @enderror">
        <select name="kanal" class="field @error('kanal') border-lost @enderror">
            <option value="">Pilih kanal</option>
            @foreach (\App\Models\RiwayatInteraksi::KANAL as $kanal)
                <option value="{{ $kanal }}" @selected(old('kanal') === $kanal)>{{ $kanal }}</option>
            @endforeach
        </select>
        <textarea name="ringkasan" rows="3" placeholder="Ringkasan isi interaksi" class="field sm:col-span-2 @error('ringkasan') border-lost @enderror">{{ old('ringkasan') }}</textarea>
        @error('waktu') <p class="text-sm text-lost sm:col-span-2">{{ $message }}</p> @enderror
        @error('kanal') <p class="text-sm text-lost sm:col-span-2">{{ $message }}</p> @enderror
        @error('ringkasan') <p class="text-sm text-lost sm:col-span-2">{{ $message }}</p> @enderror
        <button type="submit" class="btn-primary sm:w-fit">Tambah Catatan</button>
    </form>

    <ul class="mt-4 divide-y border-t text-sm">
        @forelse ($pelanggan->riwayatInteraksis as $riwayat)
            <li class="py-3">
                <div class="text-xs text-slate-500">
                    {{ $riwayat->waktu->format('d/m/Y H:i') }} · {{ $riwayat->jenis }}
                    @if ($riwayat->kanal) · {{ $riwayat->kanal }} @endif
                    · oleh {{ $riwayat->pencatat->name }}
                </div>
                <div class="mt-1 whitespace-pre-line">{{ $riwayat->ringkasan }}</div>
            </li>
        @empty
            <li class="py-3 text-slate-500">Belum ada riwayat interaksi</li>
        @endforelse
    </ul>
</section>
@endsection
