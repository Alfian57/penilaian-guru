@extends('layouts.app')

@section('title', 'Form Penilaian - Sistem Penilaian Guru')

@section('content')
    <div class="mb-6">
        <a href="{{ route('penilaian.index') }}" class="text-primary-600 hover:text-primary-800 flex items-center">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>
        <h1 class="text-2xl font-bold text-gray-800 mt-2">Form Penilaian</h1>
    </div>

    <!-- Info Guru -->
    <div class="bg-white rounded-xl shadow p-6 mb-6">
        <div class="flex items-center">
            <div
                class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center text-primary-600 text-2xl font-bold mr-4">
                {{ strtoupper(substr($penugasan->guru->pengguna->nama_lengkap, 0, 1)) }}
            </div>
            <div>
                <h2 class="text-xl font-semibold text-gray-800">{{ $penugasan->guru->pengguna->nama_lengkap }}</h2>
                <p class="text-gray-600">{{ $penugasan->guru->mata_pelajaran }}</p>
                <p class="text-sm text-gray-500">{{ $penugasan->periode->nama_periode }}</p>
            </div>
        </div>
    </div>

    <!-- Form Penilaian -->
    <form action="{{ route('penilaian.store') }}" method="POST" id="formPenilaian">
        @csrf
        <input type="hidden" name="penugasan_id" value="{{ $penugasan->id }}">

        @foreach($kriteriaWithIndikator as $kriteria)
            <div class="bg-white rounded-xl shadow mb-6">
                <div class="p-4 bg-primary-50 border-b border-primary-100 rounded-t-xl">
                    <div class="flex items-center justify-between">
                        <h3 class="font-semibold text-primary-800">{{ $kriteria->nama_kriteria }}</h3>
                        <span class="text-sm text-primary-600">Bobot: {{ number_format($kriteria->bobot_persen, 2) }}%</span>
                    </div>
                </div>

                <div class="p-6 space-y-6">
                    @foreach($kriteria->indikator as $indikator)
                        <div class="border-b border-gray-100 pb-4 last:border-0 last:pb-0">
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                {{ $loop->iteration }}. {{ $indikator->pertanyaan }}
                            </label>

                            <div class="flex flex-wrap gap-2">
                                @for($i = 1; $i <= $indikator->skala_maksimal; $i++)
                                    <label class="relative cursor-pointer">
                                        <input type="radio" name="nilai[{{ $indikator->id }}]" value="{{ $i }}" required
                                            class="peer sr-only" {{ old("nilai.{$indikator->id}") == $i ? 'checked' : '' }}>
                                        <div class="w-12 h-12 flex items-center justify-center border-2 border-gray-200 rounded-lg text-gray-600 font-medium
                                            peer-checked:border-primary-600 peer-checked:bg-primary-600 peer-checked:text-white
                                            hover:border-primary-400 transition-all">
                                            {{ $i }}
                                        </div>
                                    </label>
                                @endfor
                            </div>

                            <div class="mt-2 flex items-center justify-between text-xs text-gray-500">
                                <span>1 = Kurang</span>
                                <span>{{ $indikator->skala_maksimal }} = Sangat Baik</span>
                            </div>

                            @error("nilai.{$indikator->id}")
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        <!-- Saran/Masukan -->
        <div class="bg-white rounded-xl shadow p-6 mb-6">
            <label for="saran_masukan" class="block text-sm font-medium text-gray-700 mb-2">Saran / Masukan (Opsional)</label>
            <textarea name="saran_masukan" id="saran_masukan" rows="4"
                placeholder="Berikan saran atau masukan untuk guru yang dinilai..."
                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">{{ old('saran_masukan') }}</textarea>
        </div>

        <!-- Submit -->
        <div class="flex items-center justify-end space-x-3">
            <a href="{{ route('penilaian.index') }}"
                class="px-6 py-3 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                Batal
            </a>
            <button type="submit" class="px-6 py-3 bg-primary-600 text-white rounded-lg hover:bg-primary-700"
                onclick="return confirm('Yakin ingin mengirim penilaian ini? Penilaian yang sudah dikirim tidak dapat diubah.')">
                Kirim Penilaian
            </button>
        </div>
    </form>
@endsection