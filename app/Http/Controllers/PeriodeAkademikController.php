<?php

namespace App\Http\Controllers;

use App\Models\PeriodeAkademik;
use Illuminate\Http\Request;

class PeriodeAkademikController extends Controller
{
    public function index(Request $request)
    {
        $query = PeriodeAkademik::query();

        if ($request->filled('search')) {
            $query->where('nama_periode', 'like', "%{$request->search}%");
        }

        if ($request->filled('status')) {
            $query->where('status_aktif', $request->status === 'aktif');
        }

        $periode = $query->orderBy('tanggal_mulai', 'desc')->paginate(10);

        return view('periode.index', compact('periode'));
    }

    public function create()
    {
        return view('periode.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_periode' => 'required|string|max:100',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'status_aktif' => 'boolean',
        ]);

        // Jika periode baru aktif, nonaktifkan yang lain
        if ($request->boolean('status_aktif')) {
            PeriodeAkademik::where('status_aktif', true)->update(['status_aktif' => false]);
        }

        PeriodeAkademik::create($validated);

        return redirect()->route('periode.index')
            ->with('success', 'Periode akademik berhasil ditambahkan.');
    }

    public function show(PeriodeAkademik $periode)
    {
        $periode->load(['penugasanPenilaian.guru.pengguna', 'penugasanPenilaian.penilai.pengguna']);
        return view('periode.show', compact('periode'));
    }

    public function edit(PeriodeAkademik $periode)
    {
        return view('periode.edit', compact('periode'));
    }

    public function update(Request $request, PeriodeAkademik $periode)
    {
        $validated = $request->validate([
            'nama_periode' => 'required|string|max:100',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
            'status_aktif' => 'boolean',
        ]);

        // Jika periode baru aktif, nonaktifkan yang lain
        if ($request->boolean('status_aktif') && !$periode->status_aktif) {
            PeriodeAkademik::where('status_aktif', true)
                ->where('id', '!=', $periode->id)
                ->update(['status_aktif' => false]);
        }

        $periode->update($validated);

        return redirect()->route('periode.index')
            ->with('success', 'Periode akademik berhasil diperbarui.');
    }

    public function destroy(PeriodeAkademik $periode)
    {
        $periode->delete();
        return redirect()->route('periode.index')
            ->with('success', 'Periode akademik berhasil dihapus.');
    }

    public function activate(PeriodeAkademik $periode)
    {
        PeriodeAkademik::where('status_aktif', true)->update(['status_aktif' => false]);
        $periode->update(['status_aktif' => true]);

        return redirect()->route('periode.index')
            ->with('success', 'Periode akademik berhasil diaktifkan.');
    }
}
