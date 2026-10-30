@extends('layouts.app')
@section('title', 'Manajemen Akun')
@section('heading', 'Manajemen Akun')

@section('content')
<div x-data="{ modal: '{{ $errors->any() ? 'tambah' : (session('kredensial') ? 'kredensial' : '') }}' }"
     @keydown.escape.window="if (modal !== 'kredensial') modal = ''">

    {{-- judul + tombol tambah --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
        <div>
            <h1 class="text-[28px] font-bold leading-tight">Manajemen Akun</h1>
            <p class="mt-1 text-sm text-slate-500">Kelola akun dan akses pengguna internal PT TipeCreative.</p>
        </div>
        <button type="button" @click="modal = 'tambah'" class="btn-primary w-full sm:w-auto">
            <x-icon name="user-plus" class="size-5" /> Tambah Akun
        </button>
    </div>

    {{-- total akun + info --}}
    <div class="mt-5 flex flex-col gap-4 md:flex-row">
        <div class="card flex items-center gap-4 px-5 py-4 md:w-64 md:shrink-0">
            <div class="flex size-12 shrink-0 items-center justify-center rounded-lg bg-tint text-brand-dark">
                <x-icon name="users" class="size-6" />
            </div>
            <div>
                <div class="text-sm text-slate-500">Total Akun</div>
                <div class="text-3xl font-semibold leading-tight">
                    {{ $totalAkun }} <span class="text-sm font-normal text-slate-500">akun</span>
                </div>
            </div>
        </div>
        <div class="flex flex-1 items-start gap-3 rounded-xl bg-tint px-5 py-4 text-brand-dark">
            <x-icon name="shield-check" class="mt-0.5 size-5 shrink-0" />
            <div>
                <div class="text-sm font-semibold">Hanya untuk Owner dan Super Admin</div>
                <p class="text-sm text-slate-600">Gunakan NIP untuk mengenali akun. Jaga kerahasiaan kredensial pengguna.</p>
            </div>
        </div>
    </div>

    {{-- daftar pengguna --}}
    <section class="card mt-5">
        <div class="flex items-center justify-between gap-3 px-4 pt-5 sm:px-5">
            <h2 class="text-lg font-semibold">Daftar Pengguna</h2>
            <span class="text-xs text-slate-500">{{ $users->count() }} pengguna ditampilkan</span>
        </div>

        <form method="GET" action="{{ route('users.index') }}" class="flex flex-col gap-3 px-4 pt-4 sm:flex-row sm:px-5">
            <div class="relative flex-1">
                <x-icon name="search" class="pointer-events-none absolute left-3 top-1/2 size-5 -translate-y-1/2 text-slate-400" />
                <input type="search" name="cari" value="{{ request('cari') }}" placeholder="Cari nama atau NIP" class="field pl-10">
            </div>
            <select name="role" class="field sm:w-48">
                <option value="">Semua Role</option>
                @foreach ($semuaRole as $role)
                    <option value="{{ $role->id }}" @selected(request('role') == $role->id)>{{ $role->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn-outline">Cari</button>
        </form>

        {{-- tabel di layar >= md, tumpuk jadi kartu di HP --}}
        <table class="mt-4 block w-full text-left text-sm md:table">
            <thead class="hidden bg-thead text-xs text-slate-500 md:table-header-group">
                <tr>
                    <th class="px-5 py-3 font-medium">Nama Lengkap</th>
                    <th class="px-5 py-3 font-medium">NIP</th>
                    <th class="px-5 py-3 font-medium">Role</th>
                    <th class="px-5 py-3 font-medium">Login Terakhir</th>
                    <th class="px-5 py-3 font-medium">Aksi</th>
                </tr>
            </thead>
            <tbody class="block md:table-row-group">
                @forelse ($users as $user)
                    <tr class="block border-t px-4 py-3 hover:bg-thead md:table-row md:p-0">
                        <td class="block pb-1 font-medium md:table-cell md:px-5 md:py-3 md:pb-3">{{ $user->name }}</td>
                        <td class="flex items-center justify-between gap-3 py-1 md:table-cell md:px-5 md:py-3">
                            <span class="text-xs text-slate-500 md:hidden">NIP</span>
                            <span class="flex items-center gap-3">
                                <span class="font-mono text-[13px]">{{ $user->nip }}</span>
                                <button type="button"
                                        x-data="{ ok: false }"
                                        @click="copyText('{{ $user->nip }}'); ok = true; setTimeout(() => ok = false, 1500)"
                                        class="copy-chip">
                                    <x-icon name="copy" class="size-4" />
                                    <span x-text="ok ? 'Tersalin' : 'Copy NIP'">Copy NIP</span>
                                </button>
                            </span>
                        </td>
                        <td class="flex items-center justify-between gap-3 py-1 md:table-cell md:px-5 md:py-3">
                            <span class="text-xs text-slate-500 md:hidden">Role</span>
                            <span class="rounded-md px-2 py-0.5 text-xs {{ in_array($user->role->name, ['Owner', 'Super Admin']) ? 'bg-tint font-medium text-brand-dark' : 'bg-thead text-slate-500' }}">
                                {{ $user->role->name }}
                            </span>
                        </td>
                        <td class="flex items-center justify-between gap-3 py-1 text-slate-500 md:table-cell md:px-5 md:py-3">
                            <span class="text-xs md:hidden">Login Terakhir</span>
                            <span>{{ $user->last_login_at ? $user->last_login_at->format('d/m/Y H:i') : 'Belum pernah login' }}</span>
                        </td>
                        <td class="flex items-center justify-between gap-3 py-1 md:table-cell md:px-5 md:py-3">
                            <span class="text-xs text-slate-500 md:hidden">Aksi</span>
                            <span class="flex items-center gap-4 text-xs">
                                @if (auth()->user()->canResetPassword($user))
                                    <button type="button" @click="modal = 'reset-{{ $user->id }}'" class="font-medium text-brand-dark hover:underline">Reset Password</button>
                                @endif
                                @if (auth()->user()->canDelete($user))
                                    <button type="button" @click="modal = 'hapus-{{ $user->id }}'" class="font-medium text-lost hover:underline">Hapus Akun</button>
                                @endif
                                @if (! auth()->user()->canResetPassword($user) && ! auth()->user()->canDelete($user))
                                    <span class="text-slate-400">—</span>
                                @endif
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr class="block border-t md:table-row">
                        <td colspan="5" class="block px-5 py-8 text-center text-slate-500 md:table-cell">Akun tidak ditemukan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="flex flex-col gap-3 border-t px-4 py-4 text-xs text-slate-500 sm:flex-row sm:items-center sm:justify-between sm:px-5">
            <span>Menampilkan {{ $users->firstItem() ?? 0 }}–{{ $users->lastItem() ?? 0 }} akun</span>
            <div>{{ $users->links() }}</div>
        </div>
    </section>

    <p class="mt-4 text-xs text-slate-500">Akun yang sudah dihapus tidak ditampilkan. Password tidak ditampilkan dalam daftar pengguna.</p>

    @foreach ($users as $user)
        {{-- popup konfirmasi reset password --}}
        <div x-show="modal === 'reset-{{ $user->id }}'" x-cloak x-transition.opacity
             class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 p-4" role="dialog" aria-modal="true">
            <div class="flex min-h-full items-center justify-center">
                <div class="card w-full max-w-md p-5 sm:p-6" @click.outside="modal = ''">
                    <div class="flex items-start justify-between">
                        <div class="flex size-12 items-center justify-center rounded-lg bg-tint text-brand-dark">
                            <x-icon name="key" class="size-6" />
                        </div>
                        <button type="button" @click="modal = ''" aria-label="Tutup"
                                class="-mr-2 -mt-2 flex size-9 items-center justify-center rounded-full text-slate-400 hover:bg-thead">
                            <x-icon name="x-mark" class="size-5" />
                        </button>
                    </div>

                    <h2 class="mt-4 text-xl font-semibold">Reset password akun ini?</h2>
                    <p class="mt-1 text-sm text-slate-500">Pastikan akun yang dipilih sudah benar sebelum melanjutkan.</p>

                    <div class="mt-4 flex items-start justify-between gap-3 rounded-lg border bg-thead px-4 py-3">
                        <div class="min-w-0">
                            <div class="font-semibold">{{ $user->name }}</div>
                            <div class="font-mono text-sm text-slate-500">{{ $user->nip }}</div>
                        </div>
                        <span class="shrink-0 text-xs text-slate-500">{{ $user->role->name }}</span>
                    </div>

                    <div class="mt-4 rounded-lg bg-tint px-4 py-3 text-sm text-brand-dark">
                        Password baru dibuat otomatis dan wajib diganti saat login berikutnya.
                    </div>

                    <form method="POST" action="{{ route('users.reset', $user) }}" class="mt-6 flex flex-col-reverse gap-3 border-t pt-5 sm:flex-row sm:justify-end">
                        @csrf
                        <button type="button" @click="modal = ''" class="btn-outline">Batal</button>
                        <button type="submit" class="btn-primary">Reset Password</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- popup konfirmasi hapus akun --}}
        <div x-show="modal === 'hapus-{{ $user->id }}'" x-cloak x-transition.opacity
             class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 p-4" role="dialog" aria-modal="true">
            <div class="flex min-h-full items-center justify-center">
                <div class="card w-full max-w-md p-5 sm:p-6" @click.outside="modal = ''">
                    <div class="flex items-start justify-between">
                        <div class="flex size-12 items-center justify-center rounded-lg bg-lost-tint text-lost">
                            <x-icon name="trash" class="size-6" />
                        </div>
                        <button type="button" @click="modal = ''" aria-label="Tutup"
                                class="-mr-2 -mt-2 flex size-9 items-center justify-center rounded-full text-slate-400 hover:bg-thead">
                            <x-icon name="x-mark" class="size-5" />
                        </button>
                    </div>

                    <h2 class="mt-4 text-xl font-semibold">Hapus akun pengguna?</h2>
                    <p class="mt-1 text-sm text-slate-500">Pastikan akun yang dipilih sudah benar sebelum melanjutkan.</p>

                    <div class="mt-4 flex items-start justify-between gap-3 rounded-lg border bg-thead px-4 py-3">
                        <div class="min-w-0">
                            <div class="font-semibold">{{ $user->name }}</div>
                            <div class="font-mono text-sm text-slate-500">{{ $user->nip }}</div>
                        </div>
                        <span class="shrink-0 text-xs text-slate-500">{{ $user->role->name }}</span>
                    </div>

                    <div class="mt-4 flex items-start gap-3 rounded-lg bg-lost-tint px-4 py-3 text-sm text-lost">
                        <x-icon name="exclamation-circle" class="mt-0.5 size-5 shrink-0" />
                        <div>
                            <div class="font-semibold">Pengguna akan kehilangan akses</div>
                            <p>Setelah dihapus, pengguna tidak dapat login dan akun tidak lagi muncul di Daftar Pengguna.</p>
                        </div>
                    </div>
                    <p class="mt-4 text-xs text-slate-500">Pilih Batal jika Anda masih ragu atau ingin memeriksa akun kembali.</p>

                    <form method="POST" action="{{ route('users.destroy', $user) }}" class="mt-6 flex flex-col-reverse gap-3 border-t pt-5 sm:flex-row sm:justify-end">
                        @csrf
                        <button type="button" @click="modal = ''" class="btn-outline">Batal</button>
                        <button type="submit" class="btn-primary bg-lost hover:bg-red-700">
                            <x-icon name="trash" class="size-4" /> Hapus Akun
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    {{-- popup tambah akun --}}
    <div x-show="modal === 'tambah'" x-cloak x-transition.opacity
         class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 p-4" role="dialog" aria-modal="true">
        <div class="flex min-h-full items-center justify-center">
            <div class="card w-full max-w-lg p-5 sm:p-6" @click.outside="modal = ''">
                <div class="flex items-start justify-between gap-3">
                    <div>
                        <h2 class="text-xl font-semibold">Tambah Akun</h2>
                        <p class="mt-1 text-sm text-slate-500">Isi nama dan pilih role. NIP serta password sementara akan dibuat otomatis.</p>
                    </div>
                    <button type="button" @click="modal = ''" aria-label="Tutup"
                            class="-mr-2 -mt-2 flex size-9 shrink-0 items-center justify-center rounded-full text-slate-400 hover:bg-thead">
                        <x-icon name="x-mark" class="size-5" />
                    </button>
                </div>

                <form method="POST" action="{{ route('users.store') }}" class="mt-5">
                    @csrf
                    <label for="name" class="block text-sm font-medium">Nama Lengkap</label>
                    <input id="name" name="name" type="text" value="{{ old('name') }}" placeholder="Contoh: Dinda Maharani"
                           class="field mt-1.5 @error('name') border-lost @enderror">
                    @error('name')
                        <p class="mt-1 text-sm text-lost">{{ $message }}</p>
                    @else
                        <p class="mt-1 text-xs text-slate-500">Gunakan nama lengkap agar akun mudah dikenali.</p>
                    @enderror

                    <label for="role_id" class="mt-4 block text-sm font-medium">Role</label>
                    <select id="role_id" name="role_id" class="field mt-1.5 @error('role_id') border-lost @enderror">
                        <option value="">Pilih role</option>
                        @foreach ($pilihanRole as $role)
                            <option value="{{ $role->id }}" @selected(old('role_id') == $role->id)>{{ $role->name }}</option>
                        @endforeach
                    </select>
                    @error('role_id') <p class="mt-1 text-sm text-lost">{{ $message }}</p> @enderror

                    <div class="mt-5 flex items-start gap-3 rounded-lg bg-tint px-4 py-3 text-brand-dark">
                        <x-icon name="shield-check" class="mt-0.5 size-5 shrink-0" />
                        <div class="text-sm">
                            <div class="font-semibold">NIP dan password dibuat oleh sistem</div>
                            <p class="text-slate-600">NIP dan password sementara akan muncul setelah akun berhasil dibuat. Anda tidak perlu mengisinya.</p>
                        </div>
                    </div>

                    <div class="mt-6 flex flex-col-reverse gap-3 border-t pt-5 sm:flex-row sm:justify-end">
                        <button type="button" @click="modal = ''" class="btn-outline">Batal</button>
                        <button type="submit" class="btn-primary">
                            <x-icon name="user-plus" class="size-5" /> Tambah Akun
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- popup NIP + password sementara (tampil sekali) --}}
    @if (session('kredensial'))
        <div x-show="modal === 'kredensial'" x-cloak x-transition.opacity
             class="fixed inset-0 z-50 overflow-y-auto bg-slate-900/50 p-4" role="dialog" aria-modal="true">
            <div class="flex min-h-full items-center justify-center">
                <div class="card w-full max-w-lg p-5 sm:p-6">
                    <div class="flex items-center gap-4">
                        <div class="flex size-12 shrink-0 items-center justify-center rounded-lg bg-won-tint text-won">
                            <x-icon name="check" class="size-6" />
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold">{{ session('kredensial')['judul'] }}</h2>
                            <p class="text-sm text-slate-500">Serahkan kredensial dengan aman.</p>
                        </div>
                    </div>

                    <div class="mt-5 flex items-start gap-3 rounded-lg bg-warn-tint px-4 py-3 text-warn">
                        <x-icon name="exclamation-triangle" class="mt-0.5 size-5 shrink-0" />
                        <div class="text-sm">
                            <div class="font-semibold">Password sementara hanya tampil satu kali</div>
                            <p>Salin sekarang. Setelah halaman ini ditinggalkan atau dimuat ulang, password sementara tidak dapat ditampilkan lagi.</p>
                        </div>
                    </div>

                    <div class="mt-5 space-y-4">
                        <div>
                            <div class="text-xs text-slate-500">NIP</div>
                            <div class="mt-1 flex items-center justify-between gap-3 rounded-lg border bg-thead px-4 py-3">
                                <span class="min-w-0 break-all font-mono text-lg">{{ session('kredensial')['nip'] }}</span>
                                <button type="button"
                                        x-data="{ ok: false }"
                                        @click="copyText(@js(session('kredensial')['nip'])); ok = true; setTimeout(() => ok = false, 1500)"
                                        class="copy-chip shrink-0 border bg-white">
                                    <x-icon name="copy" class="size-4" />
                                    <span x-text="ok ? 'Tersalin' : 'Copy NIP'">Copy NIP</span>
                                </button>
                            </div>
                        </div>
                        <div>
                            <div class="text-xs text-slate-500">Password Sementara</div>
                            <div class="mt-1 flex items-center justify-between gap-3 rounded-lg border bg-thead px-4 py-3">
                                <span class="min-w-0 break-all font-mono text-lg">{{ session('kredensial')['password'] }}</span>
                                <button type="button"
                                        x-data="{ ok: false }"
                                        @click="copyText(@js(session('kredensial')['password'])); ok = true; setTimeout(() => ok = false, 1500)"
                                        class="copy-chip shrink-0 border bg-white">
                                    <x-icon name="copy" class="size-4" />
                                    <span x-text="ok ? 'Tersalin' : 'Copy Password'">Copy Password</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <p class="mt-5 text-sm text-slate-500">Serahkan kredensial melalui saluran internal yang aman, hanya kepada pengguna yang bersangkutan.</p>
                    <p class="mt-1 text-sm font-medium">Pengguna wajib mengganti password saat login berikutnya.</p>

                    <div class="mt-6 flex justify-end border-t pt-5">
                        <button type="button" @click="modal = ''" class="btn-primary w-full sm:w-auto">
                            <x-icon name="check" class="size-5" /> Selesai
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection