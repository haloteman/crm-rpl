@extends('layouts.app')
@section('title', 'Detail Lead')
@section('heading', 'Leads')

@php
    // popup yang langsung terbuka kalau ada pesan error dari form di dalamnya
    $modalAwal = '';

    if ($errors->has('tanggal_konsultasi') || $errors->has('waktu_konsultasi') || $errors->has('tempat') || $errors->has('peserta') || $errors->has('catatan')) {
        $modalAwal = 'jadwal';
    } elseif (old('konsultasi_id') && ($errors->has('status_konsultasi') || $errors->has('hasil'))) {
        $modalAwal = 'hasil-'.old('konsultasi_id');
    } elseif ($errors->has('catatan_kesepakatan') || $errors->has('deal')) {
        $modalAwal = 'deal';
    } elseif ($errors->has('konversi')) {
        $modalAwal = 'konversi';
    }

    $inisial = \Illuminate\Support\Str::of($lead->nama)->explode(' ')->filter()->take(2)
        ->map(fn ($kata) => mb_strtoupper(mb_substr($kata, 0, 1)))->implode('');

    $langkah = ['Baru', 'Negosiasi', 'Deal', 'Terkonversi'];
    $posisi = array_search($lead->status, $langkah);
@endphp

@section('content')
<div x-data="{ modal: '{{ $modalAwal }}' }" @keydown.escape.window="modal = ''">

<a href="{{ route('leads') }}" class="inline-flex items-center gap-1.5 text-xs font-medium text-brand-dark hover:underline">
    <x-icon name="arrow-left" class="size-3.5" /> Kembali ke daftar lead
</a>

<div class="mt-3 flex flex-col gap-4 lg:flex-row lg:items-start lg:justify-between">
    <div>
        <h1 class="page-title">Detail Lead</h1>
        <p class="page-sub">Informasi lead dan tindak lanjut calon pelanggan.</p>
    </div>

    <div class="flex flex-wrap gap-3">
        @if (auth()->user()->hasRole('Owner') && $lead->status === 'Negosiasi')
            <button type="button" @click="modal = 'deal'" class="btn-primary">Tetapkan Deal</button>
        @endif
        @if ($lead->status === 'Deal')
            <button type="button" @click="modal = 'konversi'" class="btn-primary">Konversi ke Pelanggan</button>
        @endif
        @if ($lead->status !== 'Terkonversi')
            <a href="{{ route('leads.edit', $lead) }}" class="btn-outline">
                <x-icon name="pencil" class="size-4" /> Ubah
            </a>
            <button type="button" @click="modal = 'hapus'" class="btn-outline border-lost text-lost hover:bg-lost-tint">
                <x-icon name="trash" class="size-4" /> Hapus
            </button>
        @endif
    </div>
</div>

{{-- ringkasan lead --}}
<section class="card mt-5 p-5 sm:p-6">
    <div class="flex items-start gap-4">
        <div class="flex size-11 shrink-0 items-center justify-center rounded-lg bg-tint text-sm font-bold text-brand-dark">{{ $inisial }}</div>
        <div class="min-w-0 flex-1">
            <h2 class="truncate text-lg font-semibold">{{ $lead->nama }}</h2>
            <p class="text-xs text-slate-500">
                {{ $lead->tipe_pemohon }}@if ($lead->instansi) • {{ $lead->instansi }}@endif
            </p>
        </div>
        <div class="flex shrink-0 flex-col items-end gap-1.5">
            <x-status-badge :status="$lead->status" />
            @if ($lead->penanda)
                <span class="badge badge-amber">{{ $lead->penanda }}</span>
            @endif
        </div>
    </div>

    <dl class="mt-5 grid gap-x-6 gap-y-4 border-t pt-5 sm:grid-cols-2 lg:grid-cols-4">
        <div><dt class="text-[11px] text-slate-500">Nomor HP</dt><dd class="mt-0.5 break-words text-[13px] font-medium">{{ $lead->no_hp ?? '—' }}</dd></div>
        <div><dt class="text-[11px] text-slate-500">Email</dt><dd class="mt-0.5 break-words text-[13px] font-medium">{{ $lead->email ?? '—' }}</dd></div>
        <div><dt class="text-[11px] text-slate-500">Instagram</dt><dd class="mt-0.5 break-words text-[13px] font-medium">{{ $lead->instagram ?? '—' }}</dd></div>
        <div><dt class="text-[11px] text-slate-500">Sumber lead</dt><dd class="mt-0.5 text-[13px] font-medium">{{ $lead->sumber }} • {{ $lead->created_at->format('d/m/Y H:i') }}</dd></div>
    </dl>

    @if ($lead->pelanggan)
        <p class="mt-4 text-xs text-slate-500">
            Pelanggan: <a href="{{ route('customer.show', $lead->pelanggan) }}" class="font-medium text-brand-dark hover:underline">{{ $lead->pelanggan->nama }}</a>
        </p>
    @endif
