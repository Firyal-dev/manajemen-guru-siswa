<x-app-layout>
    <x-slot name="header">
        Dashboard Overview
    </x-slot>

    <div class="mb-6">
        <h1 class="font-headline text-[28px] md:text-[32px] font-bold text-on-surface">Selamat datang di Master Data 👋</h1>
        <p class="text-[15px] text-on-surface-variant mt-1">SMK AK Nusa Bangsa — Sistem Manajemen Guru & Siswa</p>
    </div>

    {{-- Statistics Grid --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        {{-- Card Guru --}}
        <div class="bg-surface rounded-xl p-5 border border-outline-variant card-shadow">
            <div class="flex justify-between items-start mb-3">
                <div class="p-2 bg-primary-container/10 rounded-lg">
                    <span class="material-symbols-outlined text-primary text-[22px]" style="font-variation-settings: 'FILL' 1;">manage_accounts</span>
                </div>
                <span class="text-[11px] font-bold px-2 py-0.5 rounded-full bg-green-100 text-green-700">Aktif</span>
            </div>
            <p class="font-headline text-[32px] font-bold text-on-surface leading-none">{{ $counts['guru'] ?? 0 }}</p>
            <p class="text-[13px] text-on-surface-variant mt-1">Total Guru</p>
        </div>

        {{-- Card Siswa --}}
        <div class="bg-surface rounded-xl p-5 border border-outline-variant card-shadow">
            <div class="flex justify-between items-start mb-3">
                <div class="p-2 bg-green-50 rounded-lg">
                    <span class="material-symbols-outlined text-secondary text-[22px]" style="font-variation-settings: 'FILL' 1;">groups</span>
                </div>
            </div>
            <p class="font-headline text-[32px] font-bold text-on-surface leading-none">{{ $counts['siswa'] ?? 0 }}</p>
            <p class="text-[13px] text-on-surface-variant mt-1">Total Siswa</p>
        </div>

        {{-- Card Rombel --}}
        <div class="bg-surface rounded-xl p-5 border border-outline-variant card-shadow">
            <div class="flex justify-between items-start mb-3">
                <div class="p-2 bg-amber-50 rounded-lg">
                    <span class="material-symbols-outlined text-amber-500 text-[22px]" style="font-variation-settings: 'FILL' 1;">meeting_room</span>
                </div>
            </div>
            <p class="font-headline text-[32px] font-bold text-on-surface leading-none">{{ $counts['rombel'] ?? 0 }}</p>
            <p class="text-[13px] text-on-surface-variant mt-1">Rombel / Kelas</p>
        </div>

        {{-- Card Jurusan --}}
        <div class="bg-surface rounded-xl p-5 border border-outline-variant card-shadow">
            <div class="flex justify-between items-start mb-3">
                <div class="p-2 bg-sky-50 rounded-lg">
                    <span class="material-symbols-outlined text-sky-500 text-[22px]" style="font-variation-settings: 'FILL' 1;">architecture</span>
                </div>
            </div>
            <p class="font-headline text-[32px] font-bold text-on-surface leading-none">{{ $counts['jurusan'] ?? 0 }}</p>
            <p class="text-[13px] text-on-surface-variant mt-1">Jurusan</p>
        </div>
    </div>

    {{-- Latest Data Lists --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        {{-- Latest Students --}}
        <div class="bg-surface rounded-xl border border-outline-variant card-shadow">
            <div class="p-5 border-b border-outline-variant flex justify-between items-center">
                <h3 class="font-headline text-[18px] font-bold text-on-surface flex items-center gap-2">
                    <span class="material-symbols-outlined text-secondary text-[22px]" style="font-variation-settings: 'FILL' 1;">person_add</span>
                    Siswa Baru Terdaftar
                </h3>
                <a href="{{ route('siswa') }}" class="text-[13px] font-bold text-primary hover:underline">Lihat Semua &rarr;</a>
            </div>
            <div class="divide-y divide-outline-variant/30">
                @forelse ($siswaTerbaru ?? [] as $siswa)
                <div class="p-4 flex items-center justify-between hover:bg-surface-container-low transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-green-100 text-secondary flex items-center justify-center font-bold text-[14px]">
                            {{ str($siswa->nama)->substr(0, 1)->upper() }}
                        </div>
                        <div>
                            <p class="font-semibold text-[14px] text-on-surface">{{ $siswa->nama }}</p>
                            <p class="text-[13px] text-on-surface-variant">NIS: {{ $siswa->nis }}</p>
                        </div>
                    </div>
                    <span class="px-2.5 py-1 bg-green-50 text-secondary text-[12px] font-bold rounded-full">
                        {{ $siswa->rombelAktif() ? $siswa->rombelAktif()->kelas->tingkat . ' ' . $siswa->rombelAktif()->kelas->jurusan->singkatan . ' ' . $siswa->rombelAktif()->tingkat : '-' }}
                    </span>
                </div>
                @empty
                <div class="p-8 text-center text-on-surface-variant text-[13px]">
                    Belum ada data siswa.
                </div>
                @endforelse
            </div>
        </div>

        {{-- Latest Teachers --}}
        <div class="bg-surface rounded-xl border border-outline-variant card-shadow">
            <div class="p-5 border-b border-outline-variant flex justify-between items-center">
                <h3 class="font-headline text-[18px] font-bold text-on-surface flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-[22px]" style="font-variation-settings: 'FILL' 1;">badge</span>
                    Guru Baru Terdaftar
                </h3>
                <a href="{{ route('guru') }}" class="text-[13px] font-bold text-primary hover:underline">Lihat Semua &rarr;</a>
            </div>
            <div class="divide-y divide-outline-variant/30">
                @forelse ($guruTerbaru ?? [] as $guru)
                <div class="p-4 flex items-center justify-between hover:bg-surface-container-low transition-colors">
                    <div class="flex items-center gap-3">
                        @if($guru->url_foto)
                            <img src="{{ asset('storage/' . $guru->url_foto) }}" alt="Foto" class="w-10 h-10 rounded-full object-cover border border-outline-variant">
                        @else
                            <div class="w-10 h-10 rounded-full bg-primary-container/20 text-primary flex items-center justify-center font-bold text-[14px]">
                                {{ str($guru->nama)->substr(0, 1)->upper() }}
                            </div>
                        @endif
                        <div>
                            <p class="font-semibold text-[14px] text-on-surface">{{ $guru->nama }}</p>
                            <p class="text-[13px] text-on-surface-variant">NIP: {{ $guru->nip }}</p>
                        </div>
                    </div>
                    <span class="px-2.5 py-1 bg-primary-container/10 text-primary text-[12px] font-bold rounded-full">
                        {{ $guru->agama }}
                    </span>
                </div>
                @empty
                <div class="p-8 text-center text-on-surface-variant text-[13px]">
                    Belum ada data guru.
                </div>
                @endforelse
            </div>
        </div>

    </div>
</x-app-layout>
