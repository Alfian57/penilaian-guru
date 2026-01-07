@extends('layouts.app')

@section('title', 'Tambah Pengguna - Sistem Penilaian Guru')

@section('content')
    <div class="mb-6">
        <a href="{{ route('pengguna.index') }}" class="text-primary-600 hover:text-primary-800 flex items-center">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>
        <h1 class="text-2xl font-bold text-gray-800 mt-2">Tambah Pengguna Baru</h1>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <form action="{{ route('pengguna.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="nama_lengkap" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('nama_lengkap') border-red-500 @enderror">
                    @error('nama_lengkap')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email <span
                            class="text-red-500">*</span></label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password <span
                            class="text-red-500">*</span></label>
                    <input type="password" name="password" id="password" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('password') border-red-500 @enderror">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi
                        Password <span class="text-red-500">*</span></label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                </div>

                <div>
                    <label for="peran" class="block text-sm font-medium text-gray-700 mb-1">Peran <span
                            class="text-red-500">*</span></label>
                    <select name="peran" id="peran" required onchange="toggleFields()"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('peran') border-red-500 @enderror">
                        <option value="">Pilih Peran</option>
                        @foreach($peranList as $peran)
                            <option value="{{ $peran->value }}" {{ old('peran') === $peran->value ? 'selected' : '' }}>
                                {{ $peran->label() }}
                            </option>
                        @endforeach
                    </select>
                    @error('peran')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="jenis_penilai" class="block text-sm font-medium text-gray-700 mb-1">Jenis Penilai</label>
                    <select name="jenis_penilai" id="jenis_penilai"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        <option value="">Tidak Sebagai Penilai</option>
                        @foreach($jenisPenilaiList as $jenis)
                            <option value="{{ $jenis->value }}" {{ old('jenis_penilai') === $jenis->value ? 'selected' : '' }}>
                                {{ $jenis->label() }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Fields untuk Guru -->
            <div id="guru-fields" class="mt-6 p-4 bg-gray-50 rounded-lg hidden">
                <h3 class="text-lg font-medium text-gray-800 mb-4">Data Guru</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nip" class="block text-sm font-medium text-gray-700 mb-1">NIP</label>
                        <input type="text" name="nip" id="nip" value="{{ old('nip') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    </div>

                    <div>
                        <label for="jabatan" class="block text-sm font-medium text-gray-700 mb-1">Jabatan</label>
                        <input type="text" name="jabatan" id="jabatan" value="{{ old('jabatan') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    </div>
                </div>
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <a href="{{ route('pengguna.index') }}"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">
                    Simpan
                </button>
            </div>
        </form>
    </div>

    <script>
        function toggleFields() {
            const peran = document.getElementById('peran').value;
            const guruFields = document.getElementById('guru-fields');

            if (peran === 'guru' || peran === 'kepsek') {
                guruFields.classList.remove('hidden');
            } else {
                guruFields.classList.add('hidden');
            }
        }

        // Run on page load
        document.addEventListener('DOMContentLoaded', toggleFields);
    </script>
@endsection