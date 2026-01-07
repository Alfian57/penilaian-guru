@extends('layouts.app')

@section('title', 'Detail Pengguna - Sistem Penilaian Guru')

@section('content')
    <div class="mb-6">
        <a href="{{ route('pengguna.index') }}" class="text-primary-600 hover:text-primary-800 flex items-center">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>
        <h1 class="text-2xl font-bold text-gray-800 mt-2">Detail Pengguna</h1>
    </div>

    <div class="bg-white rounded-xl shadow p-6">
        <div class="flex items-center mb-6">
            <div class="w-16 h-16 bg-primary-100 rounded-full flex items-center justify-center">
                <span
                    class="text-2xl font-bold text-primary-600">{{ strtoupper(substr($pengguna->nama_lengkap, 0, 2)) }}</span>
            </div>
            <div class="ml-4">
                <h2 class="text-xl font-bold text-gray-800">{{ $pengguna->nama_lengkap }}</h2>
                <p class="text-gray-600">{{ $pengguna->email }}</p>
                <span
                    class="inline-block mt-1 px-2 py-1 text-xs rounded-full {{ $pengguna->peran->value === 'admin' ? 'bg-red-100 text-red-800' : ($pengguna->peran->value === 'kepsek' ? 'bg-purple-100 text-purple-800' : ($pengguna->peran->value === 'guru' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800')) }}">
                    {{ $pengguna->peran->label() }}
                </span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-sm font-medium text-gray-500">Terdaftar Pada</h3>
                <p class="mt-1 text-gray-800">{{ $pengguna->dibuat_pada->format('d F Y H:i') }}</p>
            </div>

            <div>
                <h3 class="text-sm font-medium text-gray-500">Terakhir Diperbarui</h3>
                <p class="mt-1 text-gray-800">{{ $pengguna->diperbarui_pada->format('d F Y H:i') }}</p>
            </div>

            @if($pengguna->guru)
                <div>
                    <h3 class="text-sm font-medium text-gray-500">NIP</h3>
                    <p class="mt-1 text-gray-800">{{ $pengguna->guru->nip ?? '-' }}</p>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-500">Jabatan</h3>
                    <p class="mt-1 text-gray-800">{{ $pengguna->guru->jabatan ?? '-' }}</p>
                </div>
            @endif

            @if($pengguna->penilai)
                <div>
                    <h3 class="text-sm font-medium text-gray-500">Jenis Penilai</h3>
                    <p class="mt-1 text-gray-800">{{ $pengguna->penilai->jenis_penilai->label() }}</p>
                </div>
            @endif
        </div>

        <div class="mt-6 pt-6 border-t border-gray-200 flex items-center space-x-3">
            <a href="{{ route('pengguna.edit', $pengguna) }}"
                class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">
                Edit
            </a>
            <form action="{{ route('pengguna.destroy', $pengguna) }}" method="POST"
                onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                    Hapus
                </button>
            </form>
        </div>
    </div>
@endsection