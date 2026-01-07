<?php

namespace App\Http\Controllers;

use App\Enums\JenisPenilai;
use App\Enums\Peran;
use App\Models\Pengguna;
use App\Models\Guru;
use App\Models\Penilai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class PenggunaController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengguna::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('peran')) {
            $query->where('peran', $request->peran);
        }

        $pengguna = $query->orderBy('dibuat_pada', 'desc')->paginate(10);
        $peranList = Peran::cases();

        return view('pengguna.index', compact('pengguna', 'peranList'));
    }

    public function create()
    {
        $peranList = Peran::cases();
        $jenisPenilaiList = JenisPenilai::cases();
        return view('pengguna.create', compact('peranList', 'jenisPenilaiList'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'email' => 'required|email|unique:pengguna,email',
            'password' => 'required|string|min:8|confirmed',
            'peran' => ['required', new Enum(Peran::class)],
            'nip' => 'nullable|string|max:50',
            'jabatan' => 'nullable|string|max:100',
            'jenis_penilai' => ['nullable', new Enum(JenisPenilai::class)],
        ]);

        $peran = Peran::from($validated['peran']);

        $pengguna = Pengguna::create([
            'nama_lengkap' => $validated['nama_lengkap'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'peran' => $peran,
        ]);

        // Jika guru, buat record di tabel guru
        if ($peran === Peran::GURU || $peran === Peran::KEPSEK) {
            Guru::create([
                'pengguna_id' => $pengguna->id,
                'nip' => $validated['nip'] ?? null,
                'jabatan' => $validated['jabatan'] ?? null,
            ]);
        }

        // Jika ada jenis penilai, buat record penilai
        if (!empty($validated['jenis_penilai'])) {
            Penilai::create([
                'pengguna_id' => $pengguna->id,
                'jenis_penilai' => JenisPenilai::from($validated['jenis_penilai']),
            ]);
        }

        return redirect()->route('pengguna.index')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function show(Pengguna $pengguna)
    {
        $pengguna->load(['guru', 'penilai']);
        return view('pengguna.show', compact('pengguna'));
    }

    public function edit(Pengguna $pengguna)
    {
        $pengguna->load(['guru', 'penilai']);
        $peranList = Peran::cases();
        $jenisPenilaiList = JenisPenilai::cases();
        return view('pengguna.edit', compact('pengguna', 'peranList', 'jenisPenilaiList'));
    }

    public function update(Request $request, Pengguna $pengguna)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'email' => ['required', 'email', Rule::unique('pengguna')->ignore($pengguna->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'peran' => ['required', new Enum(Peran::class)],
            'nip' => 'nullable|string|max:50',
            'jabatan' => 'nullable|string|max:100',
            'jenis_penilai' => ['nullable', new Enum(JenisPenilai::class)],
        ]);

        $peran = Peran::from($validated['peran']);

        $updateData = [
            'nama_lengkap' => $validated['nama_lengkap'],
            'email' => $validated['email'],
            'peran' => $peran,
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = $validated['password'];
        }

        $pengguna->update($updateData);

        // Update atau buat record guru
        if ($peran === Peran::GURU || $peran === Peran::KEPSEK) {
            $pengguna->guru()->updateOrCreate(
                ['pengguna_id' => $pengguna->id],
                [
                    'nip' => $validated['nip'] ?? null,
                    'jabatan' => $validated['jabatan'] ?? null,
                ]
            );
        } else {
            $pengguna->guru()->delete();
        }

        // Update atau buat record penilai
        if (!empty($validated['jenis_penilai'])) {
            $pengguna->penilai()->updateOrCreate(
                ['pengguna_id' => $pengguna->id],
                ['jenis_penilai' => JenisPenilai::from($validated['jenis_penilai'])]
            );
        } else {
            $pengguna->penilai()->delete();
        }

        return redirect()->route('pengguna.index')
            ->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy(Pengguna $pengguna)
    {
        $pengguna->delete();
        return redirect()->route('pengguna.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }
}
