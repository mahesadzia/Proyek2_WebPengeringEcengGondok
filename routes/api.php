<?php

use App\Models\Batch;
use App\Models\SensorReading;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/sensor', function (Request $request) {
    $expectedToken = env('IOT_API_TOKEN', '8a0156b97d281272a672b524dfa3ceb5');
    if ($request->header('X-IOT-TOKEN') !== $expectedToken) {
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    $validated = $request->validate([
        'kode_perangkat' => 'required|string',
        'suhu' => 'required|numeric',
        'kelembaban' => 'required|numeric',
        'heater' => 'nullable|boolean',
        'kipas' => 'nullable|boolean',
    ]);

    // Arahkan langsung ke batch 1
    $batchId = Batch::where('id', 1)->value('id') ?? 1;

    $reading = SensorReading::create([
        'batch_id'       => $batchId,
        'kode_perangkat' => $validated['kode_perangkat'],
        'suhu'           => $validated['suhu'],
        'kelembaban'     => $validated['kelembaban'],
        'heater'         => $validated['heater'] ?? false,
        'kipas'          => $validated['kipas'] ?? false,
    ]);

    return response()->json([
        'status' => 'ok',
        'batch_id' => $batchId,
        'data' => $reading,
    ], 201);
});