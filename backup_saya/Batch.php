<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Batch extends Model
{
    protected $fillable = ['nama'];

    public function dryingSessions(): HasMany
    {
        return $this->hasMany(DryingSession::class);
    }

    /** Sesi pengeringan yang sedang berjalan (terbaru). */
    public function activeSession(): HasOne
    {
        return $this->hasOne(DryingSession::class)
            ->where('status', 'berjalan')
            ->latestOfMany();
    }
}