@extends('layouts.app')

@section('title', 'Penugasan Batch - Sistem Penilaian Guru')

@section('content')
<div class="mb-6">
    <a href="{{ route('penugasan.index') }}" class="text-primary-600 hover:text-primary-800 flex items-center">
        <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Kembali
    </a>
    <h1 class="text-2xl font-bold text-gray-800 mt-2">Penugasan Batch</h1>
    <p class="text-gray-600">Buat beberapa penugasan sekaligus</p>
</div>

<div class="bg-white rounded-xl shadow p-6">
    <form action="{{ route('penugasan.store-batch') }}" method="POST">
        @csrf
        
        <div class="space-y-6">
            <div>
                <label for="periode_id" class="block text-sm font-medium text-gray-700 mb-1">Periode Akademik <span class="text-red-500">*</span></label>
                <select name="periode_id" id="periode_id" required
                    class="w-full md:w-1/2 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('periode_id') border-red-500 @enderror">
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
                <label class="block text-sm font-medium text-gray-700 mb-3">Pilih Penilai <span class="text-red-500">*</span></label>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 max-h-64 overflow-y-auto p-4 border border-gray-200 rounded-lg">
                    @foreach($penilaiList as $p)
                    <label class="flex items-center space-x-2 cursor-pointer hover:bg-gray-50 p-2 rounded">
                        <input type="checkbox" name="penilai_ids[]" value="{{ $p->id }}" 
                            {{ in_array($p->id, old('penilai_ids', [])) ? 'checked' : '' }}
                            class="w-4 h-4 text-primary-600 rounded focus:ring-primary-500">
                        <div>
                            <div class="text-sm font-medium text-gray-700">{{ $p->pengguna->nama_lengkap }}</div>
                            <div class="text-xs text-gray-500">{{ $p->jenis_penilai->label() }}</div>
                        </div>
                    </label>
                    @endforeach
                </div>
                @error('penilai_ids')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-3">Pilih Guru <span class="text-red-500">*</span></label>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 max-h-64 overflow-y-auto p-4 border border-gray-200 rounded-lg">
                    @foreach($guruList as $g)
                    <label class="flex items-center space-x-2 cursor-pointer hover:bg-gray-50 p-2 rounded">
                        <input type="checkbox" name="guru_ids[]" value="{{ $g->id }}" 
                            {{ in_array($g->id, old('guru_ids', [])) ? 'checked' : '' }}
                            class="w-4 h-4 text-primary-600 rounded focus:ring-primary-500">
                        <div>
                            <div class="text-sm font-medium text-gray-700">{{ $g->pengguna->nama_lengkap }}</div>
                            <div class="text-xs text-gray-500">{{ $g->mata_pelajaran }}</div>
                        </div>
                    </label>
                    @endforeach
                </div>
                @error('guru_ids')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
            <p class="text-sm text-blue-800">
                <strong>Info:</strong> Sistem akan membuat penugasan untuk setiap kombinasi penilai dan guru yang dipilih. Penugasan yang sudah ada sebelumnya akan dilewati.
            </p>
        </div>
        
        <div class="mt-6 flex items-center justify-end space-x-3">
            <a href="{{ route('penugasan.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                Batal
            </a>
            <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">
                Buat Penugasan
            </button>
        </div>
    </form>
</div>
@endsection
