<x-app-layout>
    <x-slot name="header">
        Data Mata Pelajaran
    </x-slot>

    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="font-headline text-[28px] font-bold text-on-surface">Data Mata Pelajaran</h1>
            <p class="text-[14px] text-on-surface-variant mt-1">Kelola daftar mata pelajaran yang tersedia.</p>
        </div>
        <a href="{{ route('mapel.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-primary text-white text-[14px] font-bold rounded-lg hover:bg-primary/90 transition-colors shadow-sm">
            <span class="material-symbols-outlined text-[20px]">add</span>
            Tambah Mata Pelajaran
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 bg-green-50 text-secondary rounded-xl border border-green-200 flex items-center gap-3">
            <span class="material-symbols-outlined text-[20px]">check_circle</span>
            <p class="text-[14px] font-bold">{{ session('success') }}</p>
        </div>
    @endif

    <div x-data="{
            deleteTarget: null,
            submitDelete() {
                if (! this.deleteTarget) return;

                const form = document.getElementById('delete-mapel-form');
                form.action = '{{ url('mapel') }}/' + this.deleteTarget;
                form.submit();
            }
        }" x-on:mapel-delete-target.window="deleteTarget = $event.detail" x-on:mapel-delete-confirm.window="submitDelete()">
        <div class="bg-surface rounded-xl border border-outline-variant card-shadow overflow-hidden">
            <div class="p-4 border-b border-outline-variant flex items-center justify-between bg-surface-container-lowest">
                <form method="GET" action="{{ route('mapel.index') }}" class="w-full max-w-md">
                    <div class="relative flex items-center">
                        <span class="material-symbols-outlined absolute left-3 text-on-surface-variant text-[20px]">search</span>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama mata pelajaran..."
                            class="w-full bg-surface-container-low border border-outline-variant text-on-surface text-[14px] rounded-lg pl-10 pr-10 py-2 focus:ring-1 focus:ring-primary focus:border-primary transition-all">
                        @if (request('search'))
                            <a href="{{ route('mapel.index') }}" class="absolute right-3 text-on-surface-variant hover:text-error-crimson flex items-center">
                                <span class="material-symbols-outlined text-[18px]">close</span>
                            </a>
                        @endif
                    </div>
                </form>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low border-b border-outline-variant">
                        <th class="py-3 px-5 font-bold text-[12px] text-on-surface uppercase tracking-wider">No</th>
                        <th class="py-3 px-5 font-bold text-[12px] text-on-surface uppercase tracking-wider">Nama Mata Pelajaran</th>
                        <th class="py-3 px-5 font-bold text-[12px] text-on-surface uppercase tracking-wider">Kelompok</th>
                        <th class="py-3 px-5 font-bold text-[12px] text-on-surface uppercase tracking-wider">Jurusan</th>
                        <th class="py-3 px-5 font-bold text-[12px] text-on-surface uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/50">
                    @forelse ($mapels as $index => $mapel)
                        <tr class="hover:bg-surface-container-highest transition-colors">
                            <td class="py-4 px-5 text-[13px] text-on-surface-variant">{{ $mapels->firstItem() + $index }}</td>
                            <td class="py-4 px-5 text-[14px] text-on-surface font-semibold">{{ $mapel->nama_mapel }}</td>
                            <td class="py-4 px-5">
                                @if ($mapel->kelompok === 'Kejuruan')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-primary-container/20 text-primary border border-primary-container">
                                        <span class="material-symbols-outlined text-[14px]">engineering</span>
                                        Kejuruan
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-surface-container text-on-surface-variant border border-outline-variant">
                                        <span class="material-symbols-outlined text-[14px]">public</span>
                                        Umum
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-5 text-[13px] text-on-surface-variant">
                                {{ $mapel->jurusan?->nama ?? '—' }}
                            </td>
                            <td class="py-4 px-5 text-right space-x-2">
                                <a href="{{ route('mapel.edit', $mapel) }}" class="inline-flex items-center gap-2 px-3 py-2 bg-surface-container text-primary text-[13px] font-semibold rounded-lg border border-primary-container hover:bg-primary-container/10 transition-colors">
                                    <span class="material-symbols-outlined text-[18px]">edit</span>
                                    Edit
                                </a>
                                <button type="button" @click="$dispatch('mapel-delete-target', {{ $mapel->id }}); $dispatch('open-modal', 'confirm-hapus-mapel')" class="inline-flex items-center gap-2 px-3 py-2 bg-error-container/10 text-error text-[13px] font-semibold rounded-lg border border-error-container hover:bg-error-container/20 transition-colors">
                                    <span class="material-symbols-outlined text-[18px]">delete</span>
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-on-surface-variant">
                                <span class="material-symbols-outlined text-[48px] opacity-20 mb-2">book</span>
                                <p class="text-[14px] font-medium">Belum ada data mata pelajaran.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($mapels->hasPages())
            <div class="p-4 border-t border-outline-variant bg-surface-container-lowest">
                {{ $mapels->links() }}
            </div>
        @endif

        <form id="delete-mapel-form" method="POST" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>

    <x-modal name="confirm-hapus-mapel" :show="false" maxWidth="sm">
        <div class="p-6">
            <div class="flex items-center gap-3 text-error mb-4">
                <span class="material-symbols-outlined text-[28px]">warning</span>
                <h2 class="text-lg font-bold text-on-surface">Konfirmasi Hapus Mata Pelajaran</h2>
            </div>

            <p class="text-[14px] text-on-surface-variant">
                Apakah Anda yakin ingin menghapus mata pelajaran ini? Tindakan ini tidak dapat dibatalkan.
            </p>

            <div class="mt-6 flex justify-end gap-3">
                <button @click="$dispatch('close-modal', 'confirm-hapus-mapel')" class="px-4 py-2 text-[14px] font-bold text-on-surface-variant hover:bg-surface-container-low rounded-lg transition-colors">
                    Batal
                </button>
                <button type="button" @click="submitDelete(); $dispatch('close-modal', 'confirm-hapus-mapel')" class="px-4 py-2 text-[14px] font-bold bg-error text-white rounded-lg hover:bg-error/90 transition-colors">
                    Ya, Hapus
                </button>
            </div>
        </div>
    </x-modal>
</x-app-layout>
