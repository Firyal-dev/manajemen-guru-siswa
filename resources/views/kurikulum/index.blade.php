<x-app-layout>
    <x-slot name="header">
        Manajemen Kurikulum
    </x-slot>

    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="font-headline text-[28px] font-bold text-on-surface">Manajemen Kurikulum</h1>
            <p class="text-[14px] text-on-surface-variant mt-1">Kelola data kurikulum yang tersedia untuk diterapkan pada kelas atau rombel.</p>
        </div>
        <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'buat-kurikulum')" class="inline-flex items-center gap-2 px-4 py-2.5 bg-primary text-white text-[14px] font-bold rounded-lg hover:bg-primary/90 transition-colors shadow-sm">
            <span class="material-symbols-outlined text-[20px]">add</span>
            Tambah Kurikulum
        </button>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 bg-green-50 text-secondary rounded-xl border border-green-200 flex items-center gap-3">
            <span class="material-symbols-outlined text-[20px]">check_circle</span>
            <p class="text-[14px] font-bold">{{ session('success') }}</p>
        </div>
    @endif
    
    @if (session('error'))
        <div class="mb-6 p-4 bg-red-50 text-red-700 rounded-xl border border-red-200 flex items-center gap-3">
            <span class="material-symbols-outlined text-[20px]">error</span>
            <p class="text-[14px] font-bold">{{ session('error') }}</p>
        </div>
    @endif

    <div class="bg-surface rounded-xl border border-outline-variant card-shadow overflow-hidden">
        <div class="p-5 border-b border-outline-variant flex items-center justify-between bg-surface-container-lowest">
            <h2 class="font-bold text-[16px] text-on-surface flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">auto_stories</span>
                Daftar Kurikulum
            </h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low border-b border-outline-variant">
                        <th class="py-3 px-5 font-bold text-[12px] text-on-surface uppercase tracking-wider">Nama Kurikulum</th>
                        <th class="py-3 px-5 font-bold text-[12px] text-on-surface uppercase tracking-wider">Kode</th>
                        <th class="py-3 px-5 font-bold text-[12px] text-on-surface uppercase tracking-wider">Status</th>
                        <th class="py-3 px-5 font-bold text-[12px] text-on-surface uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/50">
                    @forelse($kurikulums as $k)
                        <tr class="hover:bg-surface-container-highest transition-colors group">
                            <td class="py-4 px-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg {{ $k->status ? 'bg-primary-container/20 text-primary' : 'bg-surface-container-high text-on-surface-variant' }} flex items-center justify-center font-bold">
                                        <span class="material-symbols-outlined text-[20px]">menu_book</span>
                                    </div>
                                    <p class="font-bold text-[15px] text-on-surface">{{ $k->nama }}</p>
                                </div>
                            </td>
                            <td class="py-4 px-5">
                                <span class="text-[14px] font-medium">{{ $k->kode ?? '-' }}</span>
                            </td>
                            <td class="py-4 px-5">
                                @if($k->status)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-green-50 text-secondary border border-green-200 text-[12px] font-bold rounded-lg shadow-sm">
                                        <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
                                        Aktif
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-surface-container text-on-surface-variant border border-outline-variant/50 text-[12px] font-bold rounded-lg">
                                        <span class="w-1.5 h-1.5 rounded-full bg-outline"></span>
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-5 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'edit-kurikulum-{{ $k->id }}')" class="p-2 text-on-surface-variant hover:text-primary hover:bg-primary-container/20 rounded-lg transition-colors" title="Edit">
                                        <span class="material-symbols-outlined text-[18px]">edit</span>
                                    </button>
                                    
                                    <form action="{{ route('kurikulum.destroy', $k->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kurikulum ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-on-surface-variant hover:text-error hover:bg-error-container/20 rounded-lg transition-colors" title="Hapus">
                                            <span class="material-symbols-outlined text-[18px]">delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @include('kurikulum.edit')
                    @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center text-on-surface-variant">
                                <span class="material-symbols-outlined text-[48px] opacity-20 mb-2">auto_stories</span>
                                <p class="text-[14px] font-medium">Belum ada data kurikulum.</p>
                                <p class="text-[12px] mt-1">Silakan klik "Tambah Kurikulum" untuk menambahkan data.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Create Modal --}}
    @include('kurikulum.create')
</x-app-layout>
