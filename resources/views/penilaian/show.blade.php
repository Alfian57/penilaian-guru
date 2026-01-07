@extends('layouts.app')

@section('title', 'Detail Penilaian - Sistem Penilaian Guru')

@section('content')
    <div class="mb-6">
        <a href="{{ route('penilaian.index') }}" class="text-primary-600 hover:text-primary-800 flex items-center">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>
        <h1 class="text-2xl font-bold text-gray-800 mt-2">Detail Penilaian</h1>
    </div>

    <!-- Summary Card -->
    <div class="bg-white rounded-xl shadow p-6 mb-6">
        @php
            $nilai = $hasil->total_skor;
            $predikat = $nilai >= 90 ? 'A' : ($nilai >= 80 ? 'B' : ($nilai >= 70 ? 'C' : 'D'));
        @endphp
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
            <div class="flex items-center mb-4 lg:mb-0">
                <div
                    class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 text-2xl font-bold mr-4">
                    {{ strtoupper(substr($hasil->penugasan->guru->pengguna->nama_lengkap, 0, 1)) }}
                </div>
                <div>
                    <h2 class="text-xl font-semibold text-gray-800">{{ $hasil->penugasan->guru->pengguna->nama_lengkap }}
                    </h2>
                    <p class="text-gray-600">{{ $hasil->penugasan->guru->mata_pelajaran }}</p>
                    <p class="text-sm text-gray-500">
                        {{ $hasil->penugasan->periode->nama_periode }}
                    </p>
                </div>
            </div>

            <div class="flex items-center space-x-8">
                <div class="text-center">
                    <div class="text-4xl font-bold text-primary-600">{{ number_format($hasil->total_skor, 2) }}</div>
                    <div class="text-sm text-gray-500">Nilai Total</div>
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
            </div>
        </div>
    </div>

    <!-- Info Penilai -->
    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <div class="text-sm text-gray-500">Penilai</div>
                <div class="font-medium text-gray-800">{{ $hasil->penugasan->penilai->pengguna->nama_lengkap }}</div>
                <div class="text-xs text-gray-500">{{ $hasil->penugasan->penilai->jenis_penilai->label() }}</div>
            </div>
            <div>
                <div class="text-sm text-gray-500">Tanggal Penilaian</div>
                <div class="font-medium text-gray-800">{{ $hasil->waktu_submit->format('d F Y') }}</div>
                <div class="text-xs text-gray-500">{{ $hasil->waktu_submit->format('H:i') }} WIB</div>
            </div>
            <div>
                <div class="text-sm text-gray-500">Total Indikator</div>
                <div class="font-medium text-gray-800">{{ $hasil->detailPenilaian->count() }} Pertanyaan</div>
            </div>
        </div>
    </div>

    <!-- Detail per Kriteria -->
    @php
        $detailByKriteria = $hasil->detailPenilaian->groupBy(function ($item) {
            return $item->indikator->kriteria_id;
        });
    @endphp

    @foreach($detailByKriteria as $kriteriaId => $details)
        @php
            $kriteria = $details->first()->indikator->kriteria;
            $avgNilai = $details->avg(function ($d) {
                return ($d->nilai / $d->indikator->skala_maksimal) * 100;
            });
        @endphp
        <div class="bg-white rounded-xl shadow mb-6 overflow-hidden">
            <div class="p-4 bg-gray-50 border-b border-gray-200 flex items-center justify-between">
                <div>
                    <h3 class="font-semibold text-gray-800">{{ $kriteria->nama_kriteria }}</h3>
                    <p class="text-sm text-gray-500">Bobot: {{ number_format($kriteria->bobot_persen, 2) }}%</p>
                </div>
                <div class="text-right">
                    <div class="text-2xl font-bold text-primary-600">{{ number_format($avgNilai, 1) }}%</div>
                    <div class="text-xs text-gray-500">Rata-rata</div>
                </div>
            </div>

            <div class="divide-y divide-gray-100">
                @foreach($details as $detail)
                    <div class="p-4 flex items-center justify-between">
                        <div class="flex-1 pr-4">
                            <p class="text-gray-800">{{ $detail->indikator->pertanyaan }}</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <div class="flex items-center">
                                @for($i = 1; $i <= $detail->indikator->skala_maksimal; $i++)
                                    <div class="w-8 h-8 flex items-center justify-center text-sm
                                        @if($i <= $detail->nilai) bg-primary-600 text-white @else bg-gray-100 text-gray-400 @endif
                                        {{ $i == 1 ? 'rounded-l-lg' : '' }}
                                        {{ $i == $detail->indikator->skala_maksimal ? 'rounded-r-lg' : '' }}">
                                        {{ $i }}
                                    </div>
                                @endfor
                            </div>
                            <span class="text-sm font-medium text-gray-600 w-16 text-right">
                                {{ $detail->nilai }}/{{ $detail->indikator->skala_maksimal }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach

    <!-- Saran/Masukan -->
    @if($hasil->saran_masukan)
        <div class="bg-white rounded-xl shadow p-6 mb-6">
            <h3 class="font-semibold text-gray-800 mb-2">Saran / Masukan</h3>
            <p class="text-gray-600">{{ $hasil->saran_masukan }}</p>
        </div>
    @endif

    <!-- Action -->
    <div class="flex items-center justify-between">
        <a href="{{ route('penilaian.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
            Kembali ke Daftar
        </a>

        @if(auth()->user()->isAdmin() || auth()->user()->isKepsek())
            <a href="{{ route('laporan.show', $hasil->penugasan->guru) }}"
                class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">
                Lihat Laporan Guru
            </a>
        @endif
    </div>
@endsection