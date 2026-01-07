<?php

namespace Database\Seeders;

use App\Enums\JenisPenilai;
use App\Enums\Peran;
use App\Models\Guru;
use App\Models\Pengguna;
use App\Models\Penilai;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PenggunaSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin
        Pengguna::create([
            'password' => Hash::make('password'),
            'nama_lengkap' => 'Administrator Sistem',
            'email' => 'admin@smpn1contoh.sch.id',
            'peran' => Peran::ADMIN,
        ]);

        // Create Kepala Sekolah
        $kepsek = Pengguna::create([
            'password' => Hash::make('password'),
            'nama_lengkap' => 'Dr. H. Ahmad Sudrajat, M.Pd.',
            'email' => 'kepsek@smpn1contoh.sch.id',
            'peran' => Peran::KEPSEK,
        ]);

        Penilai::create([
            'pengguna_id' => $kepsek->id,
            'jenis_penilai' => JenisPenilai::ATASAN,
        ]);

        // Create Guru
        $guruData = [
            ['nama' => 'Dra. Siti Rahayu, M.Pd.', 'nip' => '196805151994032008', 'mapel' => 'Bahasa Indonesia', 'email' => 'siti.rahayu'],
            ['nama' => 'Ir. Bambang Wijaya, S.Pd.', 'nip' => '197203121998011003', 'mapel' => 'Matematika', 'email' => 'bambang.wijaya'],
            ['nama' => 'Hj. Nurhasanah, S.Pd.', 'nip' => '198001242005012006', 'mapel' => 'Bahasa Inggris', 'email' => 'nurhasanah'],
            ['nama' => 'Ahmad Fauzi, S.Pd., M.Si.', 'nip' => '198506172010011015', 'mapel' => 'IPA Fisika', 'email' => 'ahmad.fauzi'],
            ['nama' => 'Dewi Kartika Sari, S.Pd.', 'nip' => '199002032014022003', 'mapel' => 'IPA Biologi', 'email' => 'dewi.kartika'],
            ['nama' => 'Eko Prasetyo, S.Pd.', 'nip' => '198712252012011009', 'mapel' => 'IPS Sejarah', 'email' => 'eko.prasetyo'],
            ['nama' => 'Ratna Kusumawati, S.Pd.', 'nip' => '199108172015022001', 'mapel' => 'IPS Geografi', 'email' => 'ratna.kusuma'],
            ['nama' => 'Muhammad Rizki, S.Pd.', 'nip' => '199205122016011004', 'mapel' => 'Pendidikan Agama Islam', 'email' => 'muh.rizki'],
            ['nama' => 'Indah Permatasari, S.Pd.', 'nip' => '199307222017022002', 'mapel' => 'Seni Budaya', 'email' => 'indah.permata'],
            ['nama' => 'Agus Hermawan, S.Pd.', 'nip' => '198809142013011005', 'mapel' => 'Pendidikan Jasmani', 'email' => 'agus.hermawan'],
            ['nama' => 'Sri Wahyuni, S.Pd.', 'nip' => null, 'mapel' => 'Prakarya', 'email' => 'sri.wahyuni'],
            ['nama' => 'Budi Santoso, S.Kom.', 'nip' => null, 'mapel' => 'Informatika', 'email' => 'budi.santoso'],
        ];

        $firstGuru = null;
        foreach ($guruData as $index => $data) {
            $pengguna = Pengguna::create([
                'password' => Hash::make('password'),
                'nama_lengkap' => $data['nama'],
                'email' => $data['email'] . '@smpn1contoh.sch.id',
                'peran' => Peran::GURU,
            ]);

            $guru = Guru::create([
                'pengguna_id' => $pengguna->id,
                'nip' => $data['nip'],
                'mata_pelajaran' => $data['mapel'],
            ]);

            if ($index === 0) {
                $firstGuru = $guru;
            }
        }

        // Create Wakasek as Penilai (first guru)
        if ($firstGuru) {
            Penilai::create([
                'pengguna_id' => $firstGuru->pengguna_id,
                'jenis_penilai' => JenisPenilai::SEJAWAT,
            ]);
        }

        // Create Siswa
        $siswaData = [
            ['nama' => 'Andi Pratama'],
            ['nama' => 'Bintang Ramadhan'],
            ['nama' => 'Citra Dewi'],
            ['nama' => 'Dimas Aditya'],
            ['nama' => 'Eka Putri Maharani'],
        ];

        foreach ($siswaData as $index => $data) {
            $pengguna = Pengguna::create([
                'password' => Hash::make('password'),
                'nama_lengkap' => $data['nama'],
                'email' => 'siswa' . ($index + 1) . '@smpn1contoh.sch.id',
                'peran' => Peran::SISWA,
            ]);

            Penilai::create([
                'pengguna_id' => $pengguna->id,
                'jenis_penilai' => JenisPenilai::SISWA,
            ]);
        }
    }
}
