@extends('layouts.app')

@section('title', 'Edit Indikator - Sistem Penilaian Guru')

@section('content')
    <div class="mb-6">
        <a href="{{ route('indikator.index') }}" class="text-primary-600 hover:text-primary-800 flex items-center">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>
        <h1 class="text-2xl font-bold text-gray-800 mt-2">Edit Indikator</h1>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <form action="{{ route('indikator.update', $indikator) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <div>
                    <label for="kriteria_id" class="block text-sm font-medium text-gray-700 mb-1">Kriteria <span
                            class="text-red-500">*</span></label>
                    <select name="kriteria_id" id="kriteria_id" required
                        class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('kriteria_id') border-red-500 @enderror">
                        @foreach($kriteriaList as $k)
                            <option value="{{ $k->id }}" {{ old('kriteria_id', $indikator->kriteria_id) == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kriteria }} ({{ number_format($k->bobot_persen, 2) }}%)
                            </option>
                        @endforeach
                    </select>
                    @error('kriteria_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="pertanyaan" class="block text-sm font-medium text-gray-700 mb-1">Pertanyaan / Indikator
                        <span class="text-red-500">*</span></label>
                    <textarea name="pertanyaan" id="pertanyaan" rows="4" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('pertanyaan') border-red-500 @enderror">{{ old('pertanyaan', $indikator->pertanyaan) }}</textarea>
                    @error('pertanyaan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="skala_maksimal" class="block text-sm font-medium text-gray-700 mb-1">Skala Maksimal <span
                            class="text-red-500">*</span></label>
                    <input type="number" name="skala_maksimal" id="skala_maksimal"
                        value="{{ old('skala_maksimal', $indikator->skala_maksimal) }}" required min="1" max="10"
                        class="w-full md:w-48 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('skala_maksimal') border-red-500 @enderror">
                    @error('skala_maksimal')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <a href="{{ route('indikator.index') }}"
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