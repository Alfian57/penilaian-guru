<?php

namespace Database\Seeders;

use App\Models\PeriodeAkademik;
use Illuminate\Database\Seeder;

class PeriodeSeeder extends Seeder
{
    public function run(): void
    {
        PeriodeAkademik::create([
            'nama_periode' => 'Semester Ganjil 2023/2024',
            'tanggal_mulai' => '2023-07-17',
            'tanggal_selesai' => '2023-12-22',
            'status_aktif' => false,
        ]);

        PeriodeAkademik::create([
            'nama_periode' => 'Semester Genap 2023/2024',
            'tanggal_mulai' => '2024-01-08',
            'tanggal_selesai' => '2024-06-21',
            'status_aktif' => false,
        ]);

        PeriodeAkademik::create([
            'nama_periode' => 'Semester Ganjil 2024/2025',
            'tanggal_mulai' => '2024-07-15',
            'tanggal_selesai' => '2024-12-20',
            'status_aktif' => true,
        ]);
    }
}
