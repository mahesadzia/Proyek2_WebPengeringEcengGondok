<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SensorReading extends Model
{
    protected $fillable = [
        'batch_id',
        'kode_perangkat',
        'suhu',
        'kelembaban',
        'heater',
        'kipas',
    ];

    protected function casts(): array
    {
        return [
            'batch_id' => 'integer',
            'suhu' => 'float',
            'kelembaban' => 'float',
            'heater' => 'boolean',
            'kipas' => 'boolean',
        ];
    }

    public function batch(): BelongsTo
    {
        return $this->belongsTo(Batch::class);
    }
}