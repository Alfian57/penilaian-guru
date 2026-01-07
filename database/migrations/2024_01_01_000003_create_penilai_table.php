<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('penilai', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengguna_id')->constrained('pengguna')->onDelete('cascade');
            $table->enum('jenis_penilai', ['atasan', 'sejawat', 'siswa']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penilai');
    }
};
