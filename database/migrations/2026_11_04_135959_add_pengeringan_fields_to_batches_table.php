<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use Illuminate\Http\Request;

class BatchController extends Controller
{
    public function index()
    {
        $batches = Batch::orderBy('nama')->get();

        return view('batches.index', compact('batches'));
    }

    public function store(Request $request)
    {
        // Nama dibuat huruf kapital dan spasi di pinggir dibuang
        $request->merge(['nama' => strtoupper(trim((string) $request->input('nama')))]);

        // Kalau gagal validasi, error disimpan dengan nama "tambahBatch"
        $request->validateWithBag('tambahBatch', [
            'nama' => ['required', 'string', 'max:50', 'unique:batches,nama'],
        ], [
            'nama.required' => 'Nama batch wajib diisi.',
            'nama.max'      => 'Nama batch maksimal 50 karakter.',
            'nama.unique'   => 'Nama batch sudah dipakai.',
        ]);

        Batch::create([
            'nama'      => $request->input('nama'),
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('batches.index')
            ->with('success', 'Batch ' . $request->input('nama') . ' berhasil ditambahkan.');
    }
}