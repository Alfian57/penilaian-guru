@extends('layouts.app')

@section('title', 'Tambah Periode - Sistem Penilaian Guru')

@section('content')
    <div class="mb-6">
        <a href="{{ route('periode.index') }}" class="text-primary-600 hover:text-primary-800 flex items-center">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>
        <h1 class="text-2xl font-bold text-gray-800 mt-2">Tambah Periode Akademik</h1>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <form action="{{ route('periode.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label for="nama_periode" class="block text-sm font-medium text-gray-700 mb-1">Nama Periode <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="nama_periode" id="nama_periode" value="{{ old('nama_periode') }}" required
                        placeholder="Contoh: Semester Ganjil 2024/2025"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('nama_periode') border-red-500 @enderror">
                    @error('nama_periode')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Mulai <span
                            class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_mulai" id="tanggal_mulai" value="{{ old('tanggal_mulai') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('tanggal_mulai') border-red-500 @enderror">
                    @error('tanggal_mulai')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Selesai <span
                            class="text-red-500">*</span></label>
                    <input type="date" name="tanggal_selesai" id="tanggal_selesai" value="{{ old('tanggal_selesai') }}"
                        required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('tanggal_selesai') border-red-500 @enderror">
                    @error('tanggal_selesai')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="flex items-center">
                        <input type="checkbox" name="status_aktif" value="1" {{ old('status_aktif') ? 'checked' : '' }}
                            class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                        <span class="ml-2 text-sm text-gray-700">Jadikan sebagai periode aktif</span>
                    </label>
                    <p class="mt-1 text-xs text-gray-500">Mengaktifkan periode ini akan menonaktifkan periode lain yang
                        sedang aktif.</p>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <a href="{{ route('periode.index') }}"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">
                    Simpan
                </button>
            </div>
        </form>
    </div>
@endsection