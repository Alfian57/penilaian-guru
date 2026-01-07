<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('hasil_penilaian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penugasan_id')->constrained('penugasan_penilaian')->onDelete('cascade');
            $table->decimal('total_skor', 8, 2)->default(0);
            $table->text('saran_masukan')->nullable();
            $table->timestamp('waktu_submit')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hasil_penilaian');
    }
};
