<x-app-layout>
    <x-slot name="header">
        Tahun Ajaran
    </x-slot>

    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="font-headline text-[28px] font-bold text-on-surface">Tahun Ajaran</h1>
            <p class="text-[14px] text-on-surface-variant mt-1">Kelola data tahun ajaran dan tandai tahun ajaran yang sedang aktif.</p>
        </div>
        <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'buat-tahun-ajaran')" class="inline-flex items-center gap-2 px-4 py-2.5 bg-primary text-white text-[14px] font-bold rounded-lg hover:bg-primary/90 transition-colors shadow-sm">
            <span class="material-symbols-outlined text-[20px]">add</span>
            Buat Tahun Ajaran
        </button>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 bg-green-50 text-secondary rounded-xl border border-green-200 flex items-center gap-3">
            <span class="material-symbols-outlined text-[20px]">check_circle</span>
            <p class="text-[14px] font-bold">{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-surface rounded-xl border border-outline-variant card-shadow overflow-hidden">
        <div class="p-5 border-b border-outline-variant flex items-center justify-between bg-surface-container-lowest">
            <h2 class="font-bold text-[16px] text-on-surface flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">calendar_month</span>
                Daftar Tahun Ajaran
            </h2>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-surface-container-low border-b border-outline-variant">
                        <th class="py-3 px-5 font-bold text-[12px] text-on-surface uppercase tracking-wider">Periode Tahun Ajaran</th>
                        <th class="py-3 px-5 font-bold text-[12px] text-on-surface uppercase tracking-wider">Status</th>
                        <th class="py-3 px-5 font-bold text-[12px] text-on-surface uppercase tracking-wider">Dibuat Pada</th>
                        <th class="py-3 px-5 font-bold text-[12px] text-on-surface uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant/50">
                    @forelse($tahunAjarans as $ta)
                        <tr class="hover:bg-surface-container-highest transition-colors group">
                            <td class="py-4 px-5">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg {{ $ta->aktif ? 'bg-primary-container/20 text-primary' : 'bg-surface-container-high text-on-surface-variant' }} flex items-center justify-center font-bold">
                                        <span class="material-symbols-outlined text-[20px]">school</span>
                                    </div>
                                    <p class="font-bold text-[15px] text-on-surface">TA {{ $ta->tahun_mulai }} / {{ $ta->tahun_selesai }}</p>
                                </div>
                            </td>
                            <td class="py-4 px-5">
                                @if($ta->aktif)
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-green-50 text-secondary border border-green-200 text-[12px] font-bold rounded-lg shadow-sm">
                                        <span class="w-1.5 h-1.5 rounded-full bg-secondary"></span>
                                        Aktif Sekarang
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-surface-container text-on-surface-variant border border-outline-variant/50 text-[12px] font-bold rounded-lg">
                                        <span class="w-1.5 h-1.5 rounded-full bg-outline"></span>
                                        Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-5 text-[13px] text-on-surface-variant font-medium">
                                {{ $ta->created_at->format('d M Y') }}
                            </td>
                            <td class="py-4 px-5 text-right">
                                @if(!$ta->aktif)
                                    <form action="{{ route('tahun-ajaran.active', $ta->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="px-3 py-1.5 bg-primary-container/10 text-primary border border-primary-container hover:bg-primary-container/20 text-[13px] font-bold rounded-lg transition-colors flex items-center gap-1 ml-auto">
                                            <span class="material-symbols-outlined text-[16px]">check_circle</span>
                                            Set Aktif
                                        </button>
                                    </form>
                                @else
                                    <span class="text-[12px] font-bold text-on-surface-variant italic">Aktif</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-12 text-center text-on-surface-variant">
                                <span class="material-symbols-outlined text-[48px] opacity-20 mb-2">calendar_month</span>
                                <p class="text-[14px] font-medium">Belum ada data tahun ajaran.</p>
                                <p class="text-[12px] mt-1">Silakan klik "Buat Tahun Ajaran" untuk menambahkan data.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Create academic year modal --}}
    @include('tahun-ajaran.create')
</x-app-layout>
