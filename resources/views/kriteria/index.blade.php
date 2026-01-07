@extends('layouts.app')

@section('title', 'Kelola Kriteria - Sistem Penilaian Guru')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Kelola Kriteria</h1>
            <p class="text-gray-600">Kelola kategori penilaian guru</p>
        </div>
        <a href="{{ route('kriteria.create') }}"
            class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Tambah Kriteria
        </a>
    </div>

    <!-- Info Total Bobot -->
    @php
        $totalBobot = $kriteria->sum('bobot_persen');
    @endphp
    <div
        class="mb-6 p-4 rounded-lg {{ $totalBobot == 100 ? 'bg-green-100 border border-green-400' : 'bg-yellow-100 border border-yellow-400' }}">
        <div class="flex items-center">
            @if($totalBobot == 100)
                <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-green-800">Total bobot kriteria: <strong>{{ $totalBobot }}%</strong> (Sudah sesuai)</span>
            @else
                <svg class="w-5 h-5 text-yellow-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <span class="text-yellow-800">Total bobot kriteria: <strong>{{ $totalBobot }}%</strong> (Harus 100%)</span>
            @endif
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Kriteria</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Bobot (%)</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Jumlah Indikator</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($kriteria as $index => $k)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $kriteria->firstItem() + $index }}</td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-800">{{ $k->nama_kriteria }}</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-3 py-1 text-sm font-medium bg-primary-100 text-primary-800 rounded-full">
                                    {{ number_format($k->bobot_persen, 2) }}%
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center text-sm text-gray-600">{{ $k->indikator_count }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center space-x-2">
                                    <a href="{{ route('kriteria.show', $k) }}"
                                        class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg" title="Lihat">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('kriteria.edit', $k) }}"
                                        class="p-2 text-yellow-600 hover:bg-yellow-50 rounded-lg" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('kriteria.destroy', $k) }}" method="POST" class="inline"
                                        onsubmit="return confirm('Yakin ingin menghapus kriteria ini? Semua indikator terkait akan ikut terhapus.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg" title="Hapus">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-gray-500">Tidak ada data kriteria</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($kriteria->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $kriteria->links() }}
            </div>
        @endif
    </div>
@endsection