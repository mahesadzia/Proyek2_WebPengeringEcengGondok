<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
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
        Schema::table('batches', function (Blueprint $table) {
            $table->dropColumn(['waktu_mulai', 'bobot_awal', 'bobot_aktif', 'progres']);
        });
    }
};
