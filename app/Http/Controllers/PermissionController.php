<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        return view('permissions.index', [
            'permissions' => Permission::orderBy('id')->get(),
        ]);
    }
}