</section>

{{-- alur status --}}
<div class="card mt-4 flex items-center gap-2 overflow-x-auto px-5 py-3.5 text-[13px]">
    @foreach ($langkah as $i => $nama)
        @php
            $selesai = $posisi !== false && $i < $posisi;
            $aktif = $posisi === $i;
        @endphp
        <div class="flex shrink-0 items-center gap-2 {{ $aktif ? 'font-semibold text-brand-dark' : ($selesai ? 'text-brand-dark' : 'text-slate-500') }}">
            <span class="flex size-6 items-center justify-center rounded-full text-[11px] {{ $aktif || $selesai ? 'bg-tint' : 'bg-thead' }}">
                @if ($selesai) <x-icon name="check" class="size-3.5" /> @else {{ $i + 1 }} @endif
            </span>
            {{ $nama }}
        </div>
        @if (! $loop->last)
            <x-icon name="chevron-right" class="size-4 shrink-0 text-slate-400" />
        @endif
    @endforeach
    <span class="ml-auto shrink-0 pl-4 text-[11px] text-slate-500">Terkonversi dikelola sistem</span>
</div>

<div class="mt-5 grid items-start gap-5 xl:grid-cols-[1fr_340px]">
    {{-- kolom kiri --}}
    <div class="grid gap-5">
        <section class="card p-5 sm:p-6">
            <h2 class="text-base font-semibold">Kebutuhan calon pelanggan</h2>
            <p class="mt-3 whitespace-pre-line text-[13px]">{{ $lead->catatan_kebutuhan ?? '—' }}</p>
            <div class="mt-4 flex flex-wrap gap-1.5">
                @foreach ($lead->layanans as $layanan)
                    <span class="badge badge-blue">{{ $layanan->nama }}</span>
                @endforeach
            </div>
            @if ($lead->catatan_kesepakatan)
                <div class="mt-4 rounded-lg bg-won-tint px-4 py-3 text-[13px] text-won">
                    <div class="font-semibold">Catatan Kesepakatan</div>
                    <p class="mt-0.5 whitespace-pre-line">{{ $lead->catatan_kesepakatan }}</p>
                </div>
            @endif
            @if ($lead->status === 'Tidak Berlanjut')
                <div class="mt-4 rounded-lg bg-lost-tint px-4 py-3 text-[13px] text-lost">
                    <div class="font-semibold">Alasan tidak berlanjut</div>
                    <p class="mt-0.5">{{ $lead->alasan_tidak_berlanjut }}</p>
                </div>
            @endif
        </section>

        {{-- konsultasi --}}
        <section class="card p-5 sm:p-6">
            <div class="flex items-center justify-between gap-3">
                <h2 class="text-base font-semibold">Konsultasi</h2>
                @if ($lead->status === 'Negosiasi')
                    <button type="button" @click="modal = 'jadwal'" class="inline-flex items-center gap-1 text-xs font-semibold text-brand-dark hover:underline">
                        <x-icon name="plus" class="size-3.5" /> Jadwalkan Konsultasi
                    </button>
                @endif
            </div>
            @error('konsultasi') <p class="mt-2 text-xs text-lost">{{ $message }}</p> @enderror

            <ul class="mt-3 divide-y text-[13px]">
                @forelse ($lead->konsultasis as $konsultasi)
                    <li class="py-3.5">
                        <div class="flex flex-col gap-2 sm:flex-row sm:items-start sm:justify-between">
                            <div class="min-w-0">
                                <div class="font-semibold">{{ $konsultasi->tanggal->format('d/m/Y') }} pukul {{ substr($konsultasi->waktu, 0, 5) }}</div>
                                <div class="text-xs text-slate-500">{{ $konsultasi->tempat }}</div>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="badge {{ $konsultasi->status === 'Terlaksana' ? 'badge-green' : ($konsultasi->status === 'Dibatalkan' ? 'badge-red' : 'badge-amber') }}">{{ $konsultasi->status }}</span>
                                @if ($konsultasi->status === 'Dijadwalkan')
                                    <button type="button" @click="modal = 'hasil-{{ $konsultasi->id }}'" class="text-xs font-semibold text-brand-dark hover:underline">Isi hasil</button>
                                @endif
                            </div>
                        </div>
                        @if ($konsultasi->peserta) <div class="mt-1.5 text-xs text-slate-500">Peserta: {{ $konsultasi->peserta }}</div> @endif
                        @if ($konsultasi->catatan) <div class="text-xs text-slate-500">Catatan: {{ $konsultasi->catatan }}</div> @endif
                        @if ($konsultasi->hasil) <div class="mt-1.5 whitespace-pre-line">Hasil: {{ $konsultasi->hasil }}</div> @endif
                    </li>
                @empty
                    <li class="py-3 text-slate-500">Belum ada konsultasi</li>
                @endforelse
            </ul>

            @if ($lead->status !== 'Negosiasi')
                <p class="mt-3 border-t pt-3 text-xs text-slate-500">Konsultasi bisa dijadwalkan saat lead berstatus Negosiasi.</p>
            @endif
        </section>

        {{-- follow-up --}}
        <section class="card p-5 sm:p-6">
            <h2 class="text-base font-semibold">Follow-up</h2>

            <ul class="mt-3 divide-y text-[13px]">
                @forelse ($lead->followUps as $followUp)
                    <li class="flex flex-col gap-2 py-3 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <span class="font-semibold">{{ $followUp->tanggal->format('d/m/Y') }}</span>
                            <span class="text-slate-500">• {{ $followUp->jenis }}</span>
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

            <form method="POST" action="{{ route('follow-up.store', $lead) }}" class="mt-3 grid gap-3 rounded-xl bg-thead p-4 sm:grid-cols-3">
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

        {{-- riwayat interaksi --}}
        <section class="card p-5 sm:p-6">
            <h2 class="text-base font-semibold">Riwayat interaksi</h2>

            <form method="POST" action="{{ route('interaksi.store', $lead) }}" class="mt-3 grid gap-3 rounded-xl bg-thead p-4 sm:grid-cols-2">
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
                @forelse ($lead->riwayatInteraksis as $riwayat)
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
    </div>

    {{-- kolom kanan --}}
    <div class="grid gap-5">
        <section class="card p-5">
            <h2 class="text-base font-semibold">Tindak lanjut lead</h2>
            @if (count($statusDiizinkan) > 0)
                <p class="mt-1 text-xs text-slate-500">Pilih status baru sesuai alur. Alasan wajib diisi untuk Tidak Berlanjut.</p>
                <form method="POST" action="{{ route('leads.status', $lead) }}" class="mt-3 grid gap-3">
                    @csrf
                    <select name="status_baru" class="field @error('status_baru') border-lost @enderror">
                        <option value="">Pilih status baru</option>
                        @foreach ($statusDiizinkan as $status)
                            <option value="{{ $status }}" @selected(old('status_baru') === $status)>{{ $status }}</option>
                        @endforeach
                    </select>
                    @error('status_baru') <p class="text-xs text-lost">{{ $message }}</p> @enderror
                    <input name="alasan" value="{{ old('alasan') }}" placeholder="Alasan (wajib untuk Tidak Berlanjut)" class="field @error('alasan') border-lost @enderror">
                    @error('alasan') <p class="text-xs text-lost">{{ $message }}</p> @enderror
                    <button type="submit" class="btn-primary">Simpan Status</button>
                </form>
            @else
                <p class="mt-2 text-xs text-slate-500">Tidak ada perubahan status yang bisa dipilih dari status {{ $lead->status }}.</p>
            @endif
        </section>

        <section class="card p-5">
            <h2 class="text-base font-semibold">Penanggung jawab</h2>
            <p class="mt-1 text-[13px]">{{ $lead->penanggungJawab->name ?? 'Belum ditugaskan' }}</p>
            @if (auth()->user()->hasRole('Owner'))
                <form method="POST" action="{{ route('leads.penanggung-jawab', $lead) }}" class="mt-3 grid gap-3">
                    @csrf
                    <select name="penanggung_jawab_id" class="field @error('penanggung_jawab_id') border-lost @enderror">
                        <option value="">Pilih Admin</option>
                        @foreach ($semuaAdmin as $admin)
                            <option value="{{ $admin->id }}">{{ $admin->name }}</option>
                        @endforeach
                    </select>
                    @error('penanggung_jawab_id') <p class="text-xs text-lost">{{ $message }}</p> @enderror
                    <button type="submit" class="btn-outline">Tetapkan</button>
                </form>
            @elseif (auth()->user()->hasRole('Admin') && ! $lead->penanggung_jawab_id)
                <form method="POST" action="{{ route('leads.ambil', $lead) }}" class="mt-3 grid gap-3">
                    @csrf
                    @error('ambil') <p class="text-xs text-lost">{{ $message }}</p> @enderror
                    <button type="submit" class="btn-outline">Ambil Lead</button>
                </form>
            @endif
        </section>

        @if (auth()->user()->hasRole('Owner') && $lead->status === 'Negosiasi')
            <section class="card p-5">
                <h2 class="text-base font-semibold">Penetapan Deal</h2>
                <p class="mt-1 text-xs text-slate-500">Syarat: lead berstatus Negosiasi dan sudah ada minimal satu konsultasi Terlaksana.</p>
                <button type="button" @click="modal = 'deal'" class="btn-primary mt-3 w-full">Tetapkan Deal</button>
            </section>
        @endif

        @if ($lead->status === 'Deal')
            <section class="card p-5">
                <h2 class="text-base font-semibold">Konversi ke pelanggan</h2>
                @if ($pelangganSama->isNotEmpty())
                    <p class="mt-1 text-xs text-slate-500">Kontak lead sama dengan pelanggan yang sudah ada, jadi lead akan ditautkan ke pelanggan.</p>
                @else
                    <p class="mt-1 text-xs text-slate-500">Data pelanggan baru akan dibuat dari data lead ini.</p>
                @endif
                <button type="button" @click="modal = 'konversi'" class="btn-primary mt-3 w-full">Konversi</button>
            </section>
        @endif
    </div>
