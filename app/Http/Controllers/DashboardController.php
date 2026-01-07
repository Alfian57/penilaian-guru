<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Pengguna;
use App\Models\Penilai;
use App\Models\PenugasanPenilaian;
use App\Models\HasilPenilaian;
use App\Models\PeriodeAkademik;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data = [];

        if ($user->isAdmin() || $user->isKepsek()) {
            $data['total_guru'] = Guru::count();
            $data['total_penilai'] = Penilai::count();
            $data['total_pengguna'] = Pengguna::count();
            $data['periode_aktif'] = PeriodeAkademik::aktif()->first();
            $data['penugasan_pending'] = PenugasanPenilaian::pending()->count();
            $data['penugasan_selesai'] = PenugasanPenilaian::selesai()->count();

            // Statistik penilaian per guru
            $data['statistik_guru'] = Guru::with(['pengguna', 'penugasanPenilaian.hasilPenilaian'])
                ->get()
                ->map(function ($guru) {
                    $penilaianSelesai = $guru->penugasanPenilaian->where('status', 'selesai');
                    $totalSkor = $penilaianSelesai->sum(function ($p) {
                        return $p->hasilPenilaian ? $p->hasilPenilaian->total_skor : 0;
                    });
                    $jumlahPenilaian = $penilaianSelesai->count();

                    return [
                        'nama' => $guru->pengguna->nama_lengkap,
                        'nip' => $guru->nip,
                        'rata_rata' => $jumlahPenilaian > 0 ? round($totalSkor / $jumlahPenilaian, 2) : 0,
                        'jumlah_penilaian' => $jumlahPenilaian,
                    ];
                });
        }

        if ($user->isGuru()) {
            $guru = $user->guru;
            $penilai = $user->penilai;

            if ($guru) {
                $data['penilaian_diterima'] = PenugasanPenilaian::where('guru_id', $guru->id)
                    ->with(['penilai.pengguna', 'hasilPenilaian', 'periode'])
                    ->orderBy('dibuat_pada', 'desc')
                    ->take(5)
                    ->get();
            }

            if ($penilai) {
                $data['tugas_menilai'] = PenugasanPenilaian::where('penilai_id', $penilai->id)
                    ->pending()
                    ->with(['guru.pengguna', 'periode'])
                    ->get();
            }
        }

        if ($user->isSiswa()) {
            $penilai = $user->penilai;
            if ($penilai) {
                $data['tugas_menilai'] = PenugasanPenilaian::where('penilai_id', $penilai->id)
                    ->pending()
                    ->with(['guru.pengguna', 'periode'])
                    ->get();

                $data['penilaian_selesai'] = PenugasanPenilaian::where('penilai_id', $penilai->id)
                    ->selesai()
                    ->with(['guru.pengguna', 'periode', 'hasilPenilaian'])
                    ->get();
            }
        }

        return view('dashboard', compact('data', 'user'));
    }
}
