<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DryingSession extends Model
{
    protected $fillable = [
        'batch_id', 'waktu_mulai', 'bobot_awal', 'bobot_akhir', 'progres', 'status',
    ];

    protected $casts = [
        'waktu_mulai' => 'datetime',
        'bobot_awal'  => 'decimal:2',
        'bobot_akhir' => 'decimal:2',
        'progres'     => 'integer',
    ];

    public function batch(): BelongsTo
    {
        return $this->belongsTo(Batch::class);
    }
}