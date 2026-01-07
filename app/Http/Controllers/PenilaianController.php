<?php

namespace App\Http\Controllers;

use App\Models\PenugasanPenilaian;
use App\Models\HasilPenilaian;
use App\Models\DetailPenilaian;
use App\Models\Kriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenilaianController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $penilai = $user->penilai;

        if (!$penilai) {
            return redirect()->route('dashboard')
                ->with('error', 'Anda tidak terdaftar sebagai penilai.');
        }

        $tugasPending = PenugasanPenilaian::where('penilai_id', $penilai->id)
            ->pending()
            ->with(['guru.pengguna', 'periode'])
            ->get();

        $tugasSelesai = PenugasanPenilaian::where('penilai_id', $penilai->id)
            ->selesai()
            ->with(['guru.pengguna', 'periode', 'hasilPenilaian'])
            ->get();

        return view('penilaian.index', compact('tugasPending', 'tugasSelesai'));
    }

    public function create(PenugasanPenilaian $penugasan)
    {
        $user = Auth::user();

        // Verifikasi akses
        if (!$user->penilai || $penugasan->penilai_id !== $user->penilai->id) {
            return redirect()->route('penilaian.index')
                ->with('error', 'Anda tidak memiliki akses ke penugasan ini.');
        }

        if ($penugasan->status === 'selesai') {
            return redirect()->route('penilaian.index')
                ->with('error', 'Penugasan ini sudah selesai dinilai.');
        }

        $penugasan->load(['guru.pengguna', 'periode']);
        $kriteria = Kriteria::with('indikator')->get();

        return view('penilaian.create', compact('penugasan', 'kriteria'));
    }

    public function store(Request $request, PenugasanPenilaian $penugasan)
    {
        $user = Auth::user();

        // Verifikasi akses
        if (!$user->penilai || $penugasan->penilai_id !== $user->penilai->id) {
            return redirect()->route('penilaian.index')
                ->with('error', 'Anda tidak memiliki akses ke penugasan ini.');
        }

        if ($penugasan->status === 'selesai') {
            return redirect()->route('penilaian.index')
                ->with('error', 'Penugasan ini sudah selesai dinilai.');
        }

        $validated = $request->validate([
            'nilai' => 'required|array',
            'nilai.*' => 'required|integer|min:1|max:5',
            'saran_masukan' => 'nullable|string',
        ]);

        DB::transaction(function () use ($validated, $penugasan) {
            // Hitung total skor
            $kriteria = Kriteria::with('indikator')->get();
            $totalSkor = 0;
            $totalBobot = $kriteria->sum('bobot_persen');

            foreach ($kriteria as $k) {
                $skorKriteria = 0;
                $jumlahIndikator = $k->indikator->count();

                if ($jumlahIndikator > 0) {
                    foreach ($k->indikator as $ind) {
                        if (isset($validated['nilai'][$ind->id])) {
                            $skorKriteria += ($validated['nilai'][$ind->id] / $ind->skala_maksimal) * 100;
                        }
                    }
                    $skorKriteria = $skorKriteria / $jumlahIndikator;
                }

                $totalSkor += ($skorKriteria * $k->bobot_persen / 100);
            }

            // Buat hasil penilaian
            $hasil = HasilPenilaian::create([
                'penugasan_id' => $penugasan->id,
                'total_skor' => $totalSkor,
                'saran_masukan' => $validated['saran_masukan'] ?? null,
            ]);

            // Simpan detail penilaian
            foreach ($validated['nilai'] as $indikatorId => $nilai) {
                DetailPenilaian::create([
                    'hasil_id' => $hasil->id,
                    'indikator_id' => $indikatorId,
                    'nilai' => $nilai,
                ]);
            }

            // Update status penugasan
            $penugasan->update(['status' => 'selesai']);
        });

        return redirect()->route('penilaian.index')
            ->with('success', 'Penilaian berhasil disimpan.');
    }

    public function show(HasilPenilaian $hasil)
    {
        $hasil->load(['penugasan.guru.pengguna', 'penugasan.penilai.pengguna', 'penugasan.periode', 'detailPenilaian.indikator.kriteria']);

        // Group detail by kriteria
        $detailByKriteria = $hasil->detailPenilaian->groupBy(function ($detail) {
            return $detail->indikator->kriteria->nama_kriteria;
        });

        return view('penilaian.show', compact('hasil', 'detailByKriteria'));
    }
}
