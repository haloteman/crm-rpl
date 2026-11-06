@props(['status'])
@php
    $kelas = match ($status) {
        'Baru' => 'badge-blue',
        'Negosiasi' => 'badge-amber',
        'Deal' => 'badge-green',
        'Terkonversi' => 'badge-purple',
        'Tidak Berlanjut' => 'badge-red',
        default => 'badge-gray',
    };
@endphp
<span {{ $attributes->merge(['class' => 'badge '.$kelas]) }}>
    <span class="size-1.5 rounded-full bg-current"></span>{{ $status }}
</span>