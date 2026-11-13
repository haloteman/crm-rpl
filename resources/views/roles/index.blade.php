@extends('layouts.app')
@section('title', 'Roles')
@section('heading', 'Roles')

@section('content')
<h1 class="page-title">Roles</h1>
<p class="page-sub">Permission yang dimiliki setiap role.</p>

<section class="card mt-5 overflow-x-auto">
    <table class="w-full min-w-[480px] text-left text-xs">
        <thead class="bg-thead text-[11px] text-slate-500">
            <tr>
                <th class="px-[18px] py-2.5 font-medium">No</th>
                <th class="px-[18px] py-2.5 font-medium">Role</th>
                <th class="px-[18px] py-2.5 font-medium">Permissions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($roles as $role)
                <tr class="border-t">
                    <td class="px-[18px] py-3">{{ $loop->iteration }}</td>
                    <td class="px-[18px] py-3 text-[13px] font-medium">{{ $role->name }}</td>
                    <td class="px-[18px] py-3">
                        <div class="flex flex-wrap gap-1.5">
                            @forelse ($role->permissions as $permission)
                                <span class="rounded-md bg-tint px-2 py-0.5 text-brand-dark">{{ ucfirst($permission->name) }}</span>
                            @empty
                                <span class="text-slate-400">Belum ada permission</span>
                            @endforelse
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</section>
@endsection
