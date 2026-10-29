@extends('layouts.app')
@section('title', 'Pengguna')
@section('heading', 'Pengguna')

@section('content')
<div x-data="{ modal: '{{ $errors->any() ? 'tambah' : (session('kredensial') ? 'kredensial' : '') }}' }">

    <div class="flex flex-wrap items-center justify-between gap-4">
        <div class="card px-5 py-3">
            <div class="text-sm">Total Akun</div>
            <div class="text-2xl font-bold">{{ $totalAkun }}</div>
        </div>
        <button type="button" @click="modal = 'tambah'" class="btn-primary gap-2">
            <x-icon name="plus" class="size-5" /> Tambah Akun
        </button>
    </div>

    <form method="GET" action="{{ route('users.index') }}" class="mt-6 flex flex-wrap gap-3">
        <input type="search" name="cari" value="{{ request('cari') }}" placeholder="Cari nama atau NIP" class="field max-w-xs">
        <select name="role" class="field max-w-[200px]">
            <option value="">Semua Role</option>
            @foreach ($semuaRole as $role)
                <option value="{{ $role->id }}" @selected(request('role') == $role->id)>{{ $role->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn-outline">Cari</button>
    </form>

    <div class="card mt-4 overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-thead">
                <tr>
                    <th class="px-4 py-3">Nama Lengkap</th>
                    <th class="px-4 py-3">NIP</th>
                    <th class="px-4 py-3">Role</th>
                    <th class="px-4 py-3">Login Terakhir</th>
                    <th class="px-4 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr class="border-t">
                        <td class="px-4 py-3">{{ $user->name }}</td>
                        <td class="px-4 py-3">
                            {{ $user->nip }}
                            <button type="button" @click="copyText('{{ $user->nip }}')" class="copy-chip ml-2">
                                <x-icon name="copy" class="size-4" /> Copy
                            </button>
                        </td>
                        <td class="px-4 py-3">{{ $user->role->name }}</td>
                        <td class="px-4 py-3">{{ $user->last_login_at ? $user->last_login_at->format('d/m/Y H:i') : '-' }}</td>
                        <td class="px-4 py-3">
                            @if (auth()->user()->canResetPassword($user))
                                <button type="button" @click="modal = 'reset-{{ $user->id }}'" class="text-brand hover:underline">Reset Password</button>
                            @endif
                            @if (auth()->user()->canDelete($user))
                                <button type="button" @click="modal = 'hapus-{{ $user->id }}'" class="ml-3 text-lost hover:underline">Hapus akun</button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-6 text-center text-slate-500">Akun tidak ditemukan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $users->links() }}</div>

    @foreach ($users as $user)
        {{-- popup konfirmasi reset password --}}
        <div x-show="modal === 'reset-{{ $user->id }}'" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4">
            <div class="card w-full max-w-md p-6" @click.outside="modal = ''">
                <h2 class="text-lg font-semibold">Reset password akun ini?</h2>
                <p class="mt-3">Nama: {{ $user->name }}<br>NIP: {{ $user->nip }}</p>
                <p class="mt-3 text-sm text-slate-500">Password baru dibuat otomatis dan wajib diganti saat login berikutnya.</p>
                <form method="POST" action="{{ route('users.reset', $user) }}" class="mt-6 flex justify-end gap-3">
                    @csrf
                    <button type="button" @click="modal = ''" class="btn-outline">Batal</button>
                    <button type="submit" class="btn-primary">Reset Password</button>
                </form>
            </div>
        </div>

        {{-- popup konfirmasi hapus akun --}}
        <div x-show="modal === 'hapus-{{ $user->id }}'" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4">
            <div class="card w-full max-w-md p-6" @click.outside="modal = ''">
                <h2 class="text-lg font-semibold">Hapus akun ini?</h2>
                <p class="mt-3">Nama: {{ $user->name }}<br>NIP: {{ $user->nip }}</p>
                <p class="mt-3 text-sm text-slate-500">Akun tidak bisa login lagi.</p>
                <form method="POST" action="{{ route('users.destroy', $user) }}" class="mt-6 flex justify-end gap-3">
                    @csrf
                    <button type="button" @click="modal = ''" class="btn-outline">Batal</button>
                    <button type="submit" class="btn-primary bg-lost hover:bg-red-700">Hapus</button>
                </form>
            </div>
        </div>
    @endforeach

    {{-- popup tambah akun --}}
    <div x-show="modal === 'tambah'" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4">
        <div class="card w-full max-w-md p-6" @click.outside="modal = ''">
            <h2 class="text-lg font-semibold">Tambah Akun</h2>
            <form method="POST" action="{{ route('users.store') }}" class="mt-4">
                @csrf
                <label for="name" class="block">Nama Lengkap</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" class="field mt-1">
                @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror

                <label for="role_id" class="mt-4 block">Role</label>
                <select id="role_id" name="role_id" class="field mt-1">
                    <option value="">Pilih role</option>
                    @foreach ($pilihanRole as $role)
                        <option value="{{ $role->id }}" @selected(old('role_id') == $role->id)>{{ $role->name }}</option>
                    @endforeach
                </select>
                @error('role_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" @click="modal = ''" class="btn-outline">Batal</button>
                    <button type="submit" class="btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- popup NIP + password sementara --}}
    @if (session('kredensial'))
        <div x-show="modal === 'kredensial'" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4">
            <div class="card w-full max-w-md p-6 text-center">
                <x-icon name="check-circle" class="mx-auto size-12 text-won" />
                <h2 class="mt-3 text-lg font-semibold">{{ session('kredensial')['judul'] }}</h2>
                <p class="mt-2 text-sm text-slate-500">Serahkan NIP dan password ini ke pengguna yang bersangkutan. Password tidak akan ditampilkan lagi.</p>

                <div class="mt-5 space-y-3 text-left">
                    <div class="flex items-center justify-between rounded-lg border px-4 py-2">
                        <span>NIP: <b>{{ session('kredensial')['nip'] }}</b></span>
                        <button type="button" @click="copyText('{{ session('kredensial')['nip'] }}')" class="copy-chip"><x-icon name="copy" class="size-4" /> Copy</button>
                    </div>
                    <div class="flex items-center justify-between rounded-lg border px-4 py-2">
                        <span>Password: <b>{{ session('kredensial')['password'] }}</b></span>
                        <button type="button" @click="copyText('{{ session('kredensial')['password'] }}')" class="copy-chip"><x-icon name="copy" class="size-4" /> Copy</button>
                    </div>
                </div>

                <button type="button" @click="modal = ''" class="btn-primary mt-6 w-full">Selesai</button>
            </div>
        </div>
    @endif
</div>
@endsection
