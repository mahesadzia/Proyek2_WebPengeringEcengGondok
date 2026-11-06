<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan kolom pengeringan yang belum ada di tabel batches.
     * Aman dijalankan di database yang sudah punya sebagian atau seluruh kolom ini.
     */
    public function up(): void
    {
        Schema::table('batches', function (Blueprint $table) {
            if (! Schema::hasColumn('batches', 'waktu_mulai')) {
                $table->timestamp('waktu_mulai')->nullable();
            }
            if (! Schema::hasColumn('batches', 'bobot_awal')) {
                $table->decimal('bobot_awal', 6, 2)->nullable();
            }
            if (! Schema::hasColumn('batches', 'bobot_aktif')) {
                $table->decimal('bobot_aktif', 6, 2)->nullable();
            }
            if (! Schema::hasColumn('batches', 'progres')) {
                $table->unsignedTinyInteger('progres')->default(0);
            }
        });
    }

    public function down(): void
    {
        // Sengaja kosong: kolom-kolom ini juga dikelola oleh migration sebelumnya.
    }
};
