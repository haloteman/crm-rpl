@extends('layouts.base')

@php
    $menu = [
        ['route' => 'dashboard',   'label' => 'Dashboard',   'icon' => 'dashboard'],
        ['route' => 'leads',       'label' => 'Leads',       'icon' => 'leads'],
        ['route' => 'customer',    'label' => 'Customer',    'icon' => 'customer'],
        ['route' => 'penawaran',   'label' => 'Penawaran',   'icon' => 'penawaran'],
        ['route' => 'follow-up',   'label' => 'Follow up',   'icon' => 'follow-up'],
        ['route' => 'kesepakatan', 'label' => 'Kesepakatan', 'icon' => 'kesepakatan'],
        ['route' => 'pembayaran',  'label' => 'Pembayaran',  'icon' => 'pembayaran'],
    ];
    if (auth()->user()->hasRole(...\App\Models\Role::USER_MANAGERS)) {
        $menu[] = ['route' => 'users.index', 'label' => 'Pengguna', 'icon' => 'users', 'match' => 'users.*'];
    }
    $menu[] = ['route' => 'settings', 'label' => 'Settings', 'icon' => 'settings'];
@endphp

@section('body')
<div x-data="{ sidebar: false }" class="min-h-screen">
    {{-- overlay sidebar di layar kecil --}}
    <div x-show="sidebar" x-cloak @click="sidebar = false" class="fixed inset-0 z-30 bg-black/40 lg:hidden"></div>

    <aside :class="sidebar ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
           class="fixed inset-y-0 left-0 z-40 flex w-[242px] flex-col bg-brand text-white transition-transform">
        <div class="flex h-[99px] items-center px-7">
            <img src="{{ asset('images/logo-white.png') }}" alt="CRM" class="h-12 w-auto">
        </div>
        <nav class="mt-6 flex-1 space-y-1 overflow-y-auto px-3 pb-6">
            @foreach ($menu as $item)
                @php $active = request()->routeIs($item['match'] ?? $item['route']); @endphp
                <a href="{{ route($item['route']) }}"
                   class="flex items-center gap-3 rounded-lg px-3 py-3 text-lg {{ $active ? 'bg-white/20 font-medium' : 'hover:bg-white/10' }}">
                    <x-icon :name="$item['icon']" class="size-7 shrink-0" />
                    {{ $item['label'] }}
                </a>
            @endforeach
        </nav>
        <div class="border-t border-white/20 p-4">
            <div class="mb-3 px-1 text-sm">
                <div class="truncate font-medium">{{ auth()->user()->name }}</div>
                <div class="text-white/70">{{ auth()->user()->role->name }}</div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex w-full items-center gap-2 rounded-lg px-3 py-2 text-left hover:bg-white/10">
                    <x-icon name="logout" class="size-5" /> Logout
                </button>
            </form>
        </div>
    </aside>

    <div class="lg:pl-[242px]">
        <header class="sticky top-0 z-20 flex h-[99px] items-center gap-4 bg-brand-dark px-4 text-white sm:px-6">
            <button type="button" class="lg:hidden" @click="sidebar = true" aria-label="Buka menu"><x-icon name="menu" class="size-7" /></button>
            <h1 class="text-3xl font-semibold">@yield('heading')</h1>
            @hasSection('search')
                <div class="relative ml-4 hidden w-72 md:block">
                    <x-icon name="search" class="absolute left-2 top-1/2 size-5 -translate-y-1/2 text-slate-400" />
                    <input type="search" placeholder="search" class="w-full rounded-md bg-white/90 py-2 pl-9 pr-3 text-slate-800 placeholder:text-slate-400 outline-none">
                </div>
            @endif
            <div class="ml-auto flex items-center gap-5">
                <button type="button" aria-label="Notifikasi"><x-icon name="bell" class="size-7" /></button>
            </div>
        </header>

        <main class="p-4 sm:p-6">
            @if (session('status'))
                <div class="mb-4 rounded-lg border border-green-300 bg-green-50 px-4 py-3 text-green-800">{{ session('status') }}</div>
            @endif
            @yield('content')
        </main>
    </div>
</div>
@endsection