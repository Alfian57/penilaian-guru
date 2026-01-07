@extends('layouts.app')

@section('title', 'Dashboard - Sistem Penilaian Guru')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Dashboard</h1>
        <p class="text-gray-600">Selamat datang, {{ $user->nama_lengkap }}!</p>
    </div>

    @if($user->isAdmin() || $user->isKepsek())
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-blue-100 rounded-lg">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">Total Pengguna</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $data['total_pengguna'] ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-green-100 rounded-lg">
                        <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">Total Guru</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $data['total_guru'] ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-yellow-100 rounded-lg">
                        <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">Penilaian Pending</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $data['penugasan_pending'] ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow p-6">
                <div class="flex items-center">
                    <div class="p-3 bg-purple-100 rounded-lg">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm text-gray-500">Penilaian Selesai</p>
                        <p class="text-2xl font-bold text-gray-800">{{ $data['penugasan_selesai'] ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Periode Aktif -->
        @if(isset($data['periode_aktif']) && $data['periode_aktif'])
            <div class="bg-gradient-to-r from-primary-500 to-primary-700 rounded-xl shadow p-6 mb-8 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-primary-100 text-sm">Periode Aktif</p>
                        <h2 class="text-2xl font-bold mt-1">{{ $data['periode_aktif']->nama_periode }}</h2>
                        <p class="text-primary-100 mt-2">
                            {{ $data['periode_aktif']->tanggal_mulai->format('d M Y') }} -
                            {{ $data['periode_aktif']->tanggal_selesai->format('d M Y') }}
                        </p>
                    </div>
                    <div class="p-4 bg-white bg-opacity-20 rounded-lg">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                </div>
            </div>
        @endif

        <!-- Statistik Penilaian Guru -->
        @if(isset($data['statistik_guru']) && $data['statistik_guru']->isNotEmpty())
            <div class="bg-white rounded-xl shadow overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Statistik Penilaian Guru</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Guru</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">NIP</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Jumlah Penilaian</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Rata-rata Skor</th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Grade</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($data['statistik_guru']->sortByDesc('rata_rata')->take(10) as $stat)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm text-gray-800">{{ $stat['nama'] }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $stat['nip'] ?? '-' }}</td>
                                    <td class="px-6 py-4 text-sm text-center text-gray-600">{{ $stat['jumlah_penilaian'] }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <span
                                            class="text-sm font-medium {{ $stat['rata_rata'] >= 80 ? 'text-green-600' : ($stat['rata_rata'] >= 60 ? 'text-yellow-600' : 'text-red-600') }}">
                                            {{ $stat['rata_rata'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @php
                                            $grade = $stat['rata_rata'] >= 90 ? 'A' : ($stat['rata_rata'] >= 80 ? 'B' : ($stat['rata_rata'] >= 70 ? 'C' : ($stat['rata_rata'] >= 60 ? 'D' : 'E')));
                                            $gradeColor = $grade === 'A' ? 'bg-green-100 text-green-800' : ($grade === 'B' ? 'bg-blue-100 text-blue-800' : ($grade === 'C' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800'));
                                        @endphp
                                        <span class="px-2 py-1 text-xs font-medium rounded-full {{ $gradeColor }}">{{ $grade }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    @endif

    @if($user->isGuru())
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Tugas Menilai -->
            @if(isset($data['tugas_menilai']) && $data['tugas_menilai']->isNotEmpty())
                <div class="bg-white rounded-xl shadow overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-800">Tugas Menilai Anda</h3>
                        <span
                            class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">{{ $data['tugas_menilai']->count() }}
                            Pending</span>
                    </div>
                    <div class="divide-y divide-gray-200">
                        @foreach($data['tugas_menilai'] as $tugas)
                            <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50">
                                <div>
                                    <p class="font-medium text-gray-800">{{ $tugas->guru->pengguna->nama_lengkap }}</p>
                                    <p class="text-sm text-gray-500">{{ $tugas->periode->nama_periode }}</p>
                                </div>
                                <a href="{{ route('penilaian.create', $tugas) }}"
                                    class="px-4 py-2 bg-primary-600 text-white text-sm rounded-lg hover:bg-primary-700">
                                    Nilai
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Penilaian yang Diterima -->
            @if(isset($data['penilaian_diterima']) && $data['penilaian_diterima']->isNotEmpty())
                <div class="bg-white rounded-xl shadow overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">Penilaian Terbaru untuk Anda</h3>
                    </div>
                    <div class="divide-y divide-gray-200">
                        @foreach($data['penilaian_diterima'] as $penilaian)
                            <div class="px-6 py-4 hover:bg-gray-50">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium text-gray-800">{{ $penilaian->penilai->pengguna->nama_lengkap }}</p>
                                        <p class="text-sm text-gray-500">{{ $penilaian->penilai->jenis_penilai->label() }} -
                                            {{ $penilaian->periode->nama_periode }}</p>
                                    </div>
                                    @if($penilaian->status === 'selesai' && $penilaian->hasilPenilaian)
                                        <div class="text-right">
                                            <p class="text-lg font-bold text-primary-600">
                                                {{ number_format($penilaian->hasilPenilaian->total_skor, 2) }}</p>
                                            <p class="text-xs text-gray-500">Skor</p>
                                        </div>
                                    @else
                                        <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">Pending</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    @endif

    @if($user->isSiswa())
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Tugas Menilai -->
            @if(isset($data['tugas_menilai']) && $data['tugas_menilai']->isNotEmpty())
                <div class="bg-white rounded-xl shadow overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-gray-800">Guru yang Perlu Dinilai</h3>
                        <span
                            class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">{{ $data['tugas_menilai']->count() }}
                            Pending</span>
                    </div>
                    <div class="divide-y divide-gray-200">
                        @foreach($data['tugas_menilai'] as $tugas)
                            <div class="px-6 py-4 flex items-center justify-between hover:bg-gray-50">
                                <div>
                                    <p class="font-medium text-gray-800">{{ $tugas->guru->pengguna->nama_lengkap }}</p>
                                    <p class="text-sm text-gray-500">{{ $tugas->periode->nama_periode }}</p>
                                </div>
                                <a href="{{ route('penilaian.create', $tugas) }}"
                                    class="px-4 py-2 bg-primary-600 text-white text-sm rounded-lg hover:bg-primary-700">
                                    Nilai
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Penilaian Selesai -->
            @if(isset($data['penilaian_selesai']) && $data['penilaian_selesai']->isNotEmpty())
                <div class="bg-white rounded-xl shadow overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">Riwayat Penilaian</h3>
                    </div>
                    <div class="divide-y divide-gray-200">
                        @foreach($data['penilaian_selesai'] as $penilaian)
                            <div class="px-6 py-4 hover:bg-gray-50">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium text-gray-800">{{ $penilaian->guru->pengguna->nama_lengkap }}</p>
                                        <p class="text-sm text-gray-500">{{ $penilaian->periode->nama_periode }}</p>
                                    </div>
                                    <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Selesai</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    @endif
@endsection