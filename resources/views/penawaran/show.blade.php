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
            @if ($penawaran->penetapHargaAkhir)
                <p class="mt-1">Harga akhir ditetapkan oleh {{ $penawaran->penetapHargaAkhir->name }}, {{ $penawaran->harga_akhir_at->format('d/m/Y H:i') }}</p>
            @endif
            @if ($penawaran->pemutus)
                <p class="mt-1">Diputuskan {{ $penawaran->status === 'Disetujui' ? 'Won' : 'Lost' }} oleh {{ $penawaran->pemutus->name }}, {{ $penawaran->diputuskan_at->format('d/m/Y H:i') }}</p>
            @endif
        </section>

        @if ($penawaran->status === 'Ditolak')
            <section class="card p-5 text-[13px]">
                <h2 class="text-base font-semibold">Hasil: Lost</h2>
                <p class="mt-2">Alasan: {{ $penawaran->alasan_lost }}</p>
                @if ($penawaran->catatan_lost)
                    <p class="mt-1 whitespace-pre-line text-slate-500">{{ $penawaran->catatan_lost }}</p>
                @endif
            </section>
        @endif

        @if (auth()->user()->hasRole('Owner') && ! $penawaran->sudahDiputuskan())
            <section class="card p-5">
                <h2 class="text-base font-semibold">Keputusan Owner</h2>

                @if ($penawaran->status === 'Dikirim')
                    <form method="POST" action="{{ route('penawaran.harga-akhir', $penawaran) }}" class="mt-3 grid gap-2">
                        @csrf
                        <label for="harga_akhir" class="text-xs font-semibold">Harga Akhir (Rp)</label>
                        <input id="harga_akhir" name="harga_akhir" type="number" min="1" max="{{ $penawaran->nilai_penawaran }}"
                               value="{{ old('harga_akhir', $penawaran->harga_akhir ?? $penawaran->nilai_penawaran) }}"
                               class="field @error('harga_akhir') border-lost @enderror">
                        @error('harga_akhir') <p class="text-xs text-lost">{{ $message }}</p> @enderror
                        <button type="submit" class="btn-outline">Tetapkan Harga Akhir</button>
                    </form>

                    <form method="POST" action="{{ route('penawaran.won', $penawaran) }}" class="mt-4">
                        @csrf
                        <p class="text-xs text-slate-500">Syarat Won: harga akhir sudah ditetapkan dan lead berstatus Deal.</p>
                        @error('keputusan') <p class="mt-1 text-xs text-lost">{{ $message }}</p> @enderror
                        <button type="submit" class="btn-primary mt-2 w-full">Tetapkan Won</button>
                    </form>
                @endif

                <form method="POST" action="{{ route('penawaran.lost', $penawaran) }}" class="mt-4 grid gap-2">
                    @csrf
                    <label for="alasan_lost" class="text-xs font-semibold">Alasan Lost</label>
                    <select id="alasan_lost" name="alasan_lost" class="field @error('alasan_lost') border-lost @enderror">
                        <option value="">Pilih alasan</option>
                        @foreach (\App\Models\Penawaran::ALASAN_LOST as $alasan)
                            <option value="{{ $alasan }}" @selected(old('alasan_lost') === $alasan)>{{ $alasan }}</option>
                        @endforeach
                    </select>
                    @error('alasan_lost') <p class="text-xs text-lost">{{ $message }}</p> @enderror
                    <textarea name="catatan_lost" rows="2" placeholder="Catatan (opsional)" class="field @error('catatan_lost') border-lost @enderror">{{ old('catatan_lost') }}</textarea>
                    @error('catatan_lost') <p class="text-xs text-lost">{{ $message }}</p> @enderror
                    <button type="submit" class="btn-outline text-lost">Tetapkan Lost</button>
                </form>
            </section>
        @endif
    </div>
</div>

