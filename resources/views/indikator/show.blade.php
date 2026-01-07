@extends('layouts.app')

@section('title', 'Detail Indikator - Sistem Penilaian Guru')

@section('content')
    <div class="mb-6">
        <a href="{{ route('indikator.index') }}" class="text-primary-600 hover:text-primary-800 flex items-center">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>
        <h1 class="text-2xl font-bold text-gray-800 mt-2">Detail Indikator</h1>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <div class="mb-4">
            <span class="px-3 py-1 text-sm bg-primary-100 text-primary-800 rounded-full">
                {{ $indikator->kriteria->nama_kriteria }}
            </span>
        </div>

        <h2 class="text-xl text-gray-800 mb-4">{{ $indikator->pertanyaan }}</h2>

        <div class="flex items-center space-x-6 text-sm text-gray-600">
            <div>
                <span class="text-gray-500">Skala:</span>
                <span class="font-medium">1 - {{ $indikator->skala_maksimal }}</span>
            </div>
            <div>
                <span class="text-gray-500">Bobot Kriteria:</span>
                <span class="font-medium">{{ number_format($indikator->kriteria->bobot_persen, 2) }}%</span>
            </div>
        </div>

        <div class="mt-6 pt-6 border-t border-gray-200 flex items-center space-x-3">
            <a href="{{ route('indikator.edit', $indikator) }}"
                class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">
                Edit
            </a>
            <form action="{{ route('indikator.destroy', $indikator) }}" method="POST"
                onsubmit="return confirm('Yakin ingin menghapus indikator ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                    Hapus
                </button>
            </form>
        </div>
    </div>
@endsection