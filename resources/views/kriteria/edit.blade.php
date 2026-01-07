@extends('layouts.app')

@section('title', 'Edit Kriteria - Sistem Penilaian Guru')

@section('content')
    <div class="mb-6">
        <a href="{{ route('kriteria.index') }}" class="text-primary-600 hover:text-primary-800 flex items-center">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>
        <h1 class="text-2xl font-bold text-gray-800 mt-2">Edit Kriteria</h1>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <form action="{{ route('kriteria.update', $kriteria) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nama_kriteria" class="block text-sm font-medium text-gray-700 mb-1">Nama Kriteria <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="nama_kriteria" id="nama_kriteria"
                        value="{{ old('nama_kriteria', $kriteria->nama_kriteria) }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('nama_kriteria') border-red-500 @enderror">
                    @error('nama_kriteria')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="bobot_persen" class="block text-sm font-medium text-gray-700 mb-1">Bobot (%) <span
                            class="text-red-500">*</span></label>
                    <input type="number" name="bobot_persen" id="bobot_persen"
                        value="{{ old('bobot_persen', $kriteria->bobot_persen) }}" required step="0.01" min="0" max="100"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('bobot_persen') border-red-500 @enderror">
                    @error('bobot_persen')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <a href="{{ route('kriteria.index') }}"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
@endsection