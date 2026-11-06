@extends('layouts.app')
@section('title', 'Profil Pelanggan')
@section('heading', 'Customer')

@php
    $inisial = \Illuminate\Support\Str::of($pelanggan->nama)->explode(' ')->filter()->take(2)
        ->map(fn ($kata) => mb_strtoupper(mb_substr($kata, 0, 1)))->implode('');
@endphp

@section('content')
<a href="{{ route('customer') }}" class="inline-flex items-center gap-1.5 text-xs font-medium text-brand-dark hover:underline">
    <x-icon name="arrow-left" class="size-3.5" /> Kembali ke daftar pelanggan
</a>

<div class="mt-3 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
    <div>
        <h1 class="page-title">Profil Pelanggan</h1>
        <p class="page-sub">Pelanggan sejak {{ $pelanggan->tanggal_menjadi_pelanggan->format('d/m/Y') }}</p>
    </div>
    <a href="{{ route('customer.edit', $pelanggan) }}" class="btn-outline">
        <x-icon name="pencil" class="size-4" /> Ubah
    </a>
</div>

<div class="mt-5 grid items-start gap-5 lg:grid-cols-2">
    <section class="card p-5 sm:p-6">
        <div class="flex items-center gap-4">
            <div class="flex size-11 shrink-0 items-center justify-center rounded-lg bg-tint text-sm font-bold text-brand-dark">{{ $inisial }}</div>
            <div class="min-w-0">
                <h2 class="truncate text-lg font-semibold">{{ $pelanggan->nama }}</h2>
                <p class="text-xs text-slate-500">{{ $pelanggan->instansi ?? '—' }}</p>
            </div>
        </div>
        <dl class="mt-5 grid grid-cols-[120px_1fr] gap-y-3 border-t pt-5 text-[13px] sm:grid-cols-[140px_1fr]">
            <dt class="text-slate-500">Nomor HP</dt><dd class="break-words font-medium">{{ $pelanggan->no_hp ?? '—' }}</dd>
            <dt class="text-slate-500">Email</dt><dd class="break-words font-medium">{{ $pelanggan->email ?? '—' }}</dd>
            <dt class="text-slate-500">Instagram</dt><dd class="break-words font-medium">{{ $pelanggan->instagram ?? '—' }}</dd>
            <dt class="text-slate-500">Sumber Awal</dt><dd class="font-medium">{{ $pelanggan->sumber_awal }}</dd>
            <dt class="text-slate-500">Layanan</dt><dd class="font-medium">{{ $semuaLayanan->implode(', ') ?: '—' }}</dd>
            <dt class="text-slate-500">Catatan</dt><dd class="whitespace-pre-line font-medium">{{ $pelanggan->catatan ?? '—' }}</dd>
        </dl>
    </section>

    <section class="card p-5 sm:p-6">
        <h2 class="text-base font-semibold">Lead Asal</h2>
        <ul class="mt-3 divide-y text-[13px]">
            @forelse ($pelanggan->leads as $lead)
                <li class="flex flex-col gap-1.5 py-3 sm:flex-row sm:items-center sm:justify-between">
                    <div class="min-w-0">
                        <a href="{{ route('leads.show', $lead) }}" class="font-semibold text-brand-dark hover:underline">{{ $lead->nama }}</a>
                        <div class="text-xs text-slate-500">{{ $lead->sumber }} · {{ $lead->created_at->format('d/m/Y') }}</div>
                    </div>
                    <x-status-badge :status="$lead->status" />
                </li>
            @empty
                <li class="py-3 text-slate-500">Tidak ada lead</li>
            @endforelse
        </ul>
    </section>
</div>

