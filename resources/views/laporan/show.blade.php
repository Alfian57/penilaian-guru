@extends('layouts.app')

@section('title', 'Laporan Guru - Sistem Penilaian Guru')

@section('content')
    <div class="mb-6">
        <a href="{{ route('laporan.index') }}" class="text-primary-600 hover:text-primary-800 flex items-center">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>
        <h1 class="text-2xl font-bold text-gray-800 mt-2">Laporan Penilaian Guru</h1>
    </div>

    <!-- Profile Card -->
    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div class="flex items-center mb-4 lg:mb-0">
                <div
                    class="w-20 h-20 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 text-3xl font-bold mr-4">
                    {{ strtoupper(substr($guru->pengguna->nama_lengkap, 0, 1)) }}
                </div>
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">{{ $guru->pengguna->nama_lengkap }}</h2>
                    <p class="text-gray-600">{{ $guru->mata_pelajaran }}</p>
                    <p class="text-sm text-gray-500">NIP: {{ $guru->nip ?? '-' }}</p>
                </div>
            </div>

            @if($hasilPenilaian->count() > 0)
                <div class="flex items-center space-x-8">
                    <div class="text-center">
                        <div class="text-4xl font-bold text-primary-600">{{ number_format($rataRataNilai, 2) }}</div>
                        <div class="text-sm text-gray-500">Rata-rata Nilai</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl font-bold 
                            @if($predikat == 'A') text-green-600
                            @elseif($predikat == 'B') text-blue-600
                            @elseif($predikat == 'C') text-yellow-600
                            @else text-red-600
                            @endif">
                            {{ $predikat }}
                        </div>
                        <div class="text-sm text-gray-500">Predikat</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl font-bold text-gray-800">{{ $hasilPenilaian->count() }}</div>
                        <div class="text-sm text-gray-500">Total Penilaian</div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Filter -->
    <div class="bg-white rounded-xl shadow mb-6 p-4">
        <form action="{{ route('laporan.show', $guru) }}" method="GET" class="flex flex-wrap gap-4">
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
            <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                Filter
            </button>
            <a href="{{ route('laporan.show', $guru) }}"
                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                Reset
            </a>
        </form>
    </div>

    @if($hasilPenilaian->count() > 0)
        <!-- Nilai per Kriteria -->
        <div class="bg-white rounded-xl shadow p-6 mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Nilai Rata-rata per Kriteria</h3>

            <div class="space-y-4">
                @foreach($nilaiPerKriteria as $kriteria)
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-sm font-medium text-gray-700">{{ $kriteria['nama'] }}</span>
                            <span class="text-sm font-medium text-gray-800">{{ number_format($kriteria['nilai'], 2) }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="h-3 rounded-full 
                                @if($kriteria['nilai'] >= 90) bg-green-500
                                @elseif($kriteria['nilai'] >= 80) bg-blue-500
                                @elseif($kriteria['nilai'] >= 70) bg-yellow-500
                                @else bg-red-500
                                @endif" style="width: {{ min($kriteria['nilai'], 100) }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Riwayat Penilaian -->
        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800">Riwayat Penilaian</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Periode</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Penilai</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jenis</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Nilai</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Predikat</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($hasilPenilaian as $index => $hasil)
                            @php
                                $nilaiItem = $hasil->total_skor;
                                $predikatItem = $nilaiItem >= 90 ? 'A' : ($nilaiItem >= 80 ? 'B' : ($nilaiItem >= 70 ? 'C' : 'D'));
                            @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 text-sm text-gray-800">
                                    {{ $hasil->penugasan->periode->nama_periode }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $hasil->penugasan->penilai->pengguna->nama_lengkap }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded-full">
                                        {{ $hasil->penugasan->penilai->jenis_penilai->label() }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $hasil->waktu_submit->format('d M Y') }}</td>
                                <td class="px-6 py-4 text-center text-sm font-medium text-gray-800">
                                    {{ number_format($hasil->total_skor, 2) }}</td>
                                <td class="px-6 py-4 text-center">
                                    <span class="px-2 py-1 text-xs rounded-full
                                        @if($predikatItem == 'A') bg-green-100 text-green-800
                                        @elseif($predikatItem == 'B') bg-blue-100 text-blue-800
                                        @elseif($predikatItem == 'C') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ $predikatItem }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('penilaian.show', $hasil) }}"
                                        class="text-primary-600 hover:text-primary-800 text-sm">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="bg-white rounded-xl shadow p-8 text-center">
            <div class="text-gray-400 mb-4">
                <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
            </div>
            <p class="text-gray-500">Guru ini belum memiliki penilaian</p>
        </div>
    @endif

    <!-- Print Button -->
    @if($hasilPenilaian->count() > 0)
        <div class="mt-6 flex justify-end">
            <button onclick="window.print()"
                class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                </svg>
                Cetak Laporan
            </button>
        </div>
    @endif
@endsection