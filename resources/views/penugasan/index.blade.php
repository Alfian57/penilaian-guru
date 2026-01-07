@extends('layouts.app')

@section('title', 'Penugasan Penilaian - Sistem Penilaian Guru')

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Penugasan Penilaian</h1>
            <p class="text-gray-600">Kelola penugasan penilai untuk menilai guru</p>
        </div>
        <div class="flex items-center space-x-2">
            <a href="{{ route('penugasan.batch.create') }}"
                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Penugasan Batch
            </a>
            <a href="{{ route('penugasan.create') }}"
                class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Tambah Penugasan
            </a>
        </div>
    </div>

    <!-- Filter -->
    <div class="bg-white rounded-xl shadow mb-6 p-4">
        <form action="{{ route('penugasan.index') }}" method="GET" class="flex flex-wrap gap-4">
            <div class="w-48">
                <select name="periode"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    <option value="">Semua Periode</option>
                    @foreach($periodeList as $p)
                        <option value="{{ $p->id }}" {{ request('periode') == $p->id ? 'selected' : '' }}>
                            {{ $p->nama_periode }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="w-48">
                <select name="status"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                    <option value="">Semua Status</option>
                    <option value="belum" {{ request('status') == 'belum' ? 'selected' : '' }}>Belum Dinilai</option>
                    <option value="sudah" {{ request('status') == 'sudah' ? 'selected' : '' }}>Sudah Dinilai</option>
                </select>
            </div>
            <button type="submit" class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700">
                Filter
            </button>
            <a href="{{ route('penugasan.index') }}"
                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                Reset
            </a>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Periode</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Penilai</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Guru Dinilai</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($penugasan as $index => $p)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $penugasan->firstItem() + $index }}</td>
                            <td class="px-6 py-4">
                                <span class="text-sm font-medium text-gray-800">{{ $p->periode->nama_periode }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-800">{{ $p->penilai->pengguna->nama_lengkap }}</div>
                                <div class="text-xs text-gray-500">{{ $p->penilai->jenis_penilai->label() }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-medium text-gray-800">{{ $p->guru->pengguna->nama_lengkap }}</div>
                                <div class="text-xs text-gray-500">{{ $p->guru->nip ?? 'Non-ASN' }}</div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                @if($p->hasilPenilaian)
                                    <span class="px-2 py-1 text-xs bg-green-100 text-green-800 rounded-full">Sudah Dinilai</span>
                                @else
                                    <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">Belum Dinilai</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center space-x-2">
                                    <a href="{{ route('penugasan.show', $p) }}"
                                        class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg" title="Lihat">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    @if(!$p->hasilPenilaian)
                                        <a href="{{ route('penugasan.edit', $p) }}"
                                            class="p-2 text-yellow-600 hover:bg-yellow-50 rounded-lg" title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('penugasan.destroy', $p) }}" method="POST" class="inline"
                                            onsubmit="return confirm('Yakin ingin menghapus penugasan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg" title="Hapus">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">Tidak ada data penugasan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($penugasan->hasPages())
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $penugasan->withQueryString()->links() }}
            </div>
        @endif
    </div>
@endsection