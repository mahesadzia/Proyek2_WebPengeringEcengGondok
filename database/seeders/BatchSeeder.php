<?php

namespace Database\Seeders;

use App\Models\Batch;
use Illuminate\Database\Seeder;

/**
 * Data contoh untuk melihat gambaran sistem saat sudah berjalan.
 * Waktu mulai dihitung relatif dari "sekarang", jadi durasi berjalan selalu terlihat realistis.
 * Aman dijalankan berulang kali (updateOrCreate berdasarkan nama batch).
 */
class BatchSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            // Aktif, hampir selesai
            ['nama' => 'BCH1', 'is_active' => true,  'waktu_mulai' => now()->subDays(2)->subHours(3),  'bobot_awal' => 5.00, 'bobot_aktif' => 1.85, 'progres' => 90],
            // Non aktif, belum pernah dipakai
            ['nama' => 'BCH2', 'is_active' => false, 'waktu_mulai' => null,                            'bobot_awal' => null, 'bobot_aktif' => null, 'progres' => 0],
            // Aktif, setengah jalan lebih
            ['nama' => 'BCH3', 'is_active' => true,  'waktu_mulai' => now()->subDay()->subHours(8),    'bobot_awal' => 8.00, 'bobot_aktif' => 4.30, 'progres' => 65],
            // Aktif, baru beberapa jam
            ['nama' => 'BCH4', 'is_active' => true,  'waktu_mulai' => now()->subHours(5),              'bobot_awal' => 6.50, 'bobot_aktif' => 5.40, 'progres' => 25],
            // Aktif, baru dimulai
            ['nama' => 'BCH5', 'is_active' => true,  'waktu_mulai' => now()->subMinutes(20),           'bobot_awal' => 7.00, 'bobot_aktif' => 6.95, 'progres' => 2],
            // Aktif, sudah 100% (tinggal dinonaktifkan)
            ['nama' => 'BCH6', 'is_active' => true,  'waktu_mulai' => now()->subDays(3),               'bobot_awal' => 6.00, 'bobot_aktif' => 1.60, 'progres' => 100],
            // Non aktif, batch lama yang sudah selesai
            ['nama' => 'BCH7', 'is_active' => false, 'waktu_mulai' => now()->subDays(6),               'bobot_awal' => 5.00, 'bobot_aktif' => 1.40, 'progres' => 100],
            // Non aktif, baru dibuat dan belum diisi
            ['nama' => 'BCH8', 'is_active' => false, 'waktu_mulai' => null,                            'bobot_awal' => null, 'bobot_aktif' => null, 'progres' => 0],
        ];

        foreach ($data as $item) {
            Batch::updateOrCreate(['nama' => $item['nama']], $item);
        }
    }
}