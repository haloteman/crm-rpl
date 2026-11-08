{{--
    Menampilkan foto/video asli kalau filenya ada di public/media, kalau tidak ada tampil isi slot (ilustrasi).
    Contoh: <x-media nama="hero" video> ...ilustrasi... </x-media>
    File yang dicari: public/media/{nama}.mp4 (video) dan {nama}.webp/.jpg/.jpeg/.png (foto atau poster video)
--}}
@props(['nama', 'video' => false, 'kontrol' => false, 'alt' => ''])
@php
    $foto = collect(['webp', 'jpg', 'jpeg', 'png'])->first(fn ($ext) => file_exists(public_path("media/{$nama}.{$ext}")));
    $ada_video = $video && file_exists(public_path("media/{$nama}.mp4"));
@endphp
@if ($ada_video)
    <video {{ $kontrol ? 'controls' : 'autoplay muted loop' }} playsinline preload="metadata"
           @if ($foto) poster="{{ asset("media/{$nama}.{$foto}") }}" @endif
           {{ $attributes->merge(['class' => 'size-full object-cover']) }}>
        <source src="{{ asset("media/{$nama}.mp4") }}" type="video/mp4">
    </video>
@elseif ($foto)
    <img src="{{ asset("media/{$nama}.{$foto}") }}" alt="{{ $alt }}" loading="lazy" {{ $attributes->merge(['class' => 'size-full object-cover']) }}>
@else
    {{ $slot }}
@endif