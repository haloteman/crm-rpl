@extends('layouts.app')
@section('title', 'Penawaran '.$penawaran->nomor_penawaran)
@section('heading', 'Penawaran')

@section('content')
<a href="{{ route('penawaran') }}" class="inline-flex items-center gap-1.5 text-xs font-medium text-brand-dark hover:underline">
    <x-icon name="arrow-left" class="size-3.5" /> Kembali ke Daftar Penawaran
</a>

<div class="mt-3 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
    <div>
        <h1 class="page-title">{{ $penawaran->nomor_penawaran }}</h1>
        <div class="mt-2"><x-status-badge :status="$penawaran->status" /></div>
    </div>

    @if (! $penawaran->sudahDiputuskan())
        <div class="flex gap-3">
            <a href="{{ route('penawaran.edit', $penawaran) }}" class="btn-outline">Ubah</a>
            @if ($penawaran->status === 'Draf')
                <form method="POST" action="{{ route('penawaran.kirim', $penawaran) }}">
                    @csrf
                    <button type="submit" class="btn-primary">Tandai Dikirim</button>
                </form>
            @endif
        </div>
    @endif
</div>

@error('penawaran') <p class="mt-3 rounded-lg bg-lost-tint px-3 py-2 text-xs text-lost">{{ $message }}</p> @enderror

<div class="mt-5 grid gap-5 lg:grid-cols-3">
    <section class="card p-5 lg:col-span-2">
        <h2 class="text-base font-semibold">Isi penawaran</h2>
        <dl class="mt-4 grid gap-4 text-[13px] sm:grid-cols-2">
            <div>
                <dt class="text-xs text-slate-500">Jenis Layanan</dt>
                <dd>{{ $penawaran->layanans->pluck('nama')->implode(', ') }}</dd>
            </div>
            <div>
                <dt class="text-xs text-slate-500">Nilai Penawaran</dt>
                <dd>Rp{{ number_format($penawaran->nilai_penawaran, 0, ',', '.') }}</dd>
            </div>
            <div>
                <dt class="text-xs text-slate-500">Harga Akhir</dt>
                <dd>{{ $penawaran->harga_akhir === null ? 'Belum ditetapkan' : 'Rp'.number_format($penawaran->harga_akhir, 0, ',', '.') }}</dd>
            </div>
            <div>
                <dt class="text-xs text-slate-500">Diskon</dt>
                <dd>{{ $penawaran->diskon() === null ? '—' : 'Rp'.number_format($penawaran->diskon(), 0, ',', '.') }}</dd>
            </div>
            <div class="sm:col-span-2">
                <dt class="text-xs text-slate-500">Ruang Lingkup Layanan</dt>
                <dd class="whitespace-pre-line">{{ $penawaran->ruang_lingkup }}</dd>
            </div>
            <div class="sm:col-span-2">
                <dt class="text-xs text-slate-500">Catatan Negosiasi</dt>
                <dd class="whitespace-pre-line">{{ $penawaran->catatan_negosiasi ?: '—' }}</dd>
            </div>
        </dl>
    </section>

    <div class="grid content-start gap-5">
        <section class="card p-5">
            <h2 class="text-base font-semibold">Lead</h2>
            <p class="mt-2 text-[13px] font-medium">
                <a href="{{ route('leads.show', $penawaran->lead) }}" class="hover:underline">{{ $penawaran->lead->nama }}</a>
            </p>
            <div class="mt-2"><x-status-badge :status="$penawaran->lead->status" /></div>
        </section>

        <section class="card p-5 text-[13px]">
            <h2 class="text-base font-semibold">Pencatatan</h2>
            <p class="mt-2">Dibuat oleh {{ $penawaran->pembuat->name }}, {{ $penawaran->created_at->format('d/m/Y H:i') }}</p>
            @if ($penawaran->pengubah)
                <p class="mt-1">Diubah oleh {{ $penawaran->pengubah->name }}, {{ $penawaran->updated_at->format('d/m/Y H:i') }}</p>
            @endif
            @if ($penawaran->pengirim)
                <p class="mt-1">Ditandai Dikirim oleh {{ $penawaran->pengirim->name }}, {{ $penawaran->dikirim_at->format('d/m/Y H:i') }}</p>
            @endif
        </section>
    </div>
</div>
@endsection
