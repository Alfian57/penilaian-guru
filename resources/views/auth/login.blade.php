@extends('layouts.app')

@section('title', 'Login - Sistem Penilaian Guru')

@section('content')
    <div class="w-full max-w-md">
        <div class="bg-white rounded-xl shadow-lg p-8">
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-primary-800">SPG</h1>
                <p class="text-gray-600 mt-2">Sistem Penilaian Guru</p>
            </div>

            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('email') border-red-500 @enderror"
                        placeholder="masukkan@email.anda">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" id="password" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                        placeholder="••••••••">
                </div>

                <div class="flex items-center mb-6">
                    <input type="checkbox" name="remember" id="remember"
                        class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                    <label for="remember" class="ml-2 text-sm text-gray-600">Ingat saya</label>
                </div>

                <button type="submit"
                    class="w-full bg-primary-600 text-white py-2 px-4 rounded-lg hover:bg-primary-700 focus:ring-4 focus:ring-primary-300 font-medium transition">
                    Masuk
                </button>
            </form>
        </div>
    </div>
@endsection