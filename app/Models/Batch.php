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

    public function getStatusLabelAttribute(): string
    {
        return $this->is_active ? 'Aktif' : 'Non Aktif';
    }

    /** Contoh: "18/10/2026 Pukul 12.45 WIB" */
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

    /** Lama batch berjalan, contoh: "2 hari 3 jam". Hanya untuk batch aktif. */
    public function getDurasiLabelAttribute(): string
    {
        if (! $this->is_active || ! $this->waktu_mulai) {
            return '-';
        }

        if ($this->waktu_mulai->isFuture()) {
            return 'Belum dimulai';
        }

        $menit = (int) floor($this->waktu_mulai->diffInMinutes(now(), true));
        $hari  = intdiv($menit, 1440);
        $jam   = intdiv($menit % 1440, 60);
        $sisa  = $menit % 60;

        if ($hari > 0) {
            return "{$hari} hari {$jam} jam";
        }

        return $jam > 0 ? "{$jam} jam {$sisa} menit" : "{$sisa} menit";
    }

    /** Selisih bobot awal dan bobot aktif, contoh: "1,8 Kg (36,0%)". */
    public function getSusutBobotLabelAttribute(): string
    {
        if ($this->bobot_awal === null || $this->bobot_aktif === null || $this->bobot_awal <= 0) {
            return '-';
        }

        $susut  = max($this->bobot_awal - $this->bobot_aktif, 0);
        $persen = $susut / $this->bobot_awal * 100;

        return $this->formatKg($susut) . ' (' . number_format($persen, 1, ',', '') . '%)';
    }

    private function formatKg(?float $nilai): string
    {
        if ($nilai === null) {
            return '-';
        }

        return rtrim(rtrim(number_format($nilai, 2, ',', ''), '0'), ',') . ' Kg';
    }
}