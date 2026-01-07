@extends('layouts.app')

@section('title', 'Tambah Penugasan - Sistem Penilaian Guru')

@section('content')
    <div class="mb-6">
        <a href="{{ route('penugasan.index') }}" class="text-primary-600 hover:text-primary-800 flex items-center">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>
        <h1 class="text-2xl font-bold text-gray-800 mt-2">Tambah Penugasan</h1>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <form action="{{ route('penugasan.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="periode_id" class="block text-sm font-medium text-gray-700 mb-1">Periode Akademik <span
                            class="text-red-500">*</span></label>
                    <select name="periode_id" id="periode_id" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('periode_id') border-red-500 @enderror">
                        <option value="">Pilih Periode</option>
                        @foreach($periodeList as $p)
                            <option value="{{ $p->id }}" {{ old('periode_id') == $p->id ? 'selected' : '' }}>
                                {{ $p->nama_periode }}
                                @if($p->status_aktif) (Aktif) @endif
                            </option>
                        @endforeach
                    </select>
                    @error('periode_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="penilai_id" class="block text-sm font-medium text-gray-700 mb-1">Penilai <span
                            class="text-red-500">*</span></label>
                    <select name="penilai_id" id="penilai_id" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('penilai_id') border-red-500 @enderror">
                        <option value="">Pilih Penilai</option>
                        @foreach($penilaiList as $p)
                            <option value="{{ $p->id }}" {{ old('penilai_id') == $p->id ? 'selected' : '' }}>
                                {{ $p->pengguna->nama_lengkap }} ({{ $p->jenis_penilai->label() }})
                            </option>
                        @endforeach
                    </select>
                    @error('penilai_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label for="guru_id" class="block text-sm font-medium text-gray-700 mb-1">Guru Yang Dinilai <span
                            class="text-red-500">*</span></label>
                    <select name="guru_id" id="guru_id" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('guru_id') border-red-500 @enderror">
                        <option value="">Pilih Guru</option>
                        @foreach($guruList as $g)
                            <option value="{{ $g->id }}" {{ old('guru_id') == $g->id ? 'selected' : '' }}>
                                {{ $g->pengguna->nama_lengkap }} - {{ $g->nip ?? 'Non-ASN' }} ({{ $g->mata_pelajaran }})
                            </option>
                        @endforeach
                    </select>
                    @error('guru_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                <p class="text-sm text-yellow-800">
                    <strong>Catatan:</strong> Pastikan kombinasi penilai dan guru belum ditugaskan pada periode yang sama.
                    Sistem akan menolak penugasan duplikat.
                </p>
            </div>

            <div class="mt-6 flex items-center justify-end space-x-3">
                <a href="{{ route('penugasan.index') }}"
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