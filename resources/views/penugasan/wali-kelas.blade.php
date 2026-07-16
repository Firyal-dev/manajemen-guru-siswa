<x-app-layout>
    <x-slot name="header">
        Penugasan Wali Kelas
    </x-slot>

    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="font-headline text-[28px] font-bold text-on-surface">Penugasan Wali Kelas</h1>
            <p class="text-[14px] text-on-surface-variant mt-1">Tugaskan guru sebagai wali untuk rombongan belajar.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 text-secondary rounded-xl border border-green-200 flex items-center gap-3">
            <span class="material-symbols-outlined text-[20px]">check_circle</span>
            <p class="text-[14px] font-bold">{{ session('success') }}</p>
        </div>
    @endif

    @if($errors->any())
        <div class="mb-6 p-4 bg-error-container/30 text-error rounded-xl border border-error-container flex items-start gap-3">
            <span class="material-symbols-outlined text-[20px] mt-0.5">error</span>
            <div>
                <p class="text-[14px] font-bold mb-1">Terjadi kesalahan:</p>
                <ul class="list-disc pl-5 text-[13px]">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Form Penugasan --}}
        <div class="lg:col-span-1">
            <div class="bg-surface rounded-xl border border-outline-variant card-shadow overflow-hidden">
                <div class="p-5 border-b border-outline-variant bg-surface-container-lowest">
                    <h2 class="font-bold text-[16px] text-on-surface flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">assignment_ind</span>
                        Tugaskan Wali Kelas Baru
                    </h2>
                </div>
                
                <form method="post" action="{{ route('penugasan.wali-kelas.store') }}" class="p-5 space-y-5">
                    @csrf
                    
                    <div>
                        <label for="guru_id" class="block text-[13px] font-bold text-on-surface mb-2">Pilih Guru</label>
                        <select id="guru_id" name="guru_id" class="w-full bg-surface-container-lowest border border-outline-variant text-on-surface text-[14px] rounded-lg p-2.5 focus:ring-1 focus:ring-primary focus:border-primary transition-all" required>
                            <option value="" disabled selected>-- Pilih Guru --</option>
                            @foreach($gurus as $guru)
                                <option value="{{ $guru->id }}">{{ $guru->nama }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="rombel_id" class="block text-[13px] font-bold text-on-surface mb-2">Pilih Rombel</label>
                        <select id="rombel_id" name="rombel_id" class="w-full bg-surface-container-lowest border border-outline-variant text-on-surface text-[14px] rounded-lg p-2.5 focus:ring-1 focus:ring-primary focus:border-primary transition-all" required>
                            <option value="" disabled selected>-- Pilih Rombel --</option>
                            @foreach($rombels as $rombel)
                                <option value="{{ $rombel->id }}">{{ $rombel->tingkat }}</option>
                            @endforeach
                        </select>
                        <p class="text-[11px] text-on-surface-variant mt-2 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">info</span>
                            Satu rombel hanya bisa memiliki satu wali kelas.
                        </p>
                    </div>

                    <button type="submit" class="w-full py-2.5 bg-primary text-white text-[14px] font-bold rounded-lg hover:bg-primary/90 transition-colors flex items-center justify-center gap-2 mt-2">
                        <span class="material-symbols-outlined text-[18px]">save</span>
                        Simpan Penugasan
                    </button>
                </form>
            </div>
        </div>

        {{-- Daftar Penugasan --}}
        <div class="lg:col-span-2">
            <div class="bg-surface rounded-xl border border-outline-variant card-shadow overflow-hidden">
                <div class="p-5 border-b border-outline-variant bg-surface-container-lowest flex justify-between items-center">
                    <h2 class="font-bold text-[16px] text-on-surface">Daftar Wali Kelas Aktif</h2>
                    <span class="px-2.5 py-1 bg-primary-container/10 text-primary text-[12px] font-bold rounded-full">
                        {{ count($waliKelas) }} Wali Kelas
                    </span>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-surface-container-low border-b border-outline-variant">
                                <th class="py-3 px-4 font-bold text-[12px] text-on-surface uppercase tracking-wider w-12 text-center">No</th>
                                <th class="py-3 px-4 font-bold text-[12px] text-on-surface uppercase tracking-wider">Nama Guru</th>
                                <th class="py-3 px-4 font-bold text-[12px] text-on-surface uppercase tracking-wider">Rombel</th>
                                <th class="py-3 px-4 font-bold text-[12px] text-on-surface uppercase tracking-wider text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant/50">
                            @forelse($waliKelas as $index => $item)
                                <tr class="hover:bg-surface-container-highest transition-colors group">
                                    <td class="py-3 px-4 text-[13px] text-on-surface-variant text-center font-medium">
                                        {{ $index + 1 }}
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-primary-container/20 text-primary flex items-center justify-center font-bold text-[12px]">
                                                {{ substr($item->guru->nama, 0, 1) }}
                                            </div>
                                            <p class="font-bold text-[14px] text-on-surface">{{ $item->guru->nama }}</p>
                                        </div>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="px-2.5 py-1 bg-green-50 text-secondary border border-green-200 text-[12px] font-bold rounded-lg">
                                            {{ $item->rombel->tingkat }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-right">
                                        <form action="{{ route('penugasan.wali-kelas.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin mencabut tugas wali kelas ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 text-error hover:bg-error-container/30 rounded-lg transition-colors inline-flex items-center gap-1 opacity-0 group-hover:opacity-100 focus:opacity-100" title="Cabut Tugas">
                                                <span class="material-symbols-outlined text-[18px]">person_remove</span>
                                                <span class="text-[12px] font-bold hidden sm:inline">Cabut</span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-12 text-center text-on-surface-variant">
                                        <span class="material-symbols-outlined text-[48px] opacity-20 mb-2">assignment_late</span>
                                        <p class="text-[14px] font-medium">Belum ada data wali kelas aktif.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
