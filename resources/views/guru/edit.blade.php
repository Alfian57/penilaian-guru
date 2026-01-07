@extends('layouts.app')

@section('title', 'Edit Guru - Sistem Penilaian Guru')

@section('content')
    <div class="mb-6">
        <a href="{{ route('guru.index') }}" class="text-primary-600 hover:text-primary-800 flex items-center">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>
        <h1 class="text-2xl font-bold text-gray-800 mt-2">Edit Data Guru</h1>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
            <p class="text-sm text-gray-500">Pengguna</p>
            <p class="font-medium text-gray-800">{{ $guru->pengguna->nama_lengkap }}</p>
            <p class="text-sm text-gray-600">{{ $guru->pengguna->email }}</p>
        </div>

        <form action="{{ route('guru.update', $guru) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nip" class="block text-sm font-medium text-gray-700 mb-1">NIP</label>
                    <input type="text" name="nip" id="nip" value="{{ old('nip', $guru->nip) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('nip') border-red-500 @enderror">
                    @error('nip')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="jabatan" class="block text-sm font-medium text-gray-700 mb-1">Jabatan</label>
                    <input type="text" name="jabatan" id="jabatan" value="{{ old('jabatan', $guru->jabatan) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('jabatan') border-red-500 @enderror">
                    @error('jabatan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <a href="{{ route('guru.index') }}"
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