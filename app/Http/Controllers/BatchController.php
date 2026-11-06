<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BatchController extends Controller
{
    public function index(): View
    {
        $batches = Batch::orderBy('nama')->get();

        return view('batches.index', compact('batches'));
    }

    public function show(Batch $batch): View
    {
        return view('batches.show', compact('batch'));
    }

    public function store(Request $request): RedirectResponse
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
            // Dikosongkan: batch aktif dianggap mulai sekarang, batch non aktif belum punya waktu.
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

    /**
     * Mengaktifkan / menonaktifkan batch (bolak-balik).
     * Data pengeringan (waktu mulai, bobot, progres) tidak dihapus.
     */
    public function toggleStatus(Batch $batch): RedirectResponse
    {
        $aktifkan = ! $batch->is_active;

        $batch->is_active = $aktifkan;

        // Batch yang baru pertama kali diaktifkan dianggap mulai pengeringan sekarang.
        if ($aktifkan && $batch->waktu_mulai === null) {
            $batch->waktu_mulai = now();
        }

        $batch->save();

        return back()->with(
            'success',
            'Batch ' . $batch->nama . ($aktifkan ? ' berhasil diaktifkan.' : ' berhasil dinonaktifkan.')
        );
    }

    public function destroy(Batch $batch): RedirectResponse
    {
        $nama = $batch->nama;

        $batch->delete();

        return redirect()->route('batches.index')
            ->with('success', 'Batch ' . $nama . ' berhasil dihapus.');
    }
}
