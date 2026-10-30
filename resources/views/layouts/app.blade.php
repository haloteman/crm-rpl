@extends('layouts.base')

@php
    $menu = [
        ['route' => 'dashboard',         'label' => 'Dashboard',         'icon' => 'dashboard'],
        ['route' => 'leads',             'label' => 'Leads',             'icon' => 'leads'],
        ['route' => 'customer',          'label' => 'Customer',          'icon' => 'customer'],
        ['route' => 'penawaran',         'label' => 'Penawaran',         'icon' => 'penawaran'],
        ['route' => 'follow-up',         'label' => 'Follow Up',         'icon' => 'follow-up'],
        ['route' => 'project',           'label' => 'Project',           'icon' => 'folder'],
        ['route' => 'users.index',       'label' => 'Manajemen Akun',    'icon' => 'user-cog', 'match' => 'users.*'],
        ['route' => 'riwayat-pembelian', 'label' => 'Riwayat pembelian', 'icon' => 'shopping-bag'],
    ];

    $menu = array_filter($menu, fn ($item) => Route::has($item['route']) && auth()->user()->bolehAkses($item['route']));

    $me = auth()->user();
    $inisial = collect(preg_split('/\s+/', trim($me->name)))
        ->filter()->take(2)
        ->map(fn ($kata) => mb_strtoupper(mb_substr($kata, 0, 1)))
        ->implode('');
@endphp

@section('body')
<div x-data="{ sidebar: false }" class="min-h-screen">
    {{-- overlay sidebar di layar kecil --}}
    <div x-show="sidebar" x-cloak @click="sidebar = false" class="fixed inset-0 z-30 bg-slate-900/50 lg:hidden"></div>

    <aside :class="sidebar ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
           class="fixed inset-y-0 left-0 z-40 flex w-[252px] flex-col bg-brand text-white transition-transform">
        <div class="px-6 pt-6">
            <x-logo />
        </div>

        <div class="mt-6 px-6 text-[11px] font-semibold uppercase tracking-wider text-white/80">Ruang kerja</div>

        <nav class="mt-3 flex-1 space-y-1 overflow-y-auto px-[18px] pb-6">
            @foreach ($menu as $item)
                @php $active = request()->routeIs($item['match'] ?? $item['route']); @endphp
                <a href="{{ route($item['route']) }}" @if ($active) aria-current="page" @endif
                   class="flex h-11 items-center gap-3 rounded-lg px-3 text-[13px] {{ $active ? 'bg-white font-semibold text-brand-dark' : 'font-medium text-white/90 hover:bg-white/10' }}">
                    <x-icon :name="$item['icon']" class="size-5 shrink-0" />
                    <span class="flex-1">{{ $item['label'] }}</span>
                    @if ($active) <span class="size-1.5 rounded-full bg-brand-dark"></span> @endif
                </a>
            @endforeach
        </nav>

        <div class="space-y-1 px-[18px] pb-6">
            <a href="{{ route('password.edit') }}" class="flex h-10 items-center gap-3 rounded-lg px-3 text-[13px] text-white/90 hover:bg-white/10">
                <x-icon name="key" class="size-5" /> Ganti password
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex h-10 w-full items-center gap-3 rounded-lg px-3 text-left text-[13px] text-white/90 hover:bg-white/10">
                    <x-icon name="logout" class="size-5" /> Keluar
                </button>
            </form>
        </div>
    </aside>

    <div class="lg:pl-[252px]">
        <header class="sticky top-0 z-20 flex h-[88px] items-center gap-3 border-b bg-white px-4 sm:px-8">
            <button type="button" class="lg:hidden" @click="sidebar = true" aria-label="Buka menu"><x-icon name="menu" class="size-6" /></button>

            <nav aria-label="Breadcrumb" class="flex min-w-0 items-center gap-2 text-sm">
                <span class="hidden text-slate-500 sm:inline">Ruang kerja</span>
                <x-icon name="chevron-right" class="hidden size-4 shrink-0 text-slate-400 sm:block" />
                <span class="truncate font-semibold">@yield('heading')</span>
            </nav>

            @hasSection('search')
                <div class="relative ml-4 hidden w-72 md:block">
                    <x-icon name="search" class="absolute left-3 top-1/2 size-5 -translate-y-1/2 text-slate-400" />
                    <input type="search" placeholder="Cari" class="field pl-10">
                </div>
            @endif

            {{-- profil pengguna --}}
            <div x-data="{ open: false }" @click.outside="open = false" class="relative ml-auto">
                <button type="button" @click="open = ! open" class="flex items-center gap-3 rounded-lg p-1 text-left">
                    <span class="flex size-10 shrink-0 items-center justify-center rounded-full bg-tint text-xs font-bold text-brand-dark">{{ $inisial }}</span>
                    <span class="hidden sm:block">
                        <span class="block max-w-44 truncate text-sm font-semibold leading-tight">{{ $me->name }}</span>
                        <span class="mt-0.5 inline-block rounded-md bg-tint px-2 py-0.5 text-[11px] font-medium text-brand-dark">{{ $me->role->name }}</span>
                    </span>
                    <x-icon name="chevron-down" class="size-4 text-slate-500" />
                </button>
                <div x-show="open" x-cloak x-transition.opacity
                     class="absolute right-0 mt-2 w-52 rounded-xl border bg-white p-1.5 shadow-lg">
                    <div class="px-3 py-2 sm:hidden">
                        <div class="truncate text-sm font-semibold">{{ $me->name }}</div>
                        <div class="text-xs text-slate-500">{{ $me->role->name }}</div>
                    </div>
                    <a href="{{ route('password.edit') }}" class="flex items-center gap-2 rounded-lg px-3 py-2 text-sm hover:bg-thead">
                        <x-icon name="key" class="size-4 text-slate-500" /> Ganti password
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="flex w-full items-center gap-2 rounded-lg px-3 py-2 text-left text-sm hover:bg-thead">
                            <x-icon name="logout" class="size-4 text-slate-500" /> Keluar
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <main class="p-4 sm:p-8">
            @if (session('status'))
                <div class="mb-5 flex items-start gap-3 rounded-lg border border-won/20 bg-won-tint px-4 py-3 text-sm text-won">
                    <x-icon name="check-circle" class="mt-0.5 size-5 shrink-0" />
                    <p>{{ session('status') }}</p>
                </div>
            @endif
            @yield('content')
        </main>
    </div>
</div>
@endsection