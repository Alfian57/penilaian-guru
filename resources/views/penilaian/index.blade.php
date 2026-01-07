@extends('layouts.app')

@section('title', 'Penilaian Guru - Sistem Penilaian Guru')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Penilaian Guru</h1>
        <p class="text-gray-600">Daftar penilaian yang perlu dilakukan</p>
    </div>

    <!-- Filter -->
    <div class="bg-white rounded-xl shadow mb-6 p-4">
        <form action="{{ route('penilaian.index') }}" method="GET" class="flex flex-wrap gap-4">
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
            <div class="w-48">
                <select name="status"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    <option value="">Semua Status</option>
                    <option value="belum" {{ request('status') == 'belum' ? 'selected' : '' }}>Belum Dinilai</option>
                    <option value="sudah" {{ request('status') == 'sudah' ? 'selected' : '' }}>Sudah Dinilai</option>
                </select>
            </div>
            <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                Filter
            </button>
            <a href="{{ route('penilaian.index') }}"
                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                Reset
            </a>
        </form>
    </div>

    <!-- Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($penugasan as $p)
            <div class="bg-white rounded-xl shadow overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-sm text-gray-500">{{ $p->periode->nama_periode }}</span>
                        @if($p->hasilPenilaian)
                            <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Selesai</span>
                        @else
                            <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">Belum</span>
                        @endif
                    </div>

                    <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $p->guru->pengguna->nama_lengkap }}</h3>
                    <p class="text-sm text-gray-600 mb-4">{{ $p->guru->mata_pelajaran }}</p>

                    @if($p->hasilPenilaian)
                        @php
                            $nilai = $p->hasilPenilaian->total_skor;
                            $predikat = $nilai >= 90 ? 'A' : ($nilai >= 80 ? 'B' : ($nilai >= 70 ? 'C' : 'D'));
                        @endphp
                        <div class="flex items-center justify-between mb-4 p-3 bg-gray-50 rounded-lg">
                            <div>
                                <div class="text-2xl font-bold text-primary-600">
                                    {{ number_format($p->hasilPenilaian->total_skor, 2) }}</div>
                                <div class="text-xs text-gray-500">Nilai</div>
                            </div>
                            <div class="text-center">
                                <div class="text-2xl font-bold 
                                    @if($predikat == 'A') text-green-600
                                    @elseif($predikat == 'B') text-blue-600
                                    @elseif($predikat == 'C') text-yellow-600
                                    @else text-red-600
                                    @endif">
                                    {{ $predikat }}
                                </div>
                                <div class="text-xs text-gray-500">Predikat</div>
                            </div>
                        </div>
                        <a href="{{ route('penilaian.show', $p->hasilPenilaian) }}"
                            class="block w-full text-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                            Lihat Hasil
                        </a>
                    @else
                        <a href="{{ route('penilaian.create', ['penugasan' => $p->id]) }}"
                            class="block w-full text-center px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">
                            Mulai Penilaian
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="bg-white rounded-xl shadow p-8 text-center">
                    <div class="text-gray-400 mb-4">
                        <svg class="w-16 h-16 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <p class="text-gray-500">Tidak ada penugasan penilaian</p>
                </div>
            </div>
        @endforelse
    </div>

    @if($penugasan->hasPages())
        <div class="mt-6">
            {{ $penugasan->withQueryString()->links() }}
        </div>
    @endif
@endsection