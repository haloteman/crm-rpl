<?php

namespace App\Http\Controllers;

use App\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        return view('roles.index', [
            'roles' => Role::with('permissions')->orderBy('id')->get(),
        ]);
    }
}
