<?php

namespace Database\Seeders;

use App\Models\Batch;
use Illuminate\Database\Seeder;

class BatchSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            ['nama' => 'BCH1', 'is_active' => true],
            ['nama' => 'BCH2', 'is_active' => false],
            ['nama' => 'BCH3', 'is_active' => true],
            ['nama' => 'BCH4', 'is_active' => true],
        ] as $data) {
            Batch::updateOrCreate(['nama' => $data['nama']], $data);
        }
    }
}