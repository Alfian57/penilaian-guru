@extends('layouts.app')

@section('title', 'Tambah Penilai - Sistem Penilaian Guru')

@section('content')
    <div class="mb-6">
        <a href="{{ route('penilai.index') }}" class="text-primary-600 hover:text-primary-800 flex items-center">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>
        <h1 class="text-2xl font-bold text-gray-800 mt-2">Tambah Penilai</h1>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <form action="{{ route('penilai.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="pengguna_id" class="block text-sm font-medium text-gray-700 mb-1">Pilih Pengguna <span
                            class="text-red-500">*</span></label>
                    <select name="pengguna_id" id="pengguna_id" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('pengguna_id') border-red-500 @enderror">
                        <option value="">Pilih Pengguna</option>
                        @foreach($penggunaList as $p)
                            <option value="{{ $p->id }}" {{ old('pengguna_id') == $p->id ? 'selected' : '' }}>
                                {{ $p->nama_lengkap }} ({{ $p->peran->label() }})
                            </option>
                        @endforeach
                    </select>
                    @error('pengguna_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="jenis_penilai" class="block text-sm font-medium text-gray-700 mb-1">Jenis Penilai <span
                            class="text-red-500">*</span></label>
                    <select name="jenis_penilai" id="jenis_penilai" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('jenis_penilai') border-red-500 @enderror">
                        <option value="">Pilih Jenis</option>
                        <option value="atasan" {{ old('jenis_penilai') === 'atasan' ? 'selected' : '' }}>Atasan (Kepala
                            Sekolah)</option>
                        <option value="sejawat" {{ old('jenis_penilai') === 'sejawat' ? 'selected' : '' }}>Sejawat (Guru Lain)
                        </option>
                        <option value="siswa" {{ old('jenis_penilai') === 'siswa' ? 'selected' : '' }}>Siswa</option>
                    </select>
                    @error('jenis_penilai')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <a href="{{ route('penilai.index') }}"
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