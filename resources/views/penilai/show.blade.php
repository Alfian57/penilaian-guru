@extends('layouts.app')

@section('title', 'Detail Penilai - Sistem Penilaian Guru')

@section('content')
    <div class="mb-6">
        <a href="{{ route('penilai.index') }}" class="text-primary-600 hover:text-primary-800 flex items-center">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>
        <h1 class="text-2xl font-bold text-gray-800 mt-2">Detail Penilai</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow p-6">
                <div class="text-center">
                    <div class="w-24 h-24 bg-primary-100 rounded-full flex items-center justify-center mx-auto">
                        <span
                            class="text-3xl font-bold text-primary-600">{{ strtoupper(substr($penilai->pengguna->nama_lengkap, 0, 2)) }}</span>
                    </div>
                    <h2 class="text-xl font-bold text-gray-800 mt-4">{{ $penilai->pengguna->nama_lengkap }}</h2>
                    <span
                        class="inline-block mt-2 px-3 py-1 text-sm rounded-full {{ $penilai->jenis_penilai->value === 'atasan' ? 'bg-purple-100 text-purple-800' : ($penilai->jenis_penilai->value === 'sejawat' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                        {{ $penilai->jenis_penilai->label() }}
                    </span>
                </div>

                <div class="mt-6 space-y-4">
                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="font-medium text-gray-800">{{ $penilai->pengguna->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Peran</p>
                        <p class="font-medium text-gray-800">{{ $penilai->pengguna->peran->label() }}</p>
                    </div>
                </div>

                <div class="mt-6 pt-6 border-t border-gray-200 flex items-center justify-center space-x-3">
                    <a href="{{ route('penilai.edit', $penilai) }}"
                        class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">
                        Edit
                    </a>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Riwayat Penilaian yang Diberikan</h3>
                </div>

                @if($penilai->penugasanPenilaian->isNotEmpty())
                    <div class="divide-y divide-gray-200">
                        @foreach($penilai->penugasanPenilaian->sortByDesc('dibuat_pada') as $penugasan)
                            <div class="px-6 py-4 hover:bg-gray-50">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium text-gray-800">{{ $penugasan->guru->pengguna->nama_lengkap }}</p>
                                        <p class="text-sm text-gray-500">{{ $penugasan->dibuat_pada->format('d M Y') }}</p>
                                    </div>
                                    <div class="text-right">
                                        @if($penugasan->status === 'selesai' && $penugasan->hasilPenilaian)
                                            <p class="text-lg font-bold text-primary-600">
                                                {{ number_format($penugasan->hasilPenilaian->total_skor, 2) }}</p>
                                            <p class="text-xs text-gray-500">Skor</p>
                                        @else
                                            <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">Pending</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="px-6 py-8 text-center text-gray-500">
                        Belum ada riwayat penilaian
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection