<?php

namespace Database\Seeders;

use App\Models\Kriteria;
use App\Models\Indikator;
use Illuminate\Database\Seeder;

class KriteriaSeeder extends Seeder
{
    public function run(): void
    {
        $kriteriaData = [
            [
                'nama' => 'Pedagogik',
                'bobot' => 40,
                'indikator' => [
                    'Guru menyampaikan materi pembelajaran dengan jelas dan mudah dipahami',
                    'Guru menggunakan metode pembelajaran yang bervariasi dan menarik',
                    'Guru memberikan contoh-contoh yang relevan dengan kehidupan sehari-hari',
                    'Guru mampu mengelola kelas dengan baik dan kondusif',
                    'Guru memberikan umpan balik yang konstruktif terhadap tugas siswa',
                    'Guru memanfaatkan media pembelajaran dengan efektif',
                    'Guru mengakomodasi perbedaan kemampuan belajar siswa',
                    'Guru memberikan motivasi belajar kepada siswa',
                ]
            ],
            [
                'nama' => 'Kepribadian',
                'bobot' => 20,
                'indikator' => [
                    'Guru menunjukkan sikap yang ramah dan bersahabat',
                    'Guru bersikap adil dan tidak pilih kasih terhadap siswa',
                    'Guru hadir tepat waktu dan disiplin',
                    'Guru berpenampilan rapi dan sopan',
                    'Guru menjadi teladan yang baik dalam perilaku',
                ]
            ],
            [
                'nama' => 'Sosial',
                'bobot' => 20,
                'indikator' => [
                    'Guru berkomunikasi dengan baik dengan siswa',
                    'Guru bersedia membantu siswa yang mengalami kesulitan belajar',
                    'Guru menghargai pendapat dan pertanyaan siswa',
                    'Guru mampu menciptakan suasana kelas yang menyenangkan',
                ]
            ],
            [
                'nama' => 'Profesional',
                'bobot' => 20,
                'indikator' => [
                    'Guru menguasai materi pelajaran dengan baik',
                    'Guru mampu menjawab pertanyaan siswa dengan tepat',
                    'Guru mengikuti perkembangan terkini dalam bidang keilmuannya',
                    'Guru memberikan tugas dan latihan yang sesuai dengan materi',
                    'Guru melaksanakan evaluasi pembelajaran secara objektif',
                ]
            ],
        ];

        foreach ($kriteriaData as $kData) {
            $kriteria = Kriteria::create([
                'nama_kriteria' => $kData['nama'],
                'bobot_persen' => $kData['bobot'],
            ]);

            foreach ($kData['indikator'] as $pertanyaan) {
                Indikator::create([
                    'kriteria_id' => $kriteria->id,
                    'pertanyaan' => $pertanyaan,
                    'skala_maksimal' => 5,
                ]);
            }
        }
    }
}
