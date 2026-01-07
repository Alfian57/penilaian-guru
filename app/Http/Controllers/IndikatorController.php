<?php

namespace App\Http\Controllers;

use App\Models\Indikator;
use App\Models\Kriteria;
use Illuminate\Http\Request;

class IndikatorController extends Controller
{
    public function index(Request $request)
    {
        $query = Indikator::with('kriteria');

        if ($request->filled('search')) {
            $query->where('pertanyaan', 'like', "%{$request->search}%");
        }

        if ($request->filled('kriteria')) {
            $query->where('kriteria_id', $request->kriteria);
        }

        $indikator = $query->paginate(10);
        $kriteriaList = Kriteria::all();

        return view('indikator.index', compact('indikator', 'kriteriaList'));
    }

    public function create()
    {
        $kriteriaList = Kriteria::all();
        return view('indikator.create', compact('kriteriaList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kriteria_id' => 'required|exists:kriteria,id',
            'pertanyaan' => 'required|string',
            'skala_maksimal' => 'required|integer|min:1|max:10',
        ]);

        Indikator::create($validated);

        return redirect()->route('indikator.index')
            ->with('success', 'Indikator berhasil ditambahkan.');
    }

    public function show(Indikator $indikator)
    {
        $indikator->load('kriteria');
        return view('indikator.show', compact('indikator'));
    }

    public function edit(Indikator $indikator)
    {
        $kriteriaList = Kriteria::all();
        return view('indikator.edit', compact('indikator', 'kriteriaList'));
    }

    public function update(Request $request, Indikator $indikator)
    {
        $validated = $request->validate([
            'kriteria_id' => 'required|exists:kriteria,id',
            'pertanyaan' => 'required|string',
            'skala_maksimal' => 'required|integer|min:1|max:10',
        ]);

        $indikator->update($validated);

        return redirect()->route('indikator.index')
            ->with('success', 'Indikator berhasil diperbarui.');
    }

    public function destroy(Indikator $indikator)
    {
        $indikator->delete();
        return redirect()->route('indikator.index')
            ->with('success', 'Indikator berhasil dihapus.');
    }
}
