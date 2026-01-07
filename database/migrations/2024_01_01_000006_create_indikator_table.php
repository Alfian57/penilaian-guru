<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('indikator', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kriteria_id')->constrained('kriteria')->onDelete('cascade');
            $table->text('pertanyaan');
            $table->integer('skala_maksimal')->default(5);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('indikator');
    }
};