</div>

{{-- popup jadwalkan konsultasi --}}
@if ($lead->status === 'Negosiasi')
    <div x-show="modal === 'jadwal'" x-cloak x-transition.opacity
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 p-4" role="dialog" aria-modal="true">
        <div class="flex min-h-full items-center justify-center">
            <div class="card w-full max-w-lg p-5 sm:p-6" @click.outside="modal = ''">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <h2 class="text-lg font-semibold">Jadwalkan Konsultasi Tatap Muka</h2>
                        <p class="mt-0.5 text-xs text-slate-500">{{ $lead->nama }} • Tahap {{ $lead->status }}</p>
                    </div>
                    <button type="button" @click="modal = ''" aria-label="Tutup"
                            class="-mr-2 -mt-2 flex size-9 shrink-0 items-center justify-center rounded-full text-slate-400 hover:bg-thead">
                        <x-icon name="x-mark" class="size-5" />
                    </button>
                </div>

                <form method="POST" action="{{ route('konsultasi.store', $lead) }}" class="mt-4 grid gap-4 sm:grid-cols-2">
                    @csrf
                    <div class="flex items-start gap-2.5 rounded-lg bg-tint px-4 py-3 text-xs text-brand-dark sm:col-span-2">
                        <x-icon name="info" class="mt-0.5 size-4 shrink-0" />
                        Konsultasi melibatkan Owner, calon pelanggan, dan Kepala Staf Design.
                    </div>

                    <div>
                        <label for="tanggal_konsultasi" class="text-xs font-semibold">Tanggal</label>
                        <input id="tanggal_konsultasi" type="date" name="tanggal_konsultasi" value="{{ old('tanggal_konsultasi') }}" min="{{ today()->format('Y-m-d') }}" class="field mt-1.5 @error('tanggal_konsultasi') border-lost @enderror">
                    </div>
                    <div>
                        <label for="waktu_konsultasi" class="text-xs font-semibold">Waktu</label>
                        <input id="waktu_konsultasi" type="time" name="waktu_konsultasi" value="{{ old('waktu_konsultasi') }}" class="field mt-1.5 @error('waktu_konsultasi') border-lost @enderror">
                    </div>
                    @error('tanggal_konsultasi') <p class="text-xs text-lost sm:col-span-2">{{ $message }}</p> @enderror
                    @error('waktu_konsultasi') <p class="text-xs text-lost sm:col-span-2">{{ $message }}</p> @enderror

                    <div class="sm:col-span-2">
                        <label for="tempat" class="text-xs font-semibold">Tempat</label>
                        <input id="tempat" name="tempat" value="{{ old('tempat') }}" placeholder="Contoh: Studio Bandung" class="field mt-1.5 @error('tempat') border-lost @enderror">
                        @error('tempat') <p class="mt-1 text-xs text-lost">{{ $message }}</p> @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label for="peserta" class="text-xs font-semibold">Peserta</label>
                        <input id="peserta" name="peserta" value="{{ old('peserta', 'Owner, Kepala Staf Design, pelanggan') }}" placeholder="Peserta" class="field mt-1.5 @error('peserta') border-lost @enderror">
                        @error('peserta') <p class="mt-1 text-xs text-lost">{{ $message }}</p> @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label for="catatan" class="text-xs font-semibold">Catatan (opsional)</label>
                        <input id="catatan" name="catatan" value="{{ old('catatan') }}" placeholder="Catatan (opsional)" class="field mt-1.5 @error('catatan') border-lost @enderror">
                        @error('catatan') <p class="mt-1 text-xs text-lost">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex flex-col-reverse gap-3 border-t pt-5 sm:col-span-2 sm:flex-row sm:justify-end">
                        <button type="button" @click="modal = ''" class="btn-outline">Batal</button>
                        <button type="submit" class="btn-primary">Simpan Jadwal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif

