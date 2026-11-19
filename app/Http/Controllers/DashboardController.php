<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\SensorReading;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        // Urut alami: BCH1, BCH2, ..., BCH10
        $batches = Batch::all()->sortBy('nama', SORT_NATURAL)->values();
        $aktif   = $batches->where('is_active', true);

        $ringkasan = [
            'total'    => $batches->count(),
            'aktif'    => $aktif->count(),
            'nonaktif' => $batches->count() - $aktif->count(),
            'selesai'  => $aktif->where('progres', '>=', 100)->count(),
            'rata'     => $aktif->isNotEmpty() ? (int) round($aktif->avg('progres')) : 0,
        ];

        // Batch aktif dengan progres 90% ke atas, yang paling selesai di urutan pertama
        $perhatian = $aktif->filter(fn (Batch $b) => $b->progres >= 90)
            ->sortByDesc('progres')
            ->values();

        // Pembacaan sensor terbaru & riwayat terakhir dari ESP32
        $latestSensor  = SensorReading::latest()->first();
        $recentSensors = SensorReading::latest()->take(10)->get();

        return view('dashboard.index', compact(
            'batches',
            'ringkasan',
            'perhatian',
            'latestSensor',
            'recentSensors'
        ));
    }
}