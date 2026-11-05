<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'is_active', 'waktu_mulai', 'bobot_awal', 'bobot_aktif', 'progres'];

    protected $casts = [
    'is_active'   => 'boolean',
    'waktu_mulai' => 'datetime',
    'bobot_awal'  => 'float',
    'bobot_aktif' => 'float',
    'progres'     => 'integer',
    ];

    public function getWaktuMulaiLabelAttribute(): string
{
    if (! $this->waktu_mulai) {
        return '--/--/---- Pukul --.-- WIB';
    }

    $waktu = $this->waktu_mulai->copy()->timezone('Asia/Jakarta');

    return $waktu->format('d/m/Y') . ' Pukul ' . $waktu->format('H.i') . ' WIB';
}

public function getBobotAwalLabelAttribute(): string
{
    return $this->formatKg($this->bobot_awal);
}

public function getBobotAktifLabelAttribute(): string
{
    if ($this->bobot_aktif === null && $this->is_active) {
        return 'Menunggu...';
    }

    return $this->formatKg($this->bobot_aktif);
}

private function formatKg(?float $nilai): string
{
    if ($nilai === null) {
        return '-';
    }

    return rtrim(rtrim(number_format($nilai, 2, ',', ''), '0'), ',') . ' Kg';
}
}