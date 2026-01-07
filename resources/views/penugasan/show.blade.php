@extends('layouts.app')

@section('title', 'Detail Penugasan - Sistem Penilaian Guru')

@section('content')
    <div class="mb-6">
        <a href="{{ route('penugasan.index') }}" class="text-primary-600 hover:text-primary-800 flex items-center">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>
        <h1 class="text-2xl font-bold text-gray-800 mt-2">Detail Penugasan</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Info Penugasan -->
        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Penugasan</h3>

            <div class="space-y-4">
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-gray-500">Periode</span>
                    <span class="font-medium">{{ $penugasan->periode->nama_periode }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-gray-500">Status</span>
                    @if($penugasan->hasilPenilaian)
                        <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Sudah Dinilai</span>
                    @else
                        <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">Belum Dinilai</span>
                    @endif
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-gray-500">Tanggal Dibuat</span>
                    <span class="font-medium">{{ $penugasan->dibuat_pada?->format('d M Y H:i') ?? '-' }}</span>
                </div>
            </div>
        </div>

        <!-- Info Penilai -->
        <div class="bg-white rounded-xl shadow p-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Penilai</h3>

            <div class="space-y-4">
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-gray-500">Nama</span>
                    <span class="font-medium">{{ $penugasan->penilai->pengguna->nama_lengkap }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-gray-500">Jenis</span>
                    <span
                        class="px-2 py-1 text-xs bg-primary-100 text-primary-800 rounded-full">{{ $penugasan->penilai->jenis_penilai->label() }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-gray-100">
                    <span class="text-gray-500">Email</span>
                    <span class="font-medium">{{ $penugasan->penilai->pengguna->email }}</span>
                </div>
            </div>
        </div>

        <!-- Info Guru -->
        <div class="bg-white rounded-xl shadow p-6 lg:col-span-2">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Guru Yang Dinilai</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="p-4 bg-gray-50 rounded-lg">
                    <div class="text-sm text-gray-500">Nama</div>
                    <div class="font-medium text-gray-800">{{ $penugasan->guru->pengguna->nama_lengkap }}</div>
                </div>
                <div class="p-4 bg-gray-50 rounded-lg">
                    <div class="text-sm text-gray-500">NIP</div>
                    <div class="font-medium text-gray-800">{{ $penugasan->guru->nip ?? '-' }}</div>
                </div>
                <div class="p-4 bg-gray-50 rounded-lg">
                    <div class="text-sm text-gray-500">Mata Pelajaran</div>
                    <div class="font-medium text-gray-800">{{ $penugasan->guru->mata_pelajaran }}</div>
                </div>
                <div class="p-4 bg-gray-50 rounded-lg">
                    <div class="text-sm text-gray-500">Email</div>
                    <div class="font-medium text-gray-800">{{ $penugasan->guru->pengguna->email }}</div>
                </div>
            </div>
        </div>

        <!-- Hasil Penilaian (jika sudah dinilai) -->
        @if($penugasan->hasilPenilaian)
            <div class="bg-white rounded-xl shadow p-6 lg:col-span-2">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Hasil Penilaian</h3>

                <div class="flex items-center space-x-8 mb-6">
                    <div class="text-center">
                        <div class="text-4xl font-bold text-primary-600">
                            {{ number_format($penugasan->hasilPenilaian->nilai_total, 2) }}
                        </div>
                        <div class="text-sm text-gray-500">Nilai Total</div>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl font-bold 
                                    @if($penugasan->hasilPenilaian->predikat == 'A') text-green-600
                                    @elseif($penugasan->hasilPenilaian->predikat == 'B') text-blue-600
                                    @elseif($penugasan->hasilPenilaian->predikat == 'C') text-yellow-600
                                    @else text-red-600
                                    @endif">
                            {{ $penugasan->hasilPenilaian->predikat }}
                        </div>
                        <div class="text-sm text-gray-500">Predikat</div>
                    </div>
                    <div>
                        <div class="text-sm text-gray-500">Tanggal Penilaian</div>
                        <div class="font-medium">{{ $penugasan->hasilPenilaian->tanggal_penilaian?->format('d M Y H:i') ?? '-' }}</div>
                    </div>
                </div>

                @if($penugasan->hasilPenilaian->komentar)
                    <div class="p-4 bg-gray-50 rounded-lg">
                        <div class="text-sm text-gray-500 mb-1">Komentar</div>
                        <div class="text-gray-800">{{ $penugasan->hasilPenilaian->komentar }}</div>
                    </div>
                @endif

                <div class="mt-4">
                    <a href="{{ route('penilaian.show', $penugasan->hasilPenilaian) }}"
                        class="text-primary-600 hover:text-primary-800 text-sm">
                        Lihat Detail Penilaian →
                    </a>
                </div>
            </div>
        @endif
    </div>

    <!-- Actions -->
    <div class="mt-6 flex items-center space-x-3">
        @if(!$penugasan->hasilPenilaian && (auth()->user()->isAdmin() || (auth()->user()->penilai && auth()->user()->penilai->id == $penugasan->penilai_id)))
            <a href="{{ route('penilaian.create', ['penugasan' => $penugasan->id]) }}"
                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                Lakukan Penilaian
            </a>
        @endif

        @if(!$penugasan->hasilPenilaian)
            <a href="{{ route('penugasan.edit', $penugasan) }}"
                class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">
                Edit
            </a>
            <form action="{{ route('penugasan.destroy', $penugasan) }}" method="POST"
                onsubmit="return confirm('Yakin ingin menghapus penugasan ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                    Hapus
                </button>
            </form>
        @endif
    </div>
@endsection