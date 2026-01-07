<?php

namespace App\Http\Controllers;

use App\Models\Penilai;
use App\Models\Pengguna;
use Illuminate\Http\Request;

class PenilaiController extends Controller
{
    public function index(Request $request)
    {
        $query = Penilai::with('pengguna');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('pengguna', function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('jenis')) {
            $query->where('jenis_penilai', $request->jenis);
        }

        $penilai = $query->paginate(10);

        return view('penilai.index', compact('penilai'));
    }

    public function create()
    {
        $penggunaList = Pengguna::whereDoesntHave('penilai')->get();
        return view('penilai.create', compact('penggunaList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pengguna_id' => 'required|exists:pengguna,id|unique:penilai,pengguna_id',
            'jenis_penilai' => 'required|in:atasan,sejawat,siswa',
        ]);

        Penilai::create($validated);

        return redirect()->route('penilai.index')
            ->with('success', 'Penilai berhasil ditambahkan.');
    }

    public function show(Penilai $penilai)
    {
        $penilai->load(['pengguna', 'penugasanPenilaian.guru.pengguna', 'penugasanPenilaian.hasilPenilaian']);
        return view('penilai.show', compact('penilai'));
    }

    public function edit(Penilai $penilai)
    {
        return view('penilai.edit', compact('penilai'));
    }

    public function update(Request $request, Penilai $penilai)
    {
        $validated = $request->validate([
            'jenis_penilai' => 'required|in:atasan,sejawat,siswa',
        ]);

        $penilai->update($validated);

        return redirect()->route('penilai.index')
            ->with('success', 'Penilai berhasil diperbarui.');
    }

    public function destroy(Penilai $penilai)
    {
        $penilai->delete();
        return redirect()->route('penilai.index')
            ->with('success', 'Penilai berhasil dihapus.');
    }
}
