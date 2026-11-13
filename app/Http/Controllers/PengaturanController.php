<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PengaturanController extends Controller
{
    public function index()
    {
        return view('pengaturan');
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        // Email disimpan huruf kecil dan tanpa spasi di pinggir
        $request->merge(['email' => strtolower(trim((string) $request->input('email')))]);

        $emailBerubah = $request->input('email') !== strtolower($user->email);

        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8'],
            // Mengganti email untuk login wajib memasukkan password saat ini
            'password_sekarang' => $emailBerubah ? ['required', 'current_password'] : ['nullable'],
        ], [
            'name.required'                  => 'Nama pengguna wajib diisi.',
            'name.max'                       => 'Nama pengguna maksimal 255 karakter.',
            'email.required'                 => 'Email wajib diisi.',
            'email.email'                    => 'Format email tidak valid.',
            'email.max'                      => 'Email maksimal 255 karakter.',
            'email.unique'                   => 'Email sudah dipakai akun lain.',
            'password.min'                   => 'Password baru minimal 8 karakter.',
            'password_sekarang.required'     => 'Masukkan password saat ini untuk mengganti email.',
            'password_sekarang.current_password' => 'Password saat ini salah.',
        ]);

        $user->name  = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()
            ->route('pengaturan.index')
            ->with('success', $emailBerubah
                ? 'Profil diperbarui. Gunakan email baru untuk masuk berikutnya.'
                : 'Profil berhasil diperbarui!');
    }
}
