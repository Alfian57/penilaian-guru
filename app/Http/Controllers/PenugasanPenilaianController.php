<?php

namespace App\Http\Controllers;

use App\Models\PenugasanPenilaian;
use App\Models\PeriodeAkademik;
use App\Models\Penilai;
use App\Models\Guru;
use Illuminate\Http\Request;

class PenugasanPenilaianController extends Controller
{
    public function index(Request $request)
    {
        $query = PenugasanPenilaian::with(['periode', 'penilai.pengguna', 'guru.pengguna']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('guru.pengguna', function ($q2) use ($search) {
                    $q2->where('nama_lengkap', 'like', "%{$search}%");
                })
                    ->orWhereHas('penilai.pengguna', function ($q2) use ($search) {
                        $q2->where('nama_lengkap', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('periode')) {
            $query->where('periode_id', $request->periode);
        }

        $penugasan = $query->orderBy('dibuat_pada', 'desc')->paginate(10);
        $periodeList = PeriodeAkademik::all();

        return view('penugasan.index', compact('penugasan', 'periodeList'));
    }

    public function create()
    {
        $periodeList = PeriodeAkademik::aktif()->get();
        $penilaiList = Penilai::with('pengguna')->get();
        $guruList = Guru::with('pengguna')->get();

        return view('penugasan.create', compact('periodeList', 'penilaiList', 'guruList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'periode_id' => 'required|exists:periode_akademik,id',
            'penilai_id' => 'required|exists:penilai,id',
            'guru_id' => 'required|exists:guru,id',
        ]);

        // Cek apakah penugasan sudah ada
        $exists = PenugasanPenilaian::where('periode_id', $validated['periode_id'])
            ->where('penilai_id', $validated['penilai_id'])
            ->where('guru_id', $validated['guru_id'])
            ->exists();

        if ($exists) {
            return back()->withErrors(['error' => 'Penugasan penilaian ini sudah ada.'])->withInput();
        }

        PenugasanPenilaian::create($validated);

        return redirect()->route('penugasan.index')
            ->with('success', 'Penugasan penilaian berhasil ditambahkan.');
    }

    public function show(PenugasanPenilaian $penugasan)
    {
        $penugasan->load(['periode', 'penilai.pengguna', 'guru.pengguna', 'hasilPenilaian.detailPenilaian.indikator']);
        return view('penugasan.show', compact('penugasan'));
    }

    public function edit(PenugasanPenilaian $penugasan)
    {
        $periodeList = PeriodeAkademik::all();
        $penilaiList = Penilai::with('pengguna')->get();
        $guruList = Guru::with('pengguna')->get();

        return view('penugasan.edit', compact('penugasan', 'periodeList', 'penilaiList', 'guruList'));
    }

    public function update(Request $request, PenugasanPenilaian $penugasan)
    {
        $validated = $request->validate([
            'periode_id' => 'required|exists:periode_akademik,id',
            'penilai_id' => 'required|exists:penilai,id',
            'guru_id' => 'required|exists:guru,id',
            'status' => 'required|in:pending,selesai',
        ]);

        $penugasan->update($validated);

        return redirect()->route('penugasan.index')
            ->with('success', 'Penugasan penilaian berhasil diperbarui.');
    }

    public function destroy(PenugasanPenilaian $penugasan)
    {
        $penugasan->delete();
        return redirect()->route('penugasan.index')
            ->with('success', 'Penugasan penilaian berhasil dihapus.');
    }

    // Batch create
    public function createBatch()
    {
        $periodeList = PeriodeAkademik::aktif()->get();
        $penilaiList = Penilai::with('pengguna')->get();
        $guruList = Guru::with('pengguna')->get();

        return view('penugasan.create-batch', compact('periodeList', 'penilaiList', 'guruList'));
    }

    public function storeBatch(Request $request)
    {
        $validated = $request->validate([
            'periode_id' => 'required|exists:periode_akademik,id',
            'penilai_ids' => 'required|array',
            'penilai_ids.*' => 'exists:penilai,id',
            'guru_ids' => 'required|array',
            'guru_ids.*' => 'exists:guru,id',
        ]);

        $created = 0;
        foreach ($validated['penilai_ids'] as $penilaiId) {
            foreach ($validated['guru_ids'] as $guruId) {
                $exists = PenugasanPenilaian::where('periode_id', $validated['periode_id'])
                    ->where('penilai_id', $penilaiId)
                    ->where('guru_id', $guruId)
                    ->exists();

                if (!$exists) {
                    PenugasanPenilaian::create([
                        'periode_id' => $validated['periode_id'],
                        'penilai_id' => $penilaiId,
                        'guru_id' => $guruId,
                    ]);
                    $created++;
                }
            }
        }

        return redirect()->route('penugasan.index')
            ->with('success', "Berhasil membuat {$created} penugasan penilaian.");
    }
}