{{-- popup hasil konsultasi --}}
@foreach ($lead->konsultasis as $konsultasi)
    @if ($konsultasi->status === 'Dijadwalkan')
        <div x-show="modal === 'hasil-{{ $konsultasi->id }}'" x-cloak x-transition.opacity
             class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 p-4" role="dialog" aria-modal="true">
            <div class="flex min-h-full items-center justify-center">
                <div class="card w-full max-w-md p-5 sm:p-6" @click.outside="modal = ''">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <h2 class="text-lg font-semibold">Hasil Konsultasi</h2>
                            <p class="mt-0.5 text-xs text-slate-500">{{ $konsultasi->tanggal->format('d/m/Y') }} pukul {{ substr($konsultasi->waktu, 0, 5) }} • {{ $konsultasi->tempat }}</p>
                        </div>
                        <button type="button" @click="modal = ''" aria-label="Tutup"
                                class="-mr-2 -mt-2 flex size-9 shrink-0 items-center justify-center rounded-full text-slate-400 hover:bg-thead">
                            <x-icon name="x-mark" class="size-5" />
                        </button>
                    </div>

                    <form method="POST" action="{{ route('konsultasi.hasil', $konsultasi) }}" class="mt-4 grid gap-4">
                        @csrf
                        <input type="hidden" name="konsultasi_id" value="{{ $konsultasi->id }}">
                        <div>
                            <label for="status_konsultasi_{{ $konsultasi->id }}" class="text-xs font-semibold">Status konsultasi</label>
                            <select id="status_konsultasi_{{ $konsultasi->id }}" name="status_konsultasi" class="field mt-1.5">
                                <option value="Terlaksana">Terlaksana</option>
                                <option value="Dibatalkan">Dibatalkan</option>
                            </select>
                        </div>
                        <div>
                            <label for="hasil_{{ $konsultasi->id }}" class="text-xs font-semibold">Hasil konsultasi</label>
                            <textarea id="hasil_{{ $konsultasi->id }}" name="hasil" rows="4" placeholder="Hasil konsultasi (kosongkan bila dibatalkan)" class="field mt-1.5"></textarea>
                        </div>
                        @if (old('konsultasi_id') == $konsultasi->id)
                            @error('status_konsultasi') <p class="text-xs text-lost">{{ $message }}</p> @enderror
                            @error('hasil') <p class="text-xs text-lost">{{ $message }}</p> @enderror
                        @endif

                        <div class="flex flex-col-reverse gap-3 border-t pt-5 sm:flex-row sm:justify-end">
                            <button type="button" @click="modal = ''" class="btn-outline">Batal</button>
                            <button type="submit" class="btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endforeach

