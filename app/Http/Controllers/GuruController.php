<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\Pengguna;
use Illuminate\Http\Request;

class GuruController extends Controller
{
    public function index(Request $request)
    {
        $query = Guru::with('pengguna');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nip', 'like', "%{$search}%")
                    ->orWhere('jabatan', 'like', "%{$search}%")
                    ->orWhereHas('pengguna', function ($q2) use ($search) {
                        $q2->where('nama_lengkap', 'like', "%{$search}%");
                    });
            });
        }

        $guru = $query->paginate(10);

        return view('guru.index', compact('guru'));
    }

    public function create()
    {
        $penggunaList = Pengguna::whereIn('peran', ['guru', 'kepsek'])
            ->whereDoesntHave('guru')
            ->get();
        return view('guru.create', compact('penggunaList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'pengguna_id' => 'required|exists:pengguna,id|unique:guru,pengguna_id',
            'nip' => 'nullable|string|max:50',
            'jabatan' => 'nullable|string|max:100',
        ]);

        Guru::create($validated);

        return redirect()->route('guru.index')
            ->with('success', 'Data guru berhasil ditambahkan.');
    }

    public function show(Guru $guru)
    {
        $guru->load(['pengguna', 'penugasanPenilaian.hasilPenilaian', 'penugasanPenilaian.penilai.pengguna']);
        return view('guru.show', compact('guru'));
    }

    public function edit(Guru $guru)
    {
        return view('guru.edit', compact('guru'));
    }

    public function update(Request $request, Guru $guru)
    {
        $validated = $request->validate([
            'nip' => 'nullable|string|max:50',
            'jabatan' => 'nullable|string|max:100',
        ]);

        $guru->update($validated);

        return redirect()->route('guru.index')
            ->with('success', 'Data guru berhasil diperbarui.');
    }

    public function destroy(Guru $guru)
    {
        $guru->delete();
        return redirect()->route('guru.index')
            ->with('success', 'Data guru berhasil dihapus.');
    }
}
