@extends('layouts.app')
@section('title', 'Detail Lead')
@section('heading', 'Leads')

@section('content')
<div x-data="{ modal: '' }" @keydown.escape.window="modal = ''">

<a href="{{ route('leads') }}" class="text-sm text-slate-500 hover:underline">&larr; Kembali ke daftar lead</a>

<div class="mt-3 flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
    <div>
        <h1 class="text-[28px] font-bold leading-tight">{{ $lead->nama }}</h1>
        <p class="mt-1 text-sm text-slate-500">
            Status: <span class="font-medium text-slate-800">{{ $lead->status }}</span>
            @if ($lead->penanda)
                <span class="ml-1 rounded-md bg-warn-tint px-1.5 py-0.5 text-[11px] font-medium text-warn">{{ $lead->penanda }}</span>
            @endif
        </p>
    </div>
    @if ($lead->status !== 'Terkonversi')
        <div class="flex gap-3">
            <a href="{{ route('leads.edit', $lead) }}" class="btn-outline">Ubah</a>
            <button type="button" @click="modal = 'hapus'" class="btn-primary bg-lost hover:bg-red-700">Hapus</button>
        </div>
    @endif
</div>

<div class="mt-5 grid gap-5 lg:grid-cols-2">
    <section class="card p-5">
        <h2 class="text-lg font-semibold">Data Lead</h2>
        <dl class="mt-3 grid grid-cols-[140px_1fr] gap-y-2 text-sm">
            <dt class="text-slate-500">Asal/Instansi</dt><dd>{{ $lead->instansi ?? '—' }}</dd>
            <dt class="text-slate-500">Tipe Pemohon</dt><dd>{{ $lead->tipe_pemohon }}</dd>
            <dt class="text-slate-500">Nomor HP</dt><dd>{{ $lead->no_hp ?? '—' }}</dd>
            <dt class="text-slate-500">Email</dt><dd>{{ $lead->email ?? '—' }}</dd>
            <dt class="text-slate-500">Instagram</dt><dd>{{ $lead->instagram ?? '—' }}</dd>
            <dt class="text-slate-500">Sumber</dt><dd>{{ $lead->sumber }}</dd>
            <dt class="text-slate-500">Layanan</dt><dd>{{ $lead->layanans->pluck('nama')->implode(', ') }}</dd>
            <dt class="text-slate-500">Tanggal Masuk</dt><dd>{{ $lead->created_at->format('d/m/Y H:i') }}</dd>
            <dt class="text-slate-500">Catatan Kebutuhan</dt><dd class="whitespace-pre-line">{{ $lead->catatan_kebutuhan ?? '—' }}</dd>
            @if ($lead->status === 'Tidak Berlanjut')
                <dt class="text-slate-500">Alasan</dt><dd>{{ $lead->alasan_tidak_berlanjut }}</dd>
            @endif
        </dl>
    </section>

    <div class="grid content-start gap-5">
        <section class="card p-5">
            <h2 class="text-lg font-semibold">Ubah Status</h2>
            @if (count($statusDiizinkan) > 0)
                <form method="POST" action="{{ route('leads.status', $lead) }}" class="mt-3 grid gap-3">
                    @csrf
                    <select name="status_baru" class="field @error('status_baru') border-lost @enderror">
                        <option value="">Pilih status baru</option>
                        @foreach ($statusDiizinkan as $status)
                            <option value="{{ $status }}" @selected(old('status_baru') === $status)>{{ $status }}</option>
                        @endforeach
                    </select>
                    @error('status_baru') <p class="text-sm text-lost">{{ $message }}</p> @enderror
                    <input name="alasan" value="{{ old('alasan') }}" placeholder="Alasan (wajib untuk Tidak Berlanjut)" class="field @error('alasan') border-lost @enderror">
                    @error('alasan') <p class="text-sm text-lost">{{ $message }}</p> @enderror
                    <button type="submit" class="btn-primary sm:w-fit">Simpan Status</button>
                </form>
            @else
                <p class="mt-2 text-sm text-slate-500">Tidak ada perubahan status yang bisa dipilih dari status {{ $lead->status }}.</p>
            @endif
        </section>

        <section class="card p-5">
            <h2 class="text-lg font-semibold">Penanggung Jawab</h2>
            <p class="mt-1 text-sm">{{ $lead->penanggungJawab->name ?? 'Belum ditugaskan' }}</p>
            <form method="POST" action="{{ route('leads.penanggung-jawab', $lead) }}" class="mt-3 flex flex-col gap-3 sm:flex-row">
                @csrf
                <select name="penanggung_jawab_id" class="field @error('penanggung_jawab_id') border-lost @enderror">
                    <option value="">Pilih Admin</option>
                    @foreach ($semuaAdmin as $admin)
                        <option value="{{ $admin->id }}">{{ $admin->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn-outline">Tetapkan</button>
            </form>
            @error('penanggung_jawab_id') <p class="mt-1 text-sm text-lost">{{ $message }}</p> @enderror
        </section>
    </div>
</div>

<section class="card mt-5 p-5">
    <h2 class="text-lg font-semibold">Follow-up</h2>

    <ul class="mt-3 divide-y text-sm">
        @forelse ($lead->followUps as $followUp)
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

    <form method="POST" action="{{ route('follow-up.store', $lead) }}" class="mt-3 grid gap-3 border-t pt-4 sm:grid-cols-3">
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

    <form method="POST" action="{{ route('interaksi.store', $lead) }}" class="mt-3 grid gap-3 sm:grid-cols-2">
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
        @forelse ($lead->riwayatInteraksis as $riwayat)
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

@if ($lead->status !== 'Terkonversi')
    {{-- popup konfirmasi hapus lead --}}
    <div x-show="modal === 'hapus'" x-cloak x-transition.opacity
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 p-4" role="dialog" aria-modal="true">
        <div class="flex min-h-full items-center justify-center">
            <div class="card w-full max-w-md p-5 sm:p-6" @click.outside="modal = ''">
                <h2 class="text-xl font-semibold">Hapus lead {{ $lead->nama }}?</h2>
                <p class="mt-1 text-sm text-slate-500">Lead yang dihapus tidak lagi tampil pada daftar dan ringkasan.</p>

                <form method="POST" action="{{ route('leads.destroy', $lead) }}" class="mt-6 flex flex-col-reverse gap-3 border-t pt-5 sm:flex-row sm:justify-end">
                    @csrf
                    <button type="button" @click="modal = ''" class="btn-outline">Batal</button>
                    <button type="submit" class="btn-primary bg-lost hover:bg-red-700">Hapus Lead</button>
                </form>
            </div>
        </div>
    </div>
@endif

</div>
@endsection
