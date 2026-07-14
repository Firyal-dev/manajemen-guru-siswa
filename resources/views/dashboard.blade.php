<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Welcome text --}}
            <div class="flex items-center gap-3">
                <div>
                    <p class="text-lg font-semibold text-gray-800 dark:text-gray-100">
                        Selamat Datang di Aplikasi Management 👋, <span class="text-indigo-600 dark:text-indigo-400">{{ auth()->user()->name }}</span>!
                    </p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">SMK AK Nusa Bangsa — Sistem Manajemen Guru & Siswa</p>
                </div>
            </div>

            {{-- Statistics Grid --}}

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                {{-- Card Guru — indigo --}}
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 border-t-4 border-t-indigo-500 flex items-center justify-between hover:shadow-md transition-shadow">
                    <div class="space-y-1">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Guru</p>
                        <h3 class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $counts['guru'] }}</h3>
                        <p class="text-xs text-indigo-600 dark:text-indigo-400 font-medium">Aktif Mengajar</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 4a2 2 0 012 2v8a2 2 0 01-2 2h-3l-1 1-1-1V11a2 2 0 012-2h3z" />
                        </svg>
                    </div>
                </div>

                {{-- Card Siswa — emerald --}}
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 border-t-4 border-t-emerald-500 flex items-center justify-between hover:shadow-md transition-shadow">
                    <div class="space-y-1">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Siswa</p>
                        <h3 class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $counts['siswa'] }}</h3>
                        <p class="text-xs text-emerald-600 dark:text-emerald-400 font-medium">Terdaftar</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                    </div>
                </div>

                {{-- Card Rombel — amber --}}
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 border-t-4 border-t-amber-500 flex items-center justify-between hover:shadow-md transition-shadow">
                    <div class="space-y-1">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Rombel / Kelas</p>
                        <h3 class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $counts['rombel'] }}</h3>
                        <p class="text-xs text-amber-600 dark:text-amber-400 font-medium">Kelompok Belajar</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-amber-50 dark:bg-amber-900/30 flex items-center justify-center text-amber-600 dark:text-amber-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                </div>

                {{-- Card Jurusan — sky --}}
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 border-t-4 border-t-sky-500 flex items-center justify-between hover:shadow-md transition-shadow">
                    <div class="space-y-1">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Jurusan</p>
                        <h3 class="text-3xl font-bold text-gray-900 dark:text-gray-100">{{ $counts['jurusan'] }}</h3>
                        <p class="text-xs text-sky-600 dark:text-sky-400 font-medium">Program Keahlian</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-sky-50 dark:bg-sky-900/30 flex items-center justify-center text-sky-600 dark:text-sky-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                        </svg>
                    </div>
                </div>

            </div>

            {{-- Latest Data Lists --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                {{-- Latest Students — emerald accent --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 border-t-4 border-t-emerald-500 overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-5">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </div>
                                <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">Siswa Baru Terdaftar</h3>
                            </div>
                            <a href="{{ route('siswa') }}"
                               class="text-sm font-medium text-emerald-600 hover:text-emerald-500 dark:text-emerald-400 dark:hover:text-emerald-300 transition-colors">
                                Lihat Semua →
                            </a>
                        </div>
                        <div class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse ($siswaTerbaru as $siswa)
                                <div class="py-3 flex items-center justify-between gap-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full flex items-center justify-center font-bold text-white text-sm bg-emerald-500 dark:bg-emerald-600 shrink-0">
                                            {{ str($siswa->nama)->substr(0, 1)->upper() }}
                                        </div>
                                        <div>
                                            <p class="font-medium text-sm text-gray-900 dark:text-gray-100 leading-tight">{{ $siswa->nama }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">NIS: {{ $siswa->nis }}</p>
                                        </div>
                                    </div>
                                    <span class="shrink-0 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-300">
                                        {{ $siswa->rombel?->tingkat ?? '-' }} {{ $siswa->rombel?->kelas?->nama_kelas ?? '' }}
                                    </span>
                                </div>
                            @empty
                                <p class="py-8 text-center text-sm text-gray-500 dark:text-gray-400">Belum ada data siswa.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- Latest Teachers — indigo accent --}}
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 border-t-4 border-t-indigo-500 overflow-hidden">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-5">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 4a2 2 0 012 2v8a2 2 0 01-2 2h-3l-1 1-1-1V11a2 2 0 012-2h3z" />
                                    </svg>
                                </div>
                                <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">Guru Baru Terdaftar</h3>
                            </div>
                            <a href="{{ route('guru') }}"
                               class="text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300 transition-colors">
                                Lihat Semua →
                            </a>
                        </div>
                        <div class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse ($guruTerbaru as $guru)
                                <div class="py-3 flex items-center justify-between gap-4">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $guru->url_foto ? asset('storage/' . $guru->url_foto) : asset('user-placeholder.png') }}"
                                             alt="Foto {{ $guru->nama }}"
                                             class="w-9 h-9 rounded-full object-cover bg-gray-100 dark:bg-gray-700 shrink-0">
                                        <div>
                                            <p class="font-medium text-sm text-gray-900 dark:text-gray-100 leading-tight">{{ $guru->nama }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">NIP: {{ $guru->nip }}</p>
                                        </div>
                                    </div>
                                    <span class="shrink-0 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-300">
                                        {{ $guru->agama }}
                                    </span>
                                </div>
                            @empty
                                <p class="py-8 text-center text-sm text-gray-500 dark:text-gray-400">Belum ada data guru.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