{{-- popup tetapkan deal --}}
@if (auth()->user()->hasRole('Owner') && $lead->status === 'Negosiasi')
    <div x-show="modal === 'deal'" x-cloak x-transition.opacity
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 p-4" role="dialog" aria-modal="true">
        <div class="flex min-h-full items-center justify-center">
            <div class="card w-full max-w-lg p-5 sm:p-6" @click.outside="modal = ''">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <h2 class="text-lg font-semibold">Konfirmasi Penetapan Deal</h2>
                        <p class="mt-0.5 text-xs text-slate-500">Pastikan kesepakatan telah sesuai sebelum menyimpan.</p>
                    </div>
                    <button type="button" @click="modal = ''" aria-label="Tutup"
                            class="-mr-2 -mt-2 flex size-9 shrink-0 items-center justify-center rounded-full text-slate-400 hover:bg-thead">
                        <x-icon name="x-mark" class="size-5" />
                    </button>
                </div>

                <div class="mt-4 text-[13px]">
                    <div class="font-semibold">{{ $lead->nama }}</div>
                    <div class="text-xs text-slate-500">{{ $lead->layanans->pluck('nama')->implode(', ') }}</div>
                </div>

                <div class="mt-4 flex items-center gap-2 rounded-lg bg-thead px-4 py-3">
                    <span class="badge badge-amber"><span class="size-1.5 rounded-full bg-current"></span>Negosiasi</span>
                    <x-icon name="arrow-right" class="size-4 text-slate-400" />
                    <span class="badge badge-green"><span class="size-1.5 rounded-full bg-current"></span>Deal</span>
                </div>

                <form method="POST" action="{{ route('leads.deal', $lead) }}" class="mt-4 grid gap-3">
                    @csrf
                    <div>
                        <label for="catatan_kesepakatan" class="text-xs font-semibold">Catatan kesepakatan (opsional)</label>
                        <textarea id="catatan_kesepakatan" name="catatan_kesepakatan" rows="3" placeholder="Catatan kesepakatan (opsional)"
                                  class="field mt-1.5 @error('catatan_kesepakatan') border-lost @enderror">{{ old('catatan_kesepakatan') }}</textarea>
                    </div>
                    @error('catatan_kesepakatan') <p class="text-xs text-lost">{{ $message }}</p> @enderror
                    @error('deal') <p class="text-xs text-lost">{{ $message }}</p> @enderror

                    <div class="flex items-start gap-2.5 rounded-lg bg-won-tint px-4 py-3 text-xs text-won">
                        <x-icon name="check-circle" class="mt-0.5 size-4 shrink-0" />
                        Syarat: sudah ada minimal satu konsultasi Terlaksana. Setelah disimpan, status menjadi Deal.
                    </div>

                    <div class="flex flex-col-reverse gap-3 border-t pt-5 sm:flex-row sm:justify-end">
                        <button type="button" @click="modal = ''" class="btn-outline">Kembali</button>
                        <button type="submit" class="btn-primary">Ya, Tetapkan Deal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif

