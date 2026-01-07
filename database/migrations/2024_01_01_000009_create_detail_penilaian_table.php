<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('detail_penilaian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hasil_id')->constrained('hasil_penilaian')->onDelete('cascade');
            $table->foreignId('indikator_id')->constrained('indikator');
            $table->integer('nilai');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_penilaian');
    }
};