<section class="card mt-5 p-5 sm:p-6">
    <h2 class="text-base font-semibold">Follow-up</h2>

    <ul class="mt-3 divide-y text-[13px]">
        @forelse ($pelanggan->followUps as $followUp)
            <li class="flex flex-col gap-2 py-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <span class="font-semibold">{{ $followUp->tanggal->format('d/m/Y') }}</span>
                    <span class="text-slate-500">· {{ $followUp->jenis }}</span>
                    @if ($followUp->jatuhTempo())
                        <span class="badge badge-red ml-1">Jatuh tempo</span>
                    @endif
                    @if ($followUp->catatan_tujuan)
                        <div class="text-xs text-slate-500">{{ $followUp->catatan_tujuan }}</div>
                    @endif
                </div>
                @if ($followUp->selesai)
                    <span class="text-xs text-won">Selesai {{ $followUp->selesai_pada->format('d/m/Y H:i') }}</span>
                @else
                    <form method="POST" action="{{ route('follow-up.selesai', $followUp) }}">
                        @csrf
                        <button type="submit" class="text-xs font-semibold text-brand-dark hover:underline">Tandai selesai</button>
                    </form>
                @endif
            </li>
        @empty
            <li class="py-3 text-slate-500">Belum ada follow-up</li>
        @endforelse
    </ul>

    <form method="POST" action="{{ route('customer.follow-up', $pelanggan) }}" class="mt-3 grid gap-3 rounded-xl bg-thead p-4 sm:grid-cols-3">
        @csrf
        <input type="date" name="tanggal" value="{{ old('tanggal') }}" min="{{ today()->format('Y-m-d') }}" class="field @error('tanggal') border-lost @enderror">
        <select name="jenis" class="field @error('jenis') border-lost @enderror">
            @foreach (\App\Models\FollowUp::JENIS as $jenis)
                <option value="{{ $jenis }}" @selected(old('jenis') === $jenis)>{{ $jenis }}</option>
            @endforeach
        </select>
        <input name="catatan_tujuan" value="{{ old('catatan_tujuan') }}" placeholder="Catatan tujuan" class="field @error('catatan_tujuan') border-lost @enderror">
        @error('tanggal') <p class="text-xs text-lost sm:col-span-3">{{ $message }}</p> @enderror
        @error('jenis') <p class="text-xs text-lost sm:col-span-3">{{ $message }}</p> @enderror
        @error('catatan_tujuan') <p class="text-xs text-lost sm:col-span-3">{{ $message }}</p> @enderror
        <button type="submit" class="btn-primary sm:w-fit">Jadwalkan Follow-up</button>
    </form>
</section>

<section class="card mt-5 p-5 sm:p-6">
    <h2 class="text-base font-semibold">Riwayat Interaksi</h2>

    <form method="POST" action="{{ route('customer.interaksi', $pelanggan) }}" class="mt-3 grid gap-3 rounded-xl bg-thead p-4 sm:grid-cols-2">
        @csrf
        <input type="datetime-local" name="waktu" value="{{ old('waktu', now()->format('Y-m-d\TH:i')) }}" class="field @error('waktu') border-lost @enderror">
        <select name="kanal" class="field @error('kanal') border-lost @enderror">
            <option value="">Pilih kanal</option>
            @foreach (\App\Models\RiwayatInteraksi::KANAL as $kanal)
                <option value="{{ $kanal }}" @selected(old('kanal') === $kanal)>{{ $kanal }}</option>
            @endforeach
        </select>
        <textarea name="ringkasan" rows="3" placeholder="Ringkasan isi interaksi" class="field sm:col-span-2 @error('ringkasan') border-lost @enderror">{{ old('ringkasan') }}</textarea>
        @error('waktu') <p class="text-xs text-lost sm:col-span-2">{{ $message }}</p> @enderror
        @error('kanal') <p class="text-xs text-lost sm:col-span-2">{{ $message }}</p> @enderror
        @error('ringkasan') <p class="text-xs text-lost sm:col-span-2">{{ $message }}</p> @enderror
        <button type="submit" class="btn-primary sm:w-fit">Tambah Catatan</button>
    </form>

    <ol class="mt-5 space-y-5 border-l pl-6">
        @forelse ($pelanggan->riwayatInteraksis as $riwayat)
            <li class="relative text-[13px]">
                <span class="absolute -left-[37px] top-0 flex size-6 items-center justify-center rounded-full bg-tint text-brand-dark"><x-icon name="clock" class="size-3.5" /></span>
                <div class="text-[11px] text-slate-500">
                    {{ $riwayat->waktu->format('d/m/Y H:i') }} • {{ $riwayat->jenis }}@if ($riwayat->kanal) • {{ $riwayat->kanal }}@endif
                </div>
                <div class="mt-1 whitespace-pre-line font-medium">{{ $riwayat->ringkasan }}</div>
                <div class="mt-0.5 text-[11px] text-slate-500">oleh {{ $riwayat->pencatat->name }}</div>
            </li>
        @empty
            <li class="text-[13px] text-slate-500">Belum ada riwayat interaksi</li>
        @endforelse
    </ol>
</section>
@endsection