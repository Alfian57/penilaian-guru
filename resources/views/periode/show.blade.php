@extends('layouts.app')

@section('title', 'Detail Periode - Sistem Penilaian Guru')

@section('content')
    <div class="mb-6">
        <a href="{{ route('periode.index') }}" class="text-primary-600 hover:text-primary-800 flex items-center">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>
        <h1 class="text-2xl font-bold text-gray-800 mt-2">Detail Periode Akademik</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-gray-800">{{ $periode->nama_periode }}</h2>
                    @if($periode->status_aktif)
                        <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Aktif</span>
                    @else
                        <span class="px-2 py-1 text-xs bg-gray-100 text-gray-800 rounded-full">Non-Aktif</span>
                    @endif
                </div>

                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-500">Tanggal Mulai</p>
                        <p class="font-medium text-gray-800">{{ $periode->tanggal_mulai->format('d F Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Tanggal Selesai</p>
                        <p class="font-medium text-gray-800">{{ $periode->tanggal_selesai->format('d F Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Durasi</p>
                        <p class="font-medium text-gray-800">
                            {{ $periode->tanggal_mulai->diffInDays($periode->tanggal_selesai) }} hari
                        </p>
                    </div>
                </div>

                <div class="mt-6 pt-6 border-t border-gray-200 flex items-center justify-center space-x-3">
                    <a href="{{ route('periode.edit', $periode) }}"
                        class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">
                        Edit
                    </a>
                    @if(!$periode->status_aktif)
                        <form action="{{ route('periode.activate', $periode) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">
                                Aktifkan
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Penugasan Penilaian</h3>
                </div>

                @if($periode->penugasanPenilaian->isNotEmpty())
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Guru Dinilai
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Penilai</th>
                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($periode->penugasanPenilaian as $penugasan)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 text-sm text-gray-800">{{ $penugasan->guru->pengguna->nama_lengkap }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600">
                                            {{ $penugasan->penilai->pengguna->nama_lengkap }}
                                            <span
                                                class="text-xs text-gray-400">({{ $penugasan->penilai->jenis_penilai->label() }})</span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            @if($penugasan->status === 'selesai')
                                                <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Selesai</span>
                                            @else
                                                <span
                                                    class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">Pending</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="px-6 py-8 text-center text-gray-500">
                        Belum ada penugasan penilaian
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection