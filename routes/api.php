<?php

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

    $reading = SensorReading::create([
        'kode_perangkat' => $validated['kode_perangkat'],
        'suhu' => $validated['suhu'],
        'kelembaban' => $validated['kelembaban'],
        'heater' => $validated['heater'] ?? false,
        'kipas' => $validated['kipas'] ?? false,
    ]);

    return response()->json([
        'status' => 'ok',
        'data' => $reading,
    ], 201);
});