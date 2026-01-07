@extends('layouts.app')

@section('title', 'Laporan Penilaian - Sistem Penilaian Guru')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Laporan Penilaian</h1>
        <p class="text-gray-600">Rekap hasil penilaian guru</p>
    </div>

    <!-- Filter -->
    <div class="bg-white rounded-xl shadow mb-6 p-4">
        <form action="{{ route('laporan.index') }}" method="GET" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama guru..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
            </div>
            <div class="w-48">
                <select name="periode"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    <option value="">Semua Periode</option>
                    @foreach($periodeList as $p)
                        <option value="{{ $p->id }}" {{ request('periode') == $p->id ? 'selected' : '' }}>
                            {{ $p->nama_periode }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="w-36">
                <select name="predikat"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    <option value="">Predikat</option>
                    <option value="A" {{ request('predikat') == 'A' ? 'selected' : '' }}>A</option>
                    <option value="B" {{ request('predikat') == 'B' ? 'selected' : '' }}>B</option>
                    <option value="C" {{ request('predikat') == 'C' ? 'selected' : '' }}>C</option>
                    <option value="D" {{ request('predikat') == 'D' ? 'selected' : '' }}>D</option>
                </select>
            </div>
            <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                Filter
            </button>
            <a href="{{ route('laporan.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                Reset
            </a>
        </form>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow p-4">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-primary-100 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-800">{{ $totalGuru }}</div>
                    <div class="text-sm text-gray-500">Total Guru</div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-4">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-800">{{ $totalDinilai }}</div>
                    <div class="text-sm text-gray-500">Sudah Dinilai</div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-4">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-800">{{ $totalBelum }}</div>
                    <div class="text-sm text-gray-500">Belum Dinilai</div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-4">
            <div class="flex items-center">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mr-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <div>
                    <div class="text-2xl font-bold text-gray-800">{{ number_format($rataRata, 2) }}</div>
                    <div class="text-sm text-gray-500">Rata-rata Nilai</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Guru</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">NIP</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Mata Pelajaran</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Jumlah Penilai</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Rata-rata</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Predikat</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($guruList as $index => $guru)
                        @php
                            $periodeFilter = $selectedPeriode ?? null;
                            $hasilPenilaian = $guru->penugasanSebagaiDinilai->filter(function ($p) use ($periodeFilter) {
                                if ($periodeFilter) {
                                    return $p->hasilPenilaian && $p->periode_id == $periodeFilter;
                                }
                                return $p->hasilPenilaian;
                            })->map(function ($p) {
                                return $p->hasilPenilaian;
                            })->filter();

                            $avgNilai = $hasilPenilaian->count() > 0 ? $hasilPenilaian->avg('total_skor') : null;
                            $predikat = null;
                            if ($avgNilai !== null) {
                                if ($avgNilai >= 90)
                                    $predikat = 'A';
                                elseif ($avgNilai >= 80)
                                    $predikat = 'B';
                                elseif ($avgNilai >= 70)
                                    $predikat = 'C';
                                else
                                    $predikat = 'D';
                            }
                        @endphp
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $guruList->firstItem() + $index }}</td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-800">{{ $guru->pengguna->nama_lengkap }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $guru->nip ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $guru->mata_pelajaran }}</td>
                            <td class="px-6 py-4 text-center text-sm text-gray-600">{{ $hasilPenilaian->count() }}</td>
                            <td class="px-6 py-4 text-center">
                                @if($avgNilai !== null)
                                    <span class="font-medium text-gray-800">{{ number_format($avgNilai, 2) }}</span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($predikat)
                                    <span class="px-2 py-1 text-xs rounded-full
                                        @if($predikat == 'A') bg-green-100 text-green-800
                                        @elseif($predikat == 'B') bg-blue-100 text-blue-800
                                        @elseif($predikat == 'C') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ $predikat }}
                                    </span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{ route('laporan.show', $guru) }}" class="text-primary-600 hover:text-primary-800">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-4 text-center text-gray-500">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($guruList->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $guruList->withQueryString()->links() }}
            </div>
        @endif
    </div>
@endsection