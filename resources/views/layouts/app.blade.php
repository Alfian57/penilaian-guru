<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem Penilaian Guru')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-100 min-h-screen">
    @auth
        <div x-data="{ sidebarOpen: false }" class="flex h-screen overflow-hidden">
            <!-- Sidebar Overlay -->
            <div x-show="sidebarOpen" x-cloak class="fixed inset-0 z-20 bg-black bg-opacity-50 lg:hidden"
                @click="sidebarOpen = false"></div>

            <!-- Sidebar -->
            <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
                class="fixed inset-y-0 left-0 z-30 w-64 bg-primary-800 text-white transform transition-transform duration-300 lg:translate-x-0 lg:static lg:inset-0">
                <div class="flex items-center justify-between h-16 px-6 bg-primary-900">
                    <span class="text-xl font-bold">SPG</span>
                    <button @click="sidebarOpen = false" class="lg:hidden">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <nav class="mt-6 px-4">
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center px-4 py-3 text-white rounded-lg hover:bg-primary-700 {{ request()->routeIs('dashboard') ? 'bg-primary-700' : '' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Dashboard
                    </a>

                    @if(auth()->user()->isAdmin() || auth()->user()->isKepsek())
                        <div class="mt-4">
                            <p class="px-4 text-xs font-semibold text-primary-300 uppercase tracking-wider">Master Data</p>
                            <a href="{{ route('pengguna.index') }}"
                                class="flex items-center px-4 py-3 mt-2 text-white rounded-lg hover:bg-primary-700 {{ request()->routeIs('pengguna.*') ? 'bg-primary-700' : '' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                Pengguna
                            </a>
                            <a href="{{ route('guru.index') }}"
                                class="flex items-center px-4 py-3 mt-1 text-white rounded-lg hover:bg-primary-700 {{ request()->routeIs('guru.*') ? 'bg-primary-700' : '' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                Guru
                            </a>
                            <a href="{{ route('penilai.index') }}"
                                class="flex items-center px-4 py-3 mt-1 text-white rounded-lg hover:bg-primary-700 {{ request()->routeIs('penilai.*') ? 'bg-primary-700' : '' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                </svg>
                                Penilai
                            </a>
                            <a href="{{ route('periode.index') }}"
                                class="flex items-center px-4 py-3 mt-1 text-white rounded-lg hover:bg-primary-700 {{ request()->routeIs('periode.*') ? 'bg-primary-700' : '' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Periode Akademik
                            </a>
                        </div>

                        <div class="mt-4">
                            <p class="px-4 text-xs font-semibold text-primary-300 uppercase tracking-wider">Kriteria & Indikator
                            </p>
                            <a href="{{ route('kriteria.index') }}"
                                class="flex items-center px-4 py-3 mt-2 text-white rounded-lg hover:bg-primary-700 {{ request()->routeIs('kriteria.*') ? 'bg-primary-700' : '' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                                Kriteria
                            </a>
                            <a href="{{ route('indikator.index') }}"
                                class="flex items-center px-4 py-3 mt-1 text-white rounded-lg hover:bg-primary-700 {{ request()->routeIs('indikator.*') ? 'bg-primary-700' : '' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Indikator
                            </a>
                        </div>

                        <div class="mt-4">
                            <p class="px-4 text-xs font-semibold text-primary-300 uppercase tracking-wider">Penugasan</p>
                            <a href="{{ route('penugasan.index') }}"
                                class="flex items-center px-4 py-3 mt-2 text-white rounded-lg hover:bg-primary-700 {{ request()->routeIs('penugasan.*') ? 'bg-primary-700' : '' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                Penugasan Penilaian
                            </a>
                        </div>

                        <div class="mt-4">
                            <p class="px-4 text-xs font-semibold text-primary-300 uppercase tracking-wider">Laporan</p>
                            <a href="{{ route('laporan.index') }}"
                                class="flex items-center px-4 py-3 mt-2 text-white rounded-lg hover:bg-primary-700 {{ request()->routeIs('laporan.*') ? 'bg-primary-700' : '' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Laporan Penilaian
                            </a>
                        </div>
                    @endif

                    @if(auth()->user()->penilai)
                        <div class="mt-4">
                            <p class="px-4 text-xs font-semibold text-primary-300 uppercase tracking-wider">Penilaian</p>
                            <a href="{{ route('penilaian.index') }}"
                                class="flex items-center px-4 py-3 mt-2 text-white rounded-lg hover:bg-primary-700 {{ request()->routeIs('penilaian.*') ? 'bg-primary-700' : '' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                </svg>
                                Form Penilaian
                            </a>
                        </div>
                    @endif
                </nav>
            </aside>

            <!-- Main Content -->
            <div class="flex-1 flex flex-col overflow-hidden">
                <!-- Header -->
                <header class="bg-white shadow-sm z-10">
                    <div class="flex items-center justify-between h-16 px-6">
                        <button @click="sidebarOpen = true" class="lg:hidden">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>

                        <div class="flex items-center">
                            <span class="text-gray-700 mr-4">{{ auth()->user()->nama_lengkap }}</span>
                            <span
                                class="px-2 py-1 text-xs rounded-full {{ auth()->user()->peran->value === 'admin' ? 'bg-red-100 text-red-800' : (auth()->user()->peran->value === 'kepsek' ? 'bg-purple-100 text-purple-800' : (auth()->user()->peran->value === 'guru' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800')) }}">
                                {{ auth()->user()->peran->label() }}
                            </span>
                        </div>

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="flex items-center text-gray-600 hover:text-gray-900">
                                <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Keluar
                            </button>
                        </form>
                    </div>
                </header>

                <!-- Page Content -->
                <main class="flex-1 overflow-y-auto p-6">
                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                            <ul class="list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @yield('content')
                </main>
            </div>
        </div>
    @else
        <div class="min-h-screen flex items-center justify-center">
            @yield('content')
        </div>
    @endauth
</body>

</html>