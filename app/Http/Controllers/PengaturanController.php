<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PengaturanController extends Controller
{
    public function index()
    {
        return view('pengaturan');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'password' => 'nullable|string|min:8',
        ], [
            'name.required' => 'Nama pengguna wajib diisi.',
            'name.max'      => 'Nama pengguna maksimal 255 karakter.',
            'password.min'  => 'Password baru minimal 8 karakter.',
        ]);

        $user = auth()->user();

        $user->name = $request->name;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()
            ->route('pengaturan.index')
            ->with('success', 'Profil berhasil diperbarui!');
    }
}
