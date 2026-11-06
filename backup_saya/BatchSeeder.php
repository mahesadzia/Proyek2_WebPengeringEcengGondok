<?php

namespace Database\Seeders;

use App\Models\Batch;
use Illuminate\Database\Seeder;

class BatchSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            'BCH1' => ['bobot_awal' => 5, 'progres' => 90],
            'BCH2' => null, // Non Aktif
            'BCH3' => ['bobot_awal' => 8, 'progres' => 90],
            'BCH4' => ['bobot_awal' => 5, 'progres' => 50],
        ];

        foreach ($data as $nama => $sesi) {
            $batch = Batch::firstOrCreate(['nama' => $nama]);

            if ($sesi) {
                $batch->dryingSessions()->firstOrCreate(
                    ['status' => 'berjalan'],
                    $sesi + ['waktu_mulai' => '2026-10-16 12:45:00']
                );
            }
        }
    }
}