@if ($penawaran->status === 'Disetujui')
    @php $kesepakatan = $penawaran->kesepakatan; @endphp
    <section class="card mt-5 p-5">
        <h2 class="text-base font-semibold">Kesepakatan</h2>
        @error('kesepakatan') <p class="mt-2 rounded-lg bg-lost-tint px-3 py-2 text-xs text-lost">{{ $message }}</p> @enderror

        @if ($kesepakatan)
            <dl class="mt-4 grid gap-4 text-[13px] sm:grid-cols-2">
                <div>
                    <dt class="text-xs text-slate-500">Nilai Kesepakatan</dt>
                    <dd>Rp{{ number_format($kesepakatan->nilai_kesepakatan, 0, ',', '.') }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-slate-500">Tanggal Kesepakatan</dt>
                    <dd>{{ $kesepakatan->tanggal_kesepakatan->format('d/m/Y') }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-slate-500">Masa Kontrak</dt>
                    <dd>
                        @if ($kesepakatan->masa_kontrak_mulai || $kesepakatan->masa_kontrak_selesai)
                            {{ $kesepakatan->masa_kontrak_mulai?->format('d/m/Y') ?? '—' }} s.d. {{ $kesepakatan->masa_kontrak_selesai?->format('d/m/Y') ?? '—' }}
                        @else
                            —
                        @endif
                    </dd>
                </div>
                <div>
                    <dt class="text-xs text-slate-500">Frekuensi Update Progres</dt>
                    <dd>{{ $kesepakatan->frekuensi_update_progres ?: '—' }}</dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="text-xs text-slate-500">Ketentuan Pekerjaan</dt>
                    <dd class="whitespace-pre-line">{{ $kesepakatan->ketentuan_pekerjaan }}</dd>
                </div>
            </dl>
            <p class="mt-4 text-xs text-slate-500">
                Dicatat oleh {{ $kesepakatan->pembuat->name }}, {{ $kesepakatan->created_at->format('d/m/Y H:i') }}
                @if ($kesepakatan->pengubah)
                    · Diubah oleh {{ $kesepakatan->pengubah->name }}, {{ $kesepakatan->updated_at->format('d/m/Y H:i') }}
                @endif
            </p>
        @endif

        @if (! $kesepakatan || $kesepakatan->pembayarans->isEmpty())
            <form method="POST" action="{{ $kesepakatan ? route('kesepakatan.update', $kesepakatan) : route('kesepakatan.store', $penawaran) }}"
                  class="mt-4 grid gap-4 border-t pt-4 sm:grid-cols-2">
                @csrf
                <h3 class="text-sm font-semibold sm:col-span-2">{{ $kesepakatan ? 'Ubah kesepakatan' : 'Catat kesepakatan' }}</h3>
                <div>
                    <span class="text-xs font-semibold">Nilai Kesepakatan</span>
                    <p class="mt-1.5 text-[13px]">Rp{{ number_format($penawaran->harga_akhir, 0, ',', '.') }} <span class="text-slate-500">(sama dengan harga akhir)</span></p>
                </div>
                <div>
                    <label for="tanggal_kesepakatan" class="text-xs font-semibold">Tanggal Kesepakatan</label>
                    <input id="tanggal_kesepakatan" name="tanggal_kesepakatan" type="date" max="{{ today()->format('Y-m-d') }}"
                           value="{{ old('tanggal_kesepakatan', $kesepakatan?->tanggal_kesepakatan->format('Y-m-d')) }}"
                           class="field mt-1.5 @error('tanggal_kesepakatan') border-lost @enderror">
                    @error('tanggal_kesepakatan') <p class="mt-1 text-xs text-lost">{{ $message }}</p> @enderror
                </div>
                <div class="sm:col-span-2">
                    <label for="ketentuan_pekerjaan" class="text-xs font-semibold">Ketentuan Pekerjaan</label>
                    <textarea id="ketentuan_pekerjaan" name="ketentuan_pekerjaan" rows="3" placeholder="Ruang lingkup, jumlah revisi, jadwal, dan lainnya"
                              class="field mt-1.5 @error('ketentuan_pekerjaan') border-lost @enderror">{{ old('ketentuan_pekerjaan', $kesepakatan->ketentuan_pekerjaan ?? '') }}</textarea>
                    @error('ketentuan_pekerjaan') <p class="mt-1 text-xs text-lost">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="masa_kontrak_mulai" class="text-xs font-semibold">Masa Kontrak Mulai (opsional)</label>
                    <input id="masa_kontrak_mulai" name="masa_kontrak_mulai" type="date"
                           value="{{ old('masa_kontrak_mulai', $kesepakatan?->masa_kontrak_mulai?->format('Y-m-d')) }}"
                           class="field mt-1.5 @error('masa_kontrak_mulai') border-lost @enderror">
                    @error('masa_kontrak_mulai') <p class="mt-1 text-xs text-lost">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="masa_kontrak_selesai" class="text-xs font-semibold">Masa Kontrak Selesai (opsional)</label>
                    <input id="masa_kontrak_selesai" name="masa_kontrak_selesai" type="date"
                           value="{{ old('masa_kontrak_selesai', $kesepakatan?->masa_kontrak_selesai?->format('Y-m-d')) }}"
                           class="field mt-1.5 @error('masa_kontrak_selesai') border-lost @enderror">
                    @error('masa_kontrak_selesai') <p class="mt-1 text-xs text-lost">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="frekuensi_update_progres" class="text-xs font-semibold">Frekuensi Update Progres (opsional)</label>
                    <input id="frekuensi_update_progres" name="frekuensi_update_progres" placeholder="Contoh: setiap 3 hari"
                           value="{{ old('frekuensi_update_progres', $kesepakatan->frekuensi_update_progres ?? '') }}"
                           class="field mt-1.5 @error('frekuensi_update_progres') border-lost @enderror">
                    @error('frekuensi_update_progres') <p class="mt-1 text-xs text-lost">{{ $message }}</p> @enderror
                </div>
                <div class="sm:col-span-2">
                    <button type="submit" class="btn-primary">{{ $kesepakatan ? 'Simpan Perubahan' : 'Catat Kesepakatan' }}</button>
                </div>
            </form>
        @endif
    </section>
@endif
@endsection
