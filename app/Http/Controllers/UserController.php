<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Services\CredentialService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('roles')->orderBy('name');

        if ($request->filled('cari')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%'.$request->cari.'%')
                    ->orWhere('nip', 'like', '%'.$request->cari.'%');
            });
        }

        if ($request->filled('role')) {
            $query->whereRelation('roles', 'roles.id', $request->role);
        }

        // biar password sementara nggak kesimpen di cache browser
        return response()
            ->view('users.index', [
                'users' => $query->paginate(10)->withQueryString(),
                'totalAkun' => User::count(),
                'semuaRole' => Role::orderBy('id')->get(),
                'pilihanRole' => $this->pilihanRole(),
            ])
            ->header('Cache-Control', 'no-store');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:100',
            'role_id' => ['required', Rule::in($this->pilihanRole()->pluck('id'))],
        ], [
            'name.required' => 'Nama lengkap wajib diisi',
            'name.max' => 'Nama lengkap maksimal 100 karakter',
            'role_id.required' => 'Role wajib dipilih',
            'role_id.in' => 'Role tidak tersedia',
        ]);

        $password = CredentialService::generatePassword();

        $user = User::create([
            'name' => $request->name,
            'nip' => CredentialService::generateNip(),
            'password' => $password,
            'must_change_password' => true,
        ]);

        $user->assignRole(Role::findById($request->role_id));

        return redirect()->route('users.index')->with('kredensial', [
            'judul' => 'Akun Berhasil Dibuat',
            'nip' => $user->nip,
            'password' => $password,
        ]);
    }

    public function resetPassword(User $user)
    {
        if (! auth()->user()->canResetPassword($user)) {
            abort(403);
        }

        $password = CredentialService::generatePassword();

        $user->update([
            'password' => $password,
            'must_change_password' => true,
        ]);

        return redirect()->route('users.index')->with('kredensial', [
            'judul' => 'Password Berhasil Direset',
            'nip' => $user->nip,
            'password' => $password,
        ]);
    }

    public function destroy(User $user)
    {
        if (! auth()->user()->canDelete($user)) {
            abort(403);
        }

        $user->delete();

        return redirect()->route('users.index')->with('status', 'Akun '.$user->name.' berhasil dihapus');
    }

    private function pilihanRole()
    {
        $pilihan = [Role::ADMIN, Role::KEPALA_STAF_DESIGN, Role::DESAINER];

        $sudahAdaSuperAdmin = User::role(Role::SUPER_ADMIN)->exists();

        if (auth()->user()->hasRole(Role::OWNER) && ! $sudahAdaSuperAdmin) {
            $pilihan[] = Role::SUPER_ADMIN;
        }

        return Role::whereIn('name', $pilihan)->orderBy('id')->get();
    }
}
