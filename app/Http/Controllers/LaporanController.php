<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\HasilPenilaian;
use App\Models\Kriteria;
use App\Models\PenugasanPenilaian;
use App\Models\PeriodeAkademik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $periodeList = PeriodeAkademik::orderBy('tanggal_mulai', 'desc')->get();
        $selectedPeriode = $request->filled('periode') ? $request->periode : null;

        $query = Guru::with(['pengguna', 'penugasanSebagaiDinilai.hasilPenilaian', 'penugasanSebagaiDinilai.periode']);

        if ($request->filled('search')) {
            $query->whereHas('pengguna', function ($q) use ($request) {
                $q->where('nama_lengkap', 'like', '%' . $request->search . '%');
            });
        }

        $guruList = $query->paginate(15);

        // Calculate statistics
        $totalGuru = Guru::count();

        $hasilQuery = HasilPenilaian::query();
        if ($selectedPeriode) {
            $hasilQuery->whereHas('penugasan', function ($q) use ($selectedPeriode) {
                $q->where('periode_id', $selectedPeriode);
            });
        }

        $allHasil = $hasilQuery->get();
        $totalDinilai = $allHasil->groupBy(function ($h) {
            return $h->penugasan->guru_id;
        })->count();
        $totalBelum = $totalGuru - $totalDinilai;
        $rataRata = $allHasil->count() > 0 ? $allHasil->avg('total_skor') : 0;

        return view('laporan.index', compact(
            'guruList',
            'periodeList',
            'selectedPeriode',
            'totalGuru',
            'totalDinilai',
            'totalBelum',
            'rataRata'
        ));
    }

    public function show(Guru $guru, Request $request)
    {
        $periodeList = PeriodeAkademik::orderBy('tanggal_mulai', 'desc')->get();
        $selectedPeriode = $request->filled('periode') ? $request->periode : null;

        $query = HasilPenilaian::whereHas('penugasan', function ($q) use ($guru) {
            $q->where('guru_id', $guru->id);
        })->with(['penugasan.penilai.pengguna', 'penugasan.periode', 'detailPenilaian.indikator.kriteria']);

        if ($selectedPeriode) {
            $query->whereHas('penugasan', function ($q) use ($selectedPeriode) {
                $q->where('periode_id', $selectedPeriode);
            });
        }

        $hasilPenilaian = $query->orderBy('waktu_submit', 'desc')->get();

        // Calculate average
        $rataRataNilai = $hasilPenilaian->count() > 0 ? $hasilPenilaian->avg('total_skor') : 0;
        $predikat = $this->hitungPredikat($rataRataNilai);

        // Calculate per kriteria
        $kriteria = Kriteria::with('indikator')->get();
        $nilaiPerKriteria = [];

        foreach ($kriteria as $k) {
            $nilaiKriteria = [];

            foreach ($hasilPenilaian as $hasil) {
                $detailKriteria = $hasil->detailPenilaian->filter(function ($d) use ($k) {
                    return $d->indikator->kriteria_id == $k->id;
                });

                if ($detailKriteria->count() > 0) {
                    $avgDetail = $detailKriteria->avg(function ($d) {
                        return ($d->nilai / $d->indikator->skala_maksimal) * 100;
                    });
                    $nilaiKriteria[] = $avgDetail;
                }
            }

            $nilaiPerKriteria[] = [
                'nama' => $k->nama_kriteria,
                'nilai' => count($nilaiKriteria) > 0 ? array_sum($nilaiKriteria) / count($nilaiKriteria) : 0,
            ];
        }

        $guru->load('pengguna');

        return view('laporan.show', compact(
            'guru',
            'hasilPenilaian',
            'periodeList',
            'rataRataNilai',
            'predikat',
            'nilaiPerKriteria'
        ));
    }

    private function hitungPredikat($nilai): string
    {
        if ($nilai >= 90)
            return 'A';
        if ($nilai >= 80)
            return 'B';
        if ($nilai >= 70)
            return 'C';
        return 'D';
    }
}
