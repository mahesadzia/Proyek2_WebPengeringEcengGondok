<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SensorReading extends Model
{
    protected $fillable = [
        'kode_perangkat',
        'suhu',
        'kelembaban',
        'heater',
        'kipas',
    ];

    protected function casts(): array
    {
        return [
            'suhu' => 'float',
            'kelembaban' => 'float',
            'heater' => 'boolean',
            'kipas' => 'boolean',
        ];
    }
}