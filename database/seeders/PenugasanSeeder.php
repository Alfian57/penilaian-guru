<?php

namespace Database\Seeders;

use App\Enums\JenisPenilai;
use App\Models\Guru;
use App\Models\Penilai;
use App\Models\PeriodeAkademik;
use App\Models\PenugasanPenilaian;
use App\Models\HasilPenilaian;
use App\Models\DetailPenilaian;
use App\Models\Kriteria;
use App\Models\Indikator;
use Illuminate\Database\Seeder;

class PenugasanSeeder extends Seeder
{
    public function run(): void
    {
        $periodeAktif = PeriodeAkademik::where('status_aktif', true)->first();
        $periodeLalu = PeriodeAkademik::where('status_aktif', false)
            ->orderByDesc('tanggal_selesai')
            ->first();

        if (!$periodeAktif) {
            return;
        }

        $guruList = Guru::all();
        $penilaiKepsek = Penilai::where('jenis_penilai', JenisPenilai::ATASAN)->first();
        $penilaiSejawat = Penilai::where('jenis_penilai', JenisPenilai::SEJAWAT)->first();
        $siswaPenilai = Penilai::where('jenis_penilai', JenisPenilai::SISWA)->get();
        $allIndikator = Indikator::all();
        $kriteriaModels = Kriteria::all()->keyBy('id');

        foreach ($guruList as $guru) {
            // Assign kepsek to evaluate all teachers
            PenugasanPenilaian::create([
                'penilai_id' => $penilaiKepsek->id,
                'guru_id' => $guru->id,
                'periode_id' => $periodeAktif->id,
            ]);

            // Assign sejawat to evaluate all teachers (except herself)
            if ($penilaiSejawat && $penilaiSejawat->pengguna_id !== $guru->pengguna_id) {
                PenugasanPenilaian::create([
                    'penilai_id' => $penilaiSejawat->id,
                    'guru_id' => $guru->id,
                    'periode_id' => $periodeAktif->id,
                ]);
            }

            // Assign 2 random students to evaluate each teacher
            $randomSiswa = $siswaPenilai->random(2);
            foreach ($randomSiswa as $siswa) {
                PenugasanPenilaian::create([
                    'penilai_id' => $siswa->id,
                    'guru_id' => $guru->id,
                    'periode_id' => $periodeAktif->id,
                ]);
            }
        }

        // Create completed penilaian for previous periode
        if ($periodeLalu) {
            foreach ($guruList as $index => $guru) {
                $penugasanKepsek = PenugasanPenilaian::create([
                    'penilai_id' => $penilaiKepsek->id,
                    'guru_id' => $guru->id,
                    'periode_id' => $periodeLalu->id,
                ]);

                $totalNilai = 0;

                $hasilPenilaian = HasilPenilaian::create([
                    'penugasan_id' => $penugasanKepsek->id,
                    'waktu_submit' => $periodeLalu->tanggal_selesai,
                    'total_skor' => 0,
                    'saran_masukan' => $this->generateKomentar(),
                ]);

                foreach ($allIndikator as $indikator) {
                    $baseScore = rand(3, 5);
                    if (rand(1, 10) <= 2) {
                        $baseScore = rand(2, 3);
                    }

                    DetailPenilaian::create([
                        'hasil_id' => $hasilPenilaian->id,
                        'indikator_id' => $indikator->id,
                        'nilai' => $baseScore,
                    ]);

                    $kriteria = $kriteriaModels[$indikator->kriteria_id];
                    $nilaiPersen = ($baseScore / $indikator->skala_maksimal) * 100;
                    $totalNilai += $nilaiPersen * ($kriteria->bobot_persen / 100);
                }

                $avgNilai = $totalNilai / count($kriteriaModels);
                $hasilPenilaian->update(['total_skor' => $avgNilai]);
            }
        }

        // Create some completed penilaian for current periode (partial)
        $completedCount = 5;
        foreach ($guruList as $index => $guru) {
            if ($index >= $completedCount) {
                break;
            }

            $penugasan = PenugasanPenilaian::where('guru_id', $guru->id)
                ->where('periode_id', $periodeAktif->id)
                ->first();

            if (!$penugasan) {
                continue;
            }

            $totalNilai = 0;

            $hasilPenilaian = HasilPenilaian::create([
                'penugasan_id' => $penugasan->id,
                'waktu_submit' => now()->subDays(rand(1, 14)),
                'total_skor' => 0,
                'saran_masukan' => $this->generateKomentar(),
            ]);

            foreach ($allIndikator as $indikator) {
                $baseScore = rand(3, 5);
                if (rand(1, 10) <= 2) {
                    $baseScore = rand(2, 3);
                }

                DetailPenilaian::create([
                    'hasil_id' => $hasilPenilaian->id,
                    'indikator_id' => $indikator->id,
                    'nilai' => $baseScore,
                ]);

                $kriteria = $kriteriaModels[$indikator->kriteria_id];
                $nilaiPersen = ($baseScore / $indikator->skala_maksimal) * 100;
                $totalNilai += $nilaiPersen * ($kriteria->bobot_persen / 100);
            }

            $avgNilai = $totalNilai / count($kriteriaModels);
            $hasilPenilaian->update(['total_skor' => $avgNilai]);
        }
    }

    private function generateKomentar(): string
    {
        $komentar = [
            'Guru menunjukkan dedikasi yang tinggi dalam mengajar. Terus tingkatkan inovasi pembelajaran.',
            'Performa mengajar baik, namun perlu meningkatkan penggunaan media pembelajaran digital.',
            'Komunikasi dengan siswa sangat baik. Pertahankan sikap ramah dan bersahabat.',
            'Penguasaan materi sangat baik. Disarankan untuk lebih banyak memberikan latihan soal.',
            'Disiplin waktu sangat baik. Tingkatkan variasi metode pembelajaran.',
            'Mampu mengelola kelas dengan baik. Perlu meningkatkan pemberian motivasi kepada siswa.',
            'Pembelajaran berjalan efektif. Tingkatkan penggunaan teknologi dalam pembelajaran.',
            'Menunjukkan profesionalisme yang tinggi. Terus update dengan perkembangan kurikulum terbaru.',
        ];

        return $komentar[array_rand($komentar)];
    }
}
