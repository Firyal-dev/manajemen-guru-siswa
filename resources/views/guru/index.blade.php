<x-app-layout>
    <x-slot name="header">
        Manajemen Guru
    </x-slot>

    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="font-headline text-[28px] font-bold text-on-surface">Data Guru</h1>
            <p class="text-[14px] text-on-surface-variant mt-1">Kelola data master guru beserta informasi pribadinya.</p>
        </div>
        <a href="{{ route('guru.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-primary text-white text-[14px] font-bold rounded-lg hover:bg-primary/90 transition-colors shadow-sm">
            <span class="material-symbols-outlined text-[20px]">add</span>
            Tambah Guru
        </a>
    </div>

    <div class="bg-surface rounded-xl border border-outline-variant card-shadow overflow-hidden" x-data="{ selected: null }">
        <div class="flex flex-col lg:flex-row">
            
            {{-- Master List (Left side) --}}
            <div class="w-full lg:w-2/3 border-b lg:border-b-0 lg:border-r border-outline-variant">
                {{-- Toolbar --}}
                <div class="p-4 border-b border-outline-variant flex items-center justify-between bg-surface-container-lowest">
                    <form method="GET" action="{{ route('guru') }}" class="w-full max-w-md">
                        <div class="relative flex items-center">
                            <span class="material-symbols-outlined absolute left-3 text-on-surface-variant text-[20px]">search</span>
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari nama atau NIP..."
                                class="w-full bg-surface-container-low border border-outline-variant text-on-surface text-[14px] rounded-lg pl-10 pr-10 py-2 focus:ring-1 focus:ring-primary focus:border-primary transition-all">
                            @if (request('search'))
                                <a href="{{ route('guru') }}" class="absolute right-3 text-on-surface-variant hover:text-error-crimson flex items-center">
                                    <span class="material-symbols-outlined text-[18px]">close</span>
                                </a>
                            @endif
                        </div>
                    </form>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-surface-container-low border-b border-outline-variant">
                                <th class="py-3 px-4 font-bold text-[12px] text-on-surface uppercase tracking-wider w-12 text-center">No</th>
                                <th class="py-3 px-4 font-bold text-[12px] text-on-surface uppercase tracking-wider">Informasi Guru</th>
                                <th class="py-3 px-4 font-bold text-[12px] text-on-surface uppercase tracking-wider hidden sm:table-cell">Agama</th>
                                <th class="py-3 px-4 font-bold text-[12px] text-on-surface uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant/50">
                            @forelse ($gurus as $index => $guru)
                                <tr @click="selected = {{ $guru->toJson() }}"
                                    class="cursor-pointer transition-colors hover:bg-surface-container-highest"
                                    :class="selected?.id === {{ $guru->id }} ? 'bg-primary-container/10 border-l-4 border-l-primary' : 'border-l-4 border-l-transparent'">
                                    
                                    <td class="py-3 px-4 text-[13px] text-on-surface-variant text-center font-medium">
                                        {{ $gurus->firstItem() + $index }}
                                    </td>
                                    
                                    <td class="py-3 px-4">
                                        <div class="flex items-center gap-3">
                                            @if($guru->url_foto)
                                                <img src="{{ asset('storage/' . $guru->url_foto) }}" alt="Foto" class="w-9 h-9 rounded-full object-cover border border-outline-variant">
                                            @else
                                                <div class="w-9 h-9 rounded-full bg-primary-container/20 text-primary flex items-center justify-center font-bold text-[13px]">
                                                    {{ str($guru->nama)->substr(0, 1)->upper() }}
                                                </div>
                                            @endif
                                            <div>
                                                <p class="font-bold text-[14px] text-on-surface">{{ $guru->nama }}</p>
                                                <p class="text-[12px] text-on-surface-variant">NIP: {{ $guru->nip }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td class="py-3 px-4 hidden sm:table-cell">
                                        <span class="px-2.5 py-1 bg-surface-container-high text-on-surface-variant text-[11px] font-bold rounded-lg border border-outline-variant/30">
                                            {{ $guru->agama }}
                                        </span>
                                    </td>
                                    
                                    <td class="py-3 px-4">
                                        <button class="p-1.5 rounded-lg text-primary hover:bg-primary-container/20 transition-colors" title="Lihat Detail">
                                            <span class="material-symbols-outlined text-[20px]">chevron_right</span>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-12 text-center">
                                        <div class="flex flex-col items-center justify-center text-on-surface-variant">
                                            <span class="material-symbols-outlined text-[48px] mb-3 opacity-50">person_off</span>
                                            <p class="text-[14px] font-medium">Belum ada data guru ditemukan.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                {{-- Pagination --}}
                @if($gurus->hasPages())
                <div class="p-4 border-t border-outline-variant bg-surface-container-lowest">
                    {{ $gurus->links() }}
                </div>
                @endif
            </div>

            {{-- Detail Panel (Right side) --}}
            <div class="w-full lg:w-1/3 bg-surface-container-lowest">
                <div x-show="!selected" class="h-full flex flex-col items-center justify-center p-8 text-center text-on-surface-variant min-h-[300px]">
                    <span class="material-symbols-outlined text-[64px] opacity-20 mb-4">touch_app</span>
                    <p class="text-[15px] font-medium">Pilih guru pada tabel untuk melihat detail.</p>
                </div>
                
                <div x-show="selected" style="display: none;" class="p-6">
                    <template x-if="selected">
                        <div>
                            <div class="flex flex-col items-center text-center mb-6">
                                <div class="relative mb-4">
                                    <img :src="selected.url_foto ? '{{ asset('storage') }}/' + selected.url_foto : '{{ asset('user-placeholder.png') }}'" 
                                         alt="Foto Profil"
                                         class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-sm"
                                         x-on:error.once="$event.target.src='{{ asset('user-placeholder.png') }}'">
                                </div>
                                <h3 class="text-[20px] font-bold text-on-surface leading-tight" x-text="selected.nama"></h3>
                                <p class="text-[14px] text-primary font-semibold mt-1" x-text="selected.nip"></p>
                            </div>

                            <div class="space-y-4 mb-8">
                                <div class="bg-surface-container-low p-3 rounded-lg border border-outline-variant/50 flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-primary-container/20 flex items-center justify-center text-primary">
                                        <span class="material-symbols-outlined text-[18px]">badge</span>
                                    </div>
                                    <div>
                                        <p class="text-[11px] font-bold text-on-surface-variant uppercase">NIP</p>
                                        <p class="text-[14px] font-medium text-on-surface" x-text="selected.nip"></p>
                                    </div>
                                </div>
                                
                                <div class="bg-surface-container-low p-3 rounded-lg border border-outline-variant/50 flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-green-50 flex items-center justify-center text-secondary">
                                        <span class="material-symbols-outlined text-[18px]">synagogue</span>
                                    </div>
                                    <div>
                                        <p class="text-[11px] font-bold text-on-surface-variant uppercase">Agama</p>
                                        <p class="text-[14px] font-medium text-on-surface" x-text="selected.agama"></p>
                                    </div>
                                </div>
                                
                                <div class="bg-surface-container-low p-3 rounded-lg border border-outline-variant/50 flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-sky-50 flex items-center justify-center text-sky-600">
                                        <span class="material-symbols-outlined text-[18px]">wc</span>
                                    </div>
                                    <div>
                                        <p class="text-[11px] font-bold text-on-surface-variant uppercase">Jenis Kelamin</p>
                                        <p class="text-[14px] font-medium text-on-surface" x-text="selected.kelamin === 'laki_laki' ? 'Laki-laki' : 'Perempuan'"></p>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col gap-2">
                                <a :href="'{{ url('guru') }}/' + selected.id + '/edit'" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-surface-container text-primary text-[14px] font-bold rounded-lg border border-primary-fixed hover:bg-surface-container-high transition-colors">
                                    <span class="material-symbols-outlined text-[18px]">edit</span>
                                    Edit Data
                                </a>
                                <button @click="$dispatch('open-modal', 'confirm-hapus')" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-error-container/50 text-error text-[14px] font-bold rounded-lg hover:bg-error-container transition-colors">
                                    <span class="material-symbols-outlined text-[18px]">delete</span>
                                    Hapus
                                </button>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
            
        </div>
    </div>

    {{-- Delete Modal --}}
    <x-modal name="confirm-hapus" :show="false" maxWidth="sm">
        <div class="p-6">
            <div class="flex items-center gap-3 text-error mb-4">
                <span class="material-symbols-outlined text-[28px]">warning</span>
                <h2 class="text-lg font-bold text-on-surface">Konfirmasi Hapus</h2>
            </div>
            
            <p class="text-[14px] text-on-surface-variant">
                Apakah Anda yakin ingin menghapus data guru <span class="font-bold text-on-surface" x-text="selected?.nama"></span>? Tindakan ini tidak dapat dibatalkan.
            </p>
            
            <div class="mt-6 flex justify-end gap-3">
                <button @click="$dispatch('close-modal', 'confirm-hapus')" class="px-4 py-2 text-[14px] font-bold text-on-surface-variant hover:bg-surface-container-low rounded-lg transition-colors">
                    Batal
                </button>
                <form method="POST" x-bind:action="'{{ url('guru') }}/' + selected?.id" @submit="$dispatch('close-modal', 'confirm-hapus')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 text-[14px] font-bold bg-error text-white rounded-lg hover:bg-error/90 transition-colors">
                        Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </x-modal>
</x-app-layout>
