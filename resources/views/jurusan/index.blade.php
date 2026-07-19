<x-app-layout>
    <x-slot name="header">
        Data Jurusan
    </x-slot>

    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="font-headline text-[28px] font-bold text-on-surface">Data Jurusan</h1>
            <p class="text-[14px] text-on-surface-variant mt-1">Kelola daftar jurusan/kompetensi keahlian di sekolah.</p>
        </div>
        <a href="{{ route('jurusan.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-primary text-white text-[14px] font-bold rounded-lg hover:bg-primary/90 transition-colors shadow-sm">
            <span class="material-symbols-outlined text-[20px]">add</span>
            Tambah Jurusan
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 bg-green-50 text-secondary rounded-xl border border-green-200 flex items-center gap-3">
            <span class="material-symbols-outlined text-[20px]">check_circle</span>
            <p class="text-[14px] font-bold">{{ session('success') }}</p>
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 p-4 bg-error-container text-on-error-container rounded-xl border border-error/30 flex items-center gap-3">
            <span class="material-symbols-outlined text-[20px]">error</span>
            <p class="text-[14px] font-bold">{{ session('error') }}</p>
        </div>
    @endif

    <div>
        <div class="bg-surface rounded-xl border border-outline-variant card-shadow overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-surface-container-low border-b border-outline-variant">
                            <th class="py-3 px-5 font-bold text-[12px] text-on-surface uppercase tracking-wider">No</th>
                            <th class="py-3 px-5 font-bold text-[12px] text-on-surface uppercase tracking-wider">Nama Jurusan</th>
                            <th class="py-3 px-5 font-bold text-[12px] text-on-surface uppercase tracking-wider text-center">Lama Belajar (Tahun)</th>
                            <th class="py-3 px-5 font-bold text-[12px] text-on-surface uppercase tracking-wider text-center">Jumlah Kelas</th>
                            <th class="py-3 px-5 font-bold text-[12px] text-on-surface uppercase tracking-wider text-center">Mata Pelajaran</th>
                            <th class="py-3 px-5 font-bold text-[12px] text-on-surface uppercase tracking-wider text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant/50">
                        @forelse ($jurusans as $index => $jurusan)
                            <tr class="hover:bg-surface-container-highest transition-colors">
                                <td class="py-4 px-5 text-[13px] text-on-surface-variant">{{ $jurusans->firstItem() + $index }}</td>
                                <td class="py-4 px-5 text-[14px] text-on-surface font-semibold">{{ $jurusan->nama }}</td>
                                <td class="py-4 px-5 text-center">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[12px] font-bold bg-primary-container/20 text-primary border border-primary-container">
                                        {{ $jurusan->panjang_tahun_ajaran }}
                                    </span>
                                </td>
                                <td class="py-4 px-5 text-center text-[13px] text-on-surface-variant">{{ $jurusan->kelas_count }}</td>
                                <td class="py-4 px-5 text-center text-[13px] text-on-surface-variant">{{ $jurusan->mapels_count }}</td>
                                <td class="py-4 px-5 text-right space-x-2">
                                    <a href="{{ route('jurusan.edit', $jurusan) }}" class="inline-flex items-center gap-2 px-3 py-2 bg-surface-container text-primary text-[13px] font-semibold rounded-lg border border-primary-container hover:bg-primary-container/10 transition-colors">
                                        <span class="material-symbols-outlined text-[18px]">edit</span>
                                        Edit
                                    </a>
                                    <button type="button" onclick="confirmDelete('delete-jurusan-form-{{ $jurusan->id }}', '{{ addslashes($jurusan->nama) }}')" class="inline-flex items-center gap-2 px-3 py-2 bg-error-container/10 text-error text-[13px] font-semibold rounded-lg border border-error-container hover:bg-error-container/20 transition-colors">
                                        <span class="material-symbols-outlined text-[18px]">delete</span>
                                        Hapus
                                    </button>
                                    <form id="delete-jurusan-form-{{ $jurusan->id }}" method="POST" action="{{ url('jurusan', $jurusan->id) }}" class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-on-surface-variant">
                                    <span class="material-symbols-outlined text-[48px] opacity-20 mb-2">school</span>
                                    <p class="text-[14px] font-medium">Belum ada data jurusan.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($jurusans->hasPages())
                <div class="p-4 border-t border-outline-variant bg-surface-container-lowest">
                    {{ $jurusans->links() }}
                </div>
            @endif

</x-app-layout>

