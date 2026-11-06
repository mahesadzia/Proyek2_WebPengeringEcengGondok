<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BatchController extends Controller
{
    public function index()
    {
        $batches = Batch::orderBy('nama')->get();

        return view('batches.index', compact('batches'));
    }

    public function show(Batch $batch)
    {
    return view('batches.show', compact('batch'));
    }
    
    public function store(Request $request)
    {
        // Nama dibuat huruf kapital dan spasi di pinggir dibuang
        $request->merge(['nama' => strtoupper(trim((string) $request->input('nama')))]);

        // Kalau gagal validasi, error disimpan dengan nama "tambahBatch"
        $request->validateWithBag('tambahBatch', [
            'nama'        => ['required', 'string', 'max:50', 'unique:batches,nama'],
            'waktu_mulai' => ['nullable', 'date'],
        ], [
            'nama.required'    => 'Nama batch wajib diisi.',
            'nama.max'         => 'Nama batch maksimal 50 karakter.',
            'nama.unique'      => 'Nama batch sudah dipakai.',
            'waktu_mulai.date' => 'Format waktu mulai tidak valid.',
        ]);

        $aktif = $request->boolean('is_active');

                if ($request->filled('waktu_mulai')) {
            $waktuMulai = Carbon::parse($request->input('waktu_mulai'), 'Asia/Jakarta')
                ->setTimezone(config('app.timezone'));
        } else {
            // Kalau dikosongkan: batch aktif dianggap mulai sekarang, batch non aktif belum punya waktu.
            $waktuMulai = $aktif ? now() : null;
        }

        Batch::create([
            'nama'        => $request->input('nama'),
            'is_active'   => $aktif,
            'waktu_mulai' => $waktuMulai,
        ]);

        return redirect()->route('batches.index')
            ->with('success', 'Batch ' . $request->input('nama') . ' berhasil ditambahkan.');
    }
}