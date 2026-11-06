<?php

namespace Database\Seeders;

use App\Models\Batch;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class BatchSeeder extends Seeder
{
    public function run(): void
    {
        $mulai = Carbon::parse('2026-10-18 12:45', 'Asia/Jakarta')
            ->setTimezone(config('app.timezone'));

        $data = [
            ['nama' => 'BCH1', 'is_active' => true,  'waktu_mulai' => $mulai, 'bobot_awal' => 5,    'bobot_aktif' => null, 'progres' => 90],
            ['nama' => 'BCH2', 'is_active' => false, 'waktu_mulai' => null,   'bobot_awal' => null, 'bobot_aktif' => null, 'progres' => 0],
            ['nama' => 'BCH3', 'is_active' => true,  'waktu_mulai' => $mulai, 'bobot_awal' => 5,    'bobot_aktif' => null, 'progres' => 90],
            ['nama' => 'BCH4', 'is_active' => true,  'waktu_mulai' => $mulai, 'bobot_awal' => 5,    'bobot_aktif' => null, 'progres' => 50],
        ];

        foreach ($data as $item) {
            Batch::updateOrCreate(['nama' => $item['nama']], $item);
        }
    }
}