<x-app-layout>
    <x-slot name="header">
        Manajemen Kelas & Rombel
    </x-slot>

    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="font-headline text-[28px] font-bold text-on-surface">Kelas & Rombel</h1>
            <p class="text-[14px] text-on-surface-variant mt-1">Kelola data kelas, rombongan belajar, dan penugasan wali kelas.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('jurusan.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-surface-container-high text-primary text-[14px] font-bold rounded-lg hover:bg-surface-container-highest transition-colors shadow-sm border border-outline-variant/50">
                <span class="material-symbols-outlined text-[20px]">architecture</span>
                Tambah Jurusan
            </a>
            <a href="{{ route('kelas-rombel.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-primary text-white text-[14px] font-bold rounded-lg hover:bg-primary/90 transition-colors shadow-sm">
                <span class="material-symbols-outlined text-[20px]">add</span>
                Tambah Rombel
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 bg-green-50 text-secondary rounded-xl border border-green-200 flex items-center gap-3">
            <span class="material-symbols-outlined text-[20px]">check_circle</span>
            <p class="text-[14px] font-bold">{{ session('success') }}</p>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 p-4 bg-error-container/20 text-error rounded-xl border border-error/30 flex items-center gap-3">
            <span class="material-symbols-outlined text-[20px]">warning</span>
            <p class="text-[14px] font-bold">{{ session('error') }}</p>
        </div>
    @endif

    <div class="space-y-6" x-data="{ selectedRombel: null }">
        @forelse ($jurusans as $jurusan)
            <div class="bg-surface rounded-xl border border-outline-variant card-shadow overflow-hidden" x-data="{ open: true }">
                {{-- Header Jurusan --}}
                <div @click="open = !open" class="p-5 border-b border-outline-variant flex items-center justify-between bg-surface-container-lowest cursor-pointer hover:bg-surface-container-low transition-colors select-none">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-lg bg-primary-container/20 flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined" x-text="open ? 'folder_open' : 'folder'"></span>
                        </div>
                        <div>
                            <h3 class="font-bold text-[16px] text-on-surface flex items-center gap-2">
                                {{ $jurusan->singkatan }}
                                @if ($jurusan->kepanjangan ?? false)
                                    <span class="text-[13px] font-normal text-on-surface-variant">({{ $jurusan->kepanjangan }})</span>
                                @endif
                            </h3>
                            <p class="text-[13px] text-on-surface-variant mt-0.5">
                                {{ $jurusan->kelas->sum(fn($k) => $k->rombel->count()) }} Rombel
                            </p>
                        </div>
                    </div>
                    <span class="material-symbols-outlined text-on-surface-variant transition-transform duration-200" :class="open ? 'rotate-180' : ''">expand_more</span>
                </div>

                {{-- Konten Rombel --}}
                <div x-show="open" x-collapse x-transition.duration.200ms>
                    <div class="p-5 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 bg-surface">
                        @foreach ($jurusan->kelas->sortBy('tingkat') as $kelas)
                            @foreach ($kelas->rombel as $rombel)
                                @php 
                                    $displayNama = "{$kelas->tingkat} {$jurusan->singkatan} {$rombel->tingkat}";
                                    $wali = $rombel->guru->first(); 
                                @endphp
                                
                                <div class="bg-surface-container-lowest rounded-xl p-4 border border-outline-variant/60 hover:border-primary hover:shadow-md transition-all cursor-pointer group"
                                     @click="selectedRombel = { 
                                        id: {{ $rombel->id }},
                                        display_nama: '{{ $displayNama }}', 
                                        siswa_count: {{ $rombel->siswa->count() }}, 
                                        siswa: {{ json_encode($rombel->siswa->map(fn($s) => ['nama' => $s->nama, 'nis' => $s->nis])->values()->all()) }} 
                                     }; $dispatch('open-modal', 'detail-rombel')">
                                    
                                    <div class="flex justify-between items-start mb-4">
                                        <div class="flex items-center gap-2">
                                            <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center">
                                                <span class="material-symbols-outlined text-[18px]">meeting_room</span>
                                            </div>
                                            <div>
                                                <p class="font-bold text-[15px] text-on-surface">{{ $displayNama }}</p>
                                                <p class="text-[12px] font-medium text-on-surface-variant">{{ $rombel->siswa->count() }} Siswa</p>
                                            </div>
                                        </div>
                                        <button @click.stop="$dispatch('open-modal', 'confirm-delete-rombel-{{ $rombel->id }}')" class="p-1.5 text-outline hover:text-error-crimson hover:bg-error-container/20 rounded-lg transition-colors opacity-0 group-hover:opacity-100 focus:opacity-100">
                                            <span class="material-symbols-outlined text-[18px]">delete</span>
                                        </button>
                                    </div>
                                    
                                    <div class="pt-3 border-t border-outline-variant/30 flex items-center gap-3">
                                        @if ($wali)
                                            <div class="w-7 h-7 rounded-full bg-primary/10 flex items-center justify-center font-bold text-[11px] text-primary">
                                                {{ strtoupper(substr($wali->nama, 0, 2)) }}
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-[12px] font-medium text-on-surface truncate">{{ $wali->nama }}</p>
                                                <p class="text-[10px] text-on-surface-variant">Wali Kelas</p>
                                            </div>
                                        @else
                                            <div class="w-7 h-7 rounded-full bg-surface-container-high flex items-center justify-center text-[11px] text-outline">
                                                <span class="material-symbols-outlined text-[14px]">person_off</span>
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <p class="text-[12px] italic text-on-surface-variant">Belum ada wali kelas</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                {{-- Delete Modal --}}
                                <x-modal name="confirm-delete-rombel-{{ $rombel->id }}" :show="false" maxWidth="sm">
                                    <div class="p-6">
                                        <div class="flex items-center gap-3 text-error mb-4">
                                            <span class="material-symbols-outlined text-[28px]">warning</span>
                                            <h2 class="text-lg font-bold text-on-surface">Hapus Rombel</h2>
                                        </div>
                                        <p class="text-[14px] text-on-surface-variant mb-6">
                                            Yakin ingin menghapus rombongan belajar <span class="font-bold text-on-surface">{{ $displayNama }}</span>?
                                        </p>
                                        <div class="flex justify-end gap-3">
                                            <button @click="$dispatch('close-modal', 'confirm-delete-rombel-{{ $rombel->id }}')" class="px-4 py-2 text-[14px] font-bold text-on-surface-variant hover:bg-surface-container-low rounded-lg transition-colors">
                                                Batal
                                            </button>
                                            <form action="{{ route('kelas-rombel.destroy', $rombel) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-4 py-2 text-[14px] font-bold bg-error text-white rounded-lg hover:bg-error/90 transition-colors">
                                                    Ya, Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </x-modal>
                            @endforeach
                        @endforeach
                        
                        @if($jurusan->kelas->sum(fn($k) => $k->rombel->count()) === 0)
                            <div class="col-span-full py-8 text-center text-on-surface-variant">
                                <span class="material-symbols-outlined text-[48px] opacity-20 mb-2">meeting_room</span>
                                <p class="text-[14px] font-medium">Belum ada rombel untuk jurusan ini.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-surface rounded-xl border border-outline-variant card-shadow p-12 text-center flex flex-col items-center justify-center">
                <div class="w-16 h-16 bg-surface-container-high rounded-full flex items-center justify-center text-on-surface-variant mb-4">
                    <span class="material-symbols-outlined text-[32px]">architecture</span>
                </div>
                <h3 class="font-bold text-[18px] text-on-surface mb-2">Belum ada data Jurusan</h3>
                <p class="text-[14px] text-on-surface-variant mb-6 max-w-md">Silakan tambahkan jurusan terlebih dahulu sebelum membuat kelas dan rombongan belajar.</p>
                <a href="{{ route('jurusan.create') }}" class="px-5 py-2.5 bg-primary text-white text-[14px] font-bold rounded-lg hover:bg-primary/90 transition-colors">
                    Tambah Jurusan Pertama
                </a>
            </div>
        @endforelse

        {{-- Detail Rombel Modal --}}
        <x-modal name="detail-rombel" :show="false" maxWidth="2xl">
            @include('kelas.detail-rombel')
        </x-modal>
    </div>
</x-app-layout>
