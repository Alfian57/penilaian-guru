<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    public function index(Request $request)
    {
        $query = Kriteria::withCount('indikator');

        if ($request->filled('search')) {
            $query->where('nama_kriteria', 'like', "%{$request->search}%");
        }

        $kriteria = $query->paginate(10);

        return view('kriteria.index', compact('kriteria'));
    }

    public function create()
    {
        return view('kriteria.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kriteria' => 'required|string|max:100',
            'bobot_persen' => 'required|numeric|min:0|max:100',
        ]);

        Kriteria::create($validated);

        return redirect()->route('kriteria.index')
            ->with('success', 'Kriteria berhasil ditambahkan.');
    }

    public function show(Kriteria $kriteria)
    {
        $kriteria->load('indikator');
        return view('kriteria.show', compact('kriteria'));
    }

    public function edit(Kriteria $kriteria)
    {
        return view('kriteria.edit', compact('kriteria'));
    }

    public function update(Request $request, Kriteria $kriteria)
    {
        $validated = $request->validate([
            'nama_kriteria' => 'required|string|max:100',
            'bobot_persen' => 'required|numeric|min:0|max:100',
        ]);

        $kriteria->update($validated);

        return redirect()->route('kriteria.index')
            ->with('success', 'Kriteria berhasil diperbarui.');
    }

    public function destroy(Kriteria $kriteria)
    {
        $kriteria->delete();
        return redirect()->route('kriteria.index')
            ->with('success', 'Kriteria berhasil dihapus.');
    }
}