{{-- popup konfirmasi konversi --}}
@if ($lead->status === 'Deal')
    <div x-show="modal === 'konversi'" x-cloak x-transition.opacity
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 p-4" role="dialog" aria-modal="true">
        <div class="flex min-h-full items-center justify-center">
            <form method="POST" action="{{ route('leads.konversi', $lead) }}" class="card w-full max-w-lg p-5 sm:p-6" @click.outside="modal = ''">
                @csrf
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <h2 class="text-lg font-semibold">Konversi {{ $lead->nama }} jadi pelanggan?</h2>
                        <p class="mt-0.5 text-xs text-slate-500">Tinjau data lead Deal sebelum melanjutkan konversi.</p>
                    </div>
                    <button type="button" @click="modal = ''" aria-label="Tutup"
                            class="-mr-2 -mt-2 flex size-9 shrink-0 items-center justify-center rounded-full text-slate-400 hover:bg-thead">
                        <x-icon name="x-mark" class="size-5" />
                    </button>
                </div>

                <div class="mt-4 flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <div class="font-semibold">{{ $lead->nama }}</div>
                        <div class="text-xs text-slate-500">{{ $lead->tipe_pemohon }}@if ($lead->instansi) • {{ $lead->instansi }}@endif</div>
                    </div>
                    <x-status-badge :status="$lead->status" />
                </div>

                <dl class="mt-3 grid grid-cols-2 gap-x-4 gap-y-3 rounded-lg bg-thead p-4 text-[13px]">
                    <div><dt class="text-[11px] text-slate-500">Nomor HP</dt><dd class="mt-0.5 break-words font-medium">{{ $lead->no_hp ?? '—' }}</dd></div>
                    <div><dt class="text-[11px] text-slate-500">Email</dt><dd class="mt-0.5 break-words font-medium">{{ $lead->email ?? '—' }}</dd></div>
                    <div class="col-span-2"><dt class="text-[11px] text-slate-500">Layanan</dt><dd class="mt-0.5 font-medium">{{ $lead->layanans->pluck('nama')->implode(', ') }}</dd></div>
                    @if ($lead->catatan_kesepakatan)
                        <div class="col-span-2"><dt class="text-[11px] text-slate-500">Catatan kesepakatan</dt><dd class="mt-0.5 whitespace-pre-line font-medium">{{ $lead->catatan_kesepakatan }}</dd></div>
                    @endif
                </dl>

                @if ($pelangganSama->isNotEmpty())
                    <div class="mt-4">
                        <label for="pelanggan_id" class="text-xs font-semibold">Tautkan ke pelanggan yang sudah ada</label>
                        <select id="pelanggan_id" name="pelanggan_id" class="field mt-1.5">
                            @foreach ($pelangganSama as $pelanggan)
                                <option value="{{ $pelanggan->id }}">{{ $pelanggan->nama }} ({{ $pelanggan->no_hp ?? $pelanggan->email }})</option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-[11px] text-slate-500">Kontak lead sama dengan pelanggan di atas, jadi lead akan ditautkan ke pelanggan tersebut.</p>
                    </div>
                @else
                    <p class="mt-4 text-xs text-slate-500">Data pelanggan baru akan dibuat dari data lead ini.</p>
                @endif

                @error('konversi') <p class="mt-3 rounded-lg bg-lost-tint px-3 py-2 text-xs text-lost">{{ $message }}</p> @enderror

                <div class="mt-4 text-[13px]">
                    <div class="text-xs font-semibold">Setelah konversi berhasil</div>
                    <ul class="mt-2 space-y-1.5 text-slate-600">
                        <li class="flex items-center gap-2"><x-icon name="check" class="size-4 text-won" /> Data pelanggan dibuat atau ditautkan.</li>
                        <li class="flex items-center gap-2"><x-icon name="check" class="size-4 text-won" /> Seluruh riwayat lead ditautkan ke pelanggan.</li>
                        <li class="flex items-center gap-2"><x-icon name="check" class="size-4 text-won" /> Status lead menjadi Terkonversi dan tidak bisa diubah lagi.</li>
                    </ul>
                </div>

                <div class="mt-6 flex flex-col-reverse gap-3 border-t pt-5 sm:flex-row sm:justify-end">
                    <button type="button" @click="modal = ''" class="btn-outline">Batal</button>
                    <button type="submit" class="btn-primary">Konfirmasi Konversi</button>
                </div>
            </form>
        </div>
    </div>
