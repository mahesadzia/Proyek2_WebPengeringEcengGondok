<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('drying_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('batch_id')->constrained()->cascadeOnDelete();
            $table->dateTime('waktu_mulai');
            $table->decimal('bobot_awal', 8, 2);
            $table->decimal('bobot_akhir', 8, 2)->nullable();
            $table->unsignedTinyInteger('progres')->default(0); // 0 - 100
            $table->enum('status', ['berjalan', 'selesai'])->default('berjalan');
            $table->timestamps();

            $table->index(['batch_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('drying_sessions');
    }
};