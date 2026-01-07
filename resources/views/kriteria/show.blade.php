@extends('layouts.app')

@section('title', 'Detail Kriteria - Sistem Penilaian Guru')

@section('content')
    <div class="mb-6">
        <a href="{{ route('kriteria.index') }}" class="text-primary-600 hover:text-primary-800 flex items-center">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>
        <h1 class="text-2xl font-bold text-gray-800 mt-2">Detail Kriteria</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-xl font-bold text-gray-800">{{ $kriteria->nama_kriteria }}</h2>
                <div class="mt-4">
                    <p class="text-sm text-gray-500">Bobot</p>
                    <p class="text-3xl font-bold text-primary-600">{{ number_format($kriteria->bobot_persen, 2) }}%</p>
                </div>
                <div class="mt-4">
                    <p class="text-sm text-gray-500">Jumlah Indikator</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $kriteria->indikator->count() }}</p>
                </div>

                <div class="mt-6 pt-6 border-t border-gray-200 flex items-center justify-center space-x-3">
                    <a href="{{ route('kriteria.edit', $kriteria) }}"
                        class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">
                        Edit
                    </a>
                    <a href="{{ route('indikator.create', ['kriteria' => $kriteria->id]) }}"
                        class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">
                        Tambah Indikator
                    </a>
                </div>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Daftar Indikator</h3>
                </div>

                @if($kriteria->indikator->isNotEmpty())
                    <div class="divide-y divide-gray-200">
                        @foreach($kriteria->indikator as $index => $indikator)
                            <div class="px-6 py-4 hover:bg-gray-50">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <p class="text-sm text-gray-500">Indikator {{ $index + 1 }}</p>
                                        <p class="text-gray-800 mt-1">{{ $indikator->pertanyaan }}</p>
                                        <p class="text-xs text-gray-500 mt-1">Skala: 1 - {{ $indikator->skala_maksimal }}</p>
                                    </div>
                                    <div class="flex items-center space-x-2 ml-4">
                                        <a href="{{ route('indikator.edit', $indikator) }}"
                                            class="p-2 text-yellow-600 hover:bg-yellow-50 rounded-lg">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('indikator.destroy', $indikator) }}" method="POST" class="inline"
                                            onsubmit="return confirm('Yakin ingin menghapus indikator ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="px-6 py-8 text-center text-gray-500">
                        Belum ada indikator untuk kriteria ini
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection