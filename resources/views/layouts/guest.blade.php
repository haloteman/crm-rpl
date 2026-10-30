@extends('layouts.base')

@section('body')
<div class="relative flex min-h-screen flex-col overflow-hidden bg-brand text-white">
    {{-- lingkaran dekorasi --}}
    <div aria-hidden="true" class="pointer-events-none absolute -right-[320px] -top-[320px] size-[760px] rounded-full border border-white/15"></div>
    <div aria-hidden="true" class="pointer-events-none absolute -right-[240px] -top-[240px] size-[600px] rounded-full border border-white/15"></div>
    <div aria-hidden="true" class="pointer-events-none absolute -bottom-[350px] -left-[320px] size-[700px] rounded-full border border-white/15"></div>

    <header class="relative z-10 px-6 pt-7 sm:px-20">
        <x-logo />
    </header>

    <main class="relative z-10 flex flex-1 items-center justify-center px-4 py-10">
        <div class="w-full max-w-[520px]">
            <div class="rounded-2xl bg-white p-6 text-ink shadow-[0_20px_50px_rgba(8,30,90,0.25)] sm:p-10">
                @yield('content')
            </div>
            @hasSection('luar-kartu')
                <div class="mt-6 text-center text-xs text-white/90">@yield('luar-kartu')</div>
            @endif
        </div>
    </main>

    <footer class="relative z-10 px-6 pb-8 text-xs text-white/90 sm:px-20">
        &copy; {{ date('Y') }} PT TipeCreative. Seluruh hak cipta dilindungi.
    </footer>
</div>
@endsection