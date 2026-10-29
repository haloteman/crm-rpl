<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PasswordController extends Controller
{
    public function edit()
    {
        return view('auth.password');
    }

    public function update(Request $request)
    {
        $request->validate([
            'password_lama' => 'required|current_password',
            'password_baru' => ['required', 'min:8', 'regex:/[a-zA-Z]/', 'regex:/[0-9]/', 'confirmed', 'different:password_lama'],
        ], [
            'password_lama.required' => 'Password lama wajib diisi',
            'password_lama.current_password' => 'Password lama salah',
            'password_baru.required' => 'Password baru wajib diisi',
            'password_baru.min' => 'Password baru minimal 8 karakter',
            'password_baru.regex' => 'Password baru harus ada huruf dan angka',
            'password_baru.confirmed' => 'Konfirmasi password tidak sama',
            'password_baru.different' => 'Password baru harus beda dari password lama',
        ]);

        $request->user()->update([
            'password' => $request->password_baru,
            'must_change_password' => false,
        ]);

        return redirect()->route($request->user()->halamanBeranda())->with('status', 'Password berhasil diubah');
    }
}
