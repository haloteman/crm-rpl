@extends('layouts.app')
@section('title', 'Permissions')
@section('heading', 'Permissions')

@section('content')
<h1 class="page-title">Permissions</h1>
<p class="page-sub">Daftar permission yang ada di sistem.</p>

<section class="card mt-5 overflow-x-auto">
    <table class="w-full min-w-[320px] text-left text-xs">
        <thead class="bg-thead text-[11px] text-slate-500">
            <tr>
                <th class="px-[18px] py-2.5 font-medium">No</th>
                <th class="px-[18px] py-2.5 font-medium">Permission</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($permissions as $permission)
                <tr class="border-t">
                    <td class="px-[18px] py-3">{{ $loop->iteration }}</td>
                    <td class="px-[18px] py-3 text-[13px]">{{ ucfirst($permission->name) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</section>
@endsection