@endif

{{-- popup konfirmasi hapus lead --}}
@if ($lead->status !== 'Terkonversi')
    <div x-show="modal === 'hapus'" x-cloak x-transition.opacity
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 p-4" role="dialog" aria-modal="true">
        <div class="flex min-h-full items-center justify-center">
            <div class="card w-full max-w-md p-5 sm:p-6" @click.outside="modal = ''">
                <div class="flex items-start justify-between">
                    <div class="flex size-12 items-center justify-center rounded-lg bg-lost-tint text-lost">
                        <x-icon name="trash" class="size-6" />
                    </div>
                    <button type="button" @click="modal = ''" aria-label="Tutup"
                            class="-mr-2 -mt-2 flex size-9 items-center justify-center rounded-full text-slate-400 hover:bg-thead">
                        <x-icon name="x-mark" class="size-5" />
                    </button>
                </div>

                <h2 class="mt-4 text-xl font-semibold">Hapus lead {{ $lead->nama }}?</h2>
                <p class="mt-1 text-sm text-slate-500">Lead yang dihapus tidak lagi tampil pada daftar dan ringkasan.</p>

                <form method="POST" action="{{ route('leads.destroy', $lead) }}" class="mt-6 flex flex-col-reverse gap-3 border-t pt-5 sm:flex-row sm:justify-end">
                    @csrf
                    <button type="button" @click="modal = ''" class="btn-outline">Batal</button>
                    <button type="submit" class="btn-danger">
                        <x-icon name="trash" class="size-4" /> Hapus Lead
                    </button>
                </form>
            </div>
        </div>
    </div>
@endif

</div>
@endsection