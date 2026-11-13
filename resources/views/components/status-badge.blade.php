@props(['status'])
@php
    $kelas = match ($status) {
        'Baru' => 'badge-blue',
        'Negosiasi' => 'badge-amber',
        'Deal' => 'badge-green',
        'Terkonversi' => 'badge-purple',
        'Tidak Berlanjut', 'Ditolak' => 'badge-red',
        'Dikirim', 'Dibayar Sebagian' => 'badge-amber',
        'Disetujui', 'Lunas' => 'badge-green',
        default => 'badge-gray',
    };
@endphp
<span {{ $attributes->merge(['class' => 'badge '.$kelas]) }}>
    <span class="size-1.5 rounded-full bg-current"></span>{{ $status }}
</span>