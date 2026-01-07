<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('penugasan_penilaian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('periode_id')->constrained('periode_akademik');
            $table->foreignId('penilai_id')->constrained('penilai');
            $table->foreignId('guru_id')->constrained('guru');
            $table->enum('status', ['pending', 'selesai'])->default('pending');
            $table->timestamp('dibuat_pada')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penugasan_penilaian');
    }
};
