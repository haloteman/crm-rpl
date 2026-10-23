@extends('layouts.base')

@section('body')
<main class="flex min-h-screen items-center justify-center px-4 py-10">
    <div class="w-full max-w-[475px] bg-white px-6 pb-12 pt-14 shadow-[3px_4px_5px_rgba(0,0,0,0.3)]">
        <img src="{{ asset('images/logo.png') }}" alt="CRM" class="mx-auto mb-8 h-14 w-auto">
        @yield('content')
    </div>
</main>
@endsection