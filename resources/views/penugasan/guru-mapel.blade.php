<x-app-layout>
    <x-slot name="header">
        Penugasan Guru Mata Pelajaran
    </x-slot>

    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="font-headline text-[28px] font-bold text-on-surface">Guru Mata Pelajaran</h1>
            <p class="text-[14px] text-on-surface-variant mt-1">Tugaskan guru untuk mata pelajaran di berbagai rombongan belajar.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 text-secondary rounded-xl border border-green-200 flex items-center gap-3">
            <span class="material-symbols-outlined text-[20px]">check_circle</span>
            <p class="text-[14px] font-bold">{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 bg-error-container/30 text-error rounded-xl border border-error-container flex items-center gap-3">
            <span class="material-symbols-outlined text-[20px]">error</span>
            <p class="text-[14px] font-bold">{{ session('error') }}</p>
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
                        Tugaskan Guru Mapel Baru
                    </h2>
                </div>
                
                <form method="post" action="{{ route('penugasan.guru-mapel.store') }}" class="p-5 space-y-5">
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
                        <label for="mapel_id" class="block text-[13px] font-bold text-on-surface mb-2">Pilih Mata Pelajaran</label>
                        <select id="mapel_id" name="mapel_id" class="w-full bg-surface-container-lowest border border-outline-variant text-on-surface text-[14px] rounded-lg p-2.5 focus:ring-1 focus:ring-primary focus:border-primary transition-all" required>
                            <option value="" disabled selected>-- Pilih Mata Pelajaran --</option>
                            @foreach($mapels as $mapel)
                                <option value="{{ $mapel->id }}">{{ $mapel->nama_mapel }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-[13px] font-bold text-on-surface mb-2">Pilih Rombel </label>
                        <div class="bg-surface-container-lowest border border-outline-variant rounded-lg p-3 h-48 overflow-y-auto">
                            <div class="grid grid-cols-2 gap-2">
                                @foreach($rombels as $rombel)
                                <label class="flex items-center p-2 rounded-lg hover:bg-surface-container-low transition-colors cursor-pointer border border-transparent hover:border-outline-variant/30">
                                    <input type="checkbox" name="rombel_id[]" value="{{ $rombel->id }}" class="w-4 h-4 text-primary bg-surface-container border-outline-variant rounded focus:ring-primary focus:ring-2 focus:ring-offset-0">
                                    <span class="ms-2 text-[13px] font-medium text-on-surface">{{ $rombel->kelas->tingkat }} {{ $rombel->kelas->jurusan->singkatan }} {{ $rombel->tingkat }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                         <p class="text-[11px] text-on-surface-variant mt-2 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">info</span>
                            bisa memilih lebih dari 1 rombel 
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
                    <h2 class="font-bold text-[16px] text-on-surface">Daftar Penugasan Aktif</h2>
                    <span class="px-2.5 py-1 bg-primary-container/10 text-primary text-[12px] font-bold rounded-full">
                        {{ count($guruMapels) }} Penugasan
                    </span>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-surface-container-low border-b border-outline-variant">
                                <th class="py-3 px-4 font-bold text-[12px] text-on-surface uppercase tracking-wider w-12 text-center">No</th>
                                <th class="py-3 px-4 font-bold text-[12px] text-on-surface uppercase tracking-wider">Informasi Guru</th>
                                <th class="py-3 px-4 font-bold text-[12px] text-on-surface uppercase tracking-wider hidden sm:table-cell">Mata Pelajaran</th>
                                <th class="py-3 px-4 font-bold text-[12px] text-on-surface uppercase tracking-wider">Rombel</th>
                                <th class="py-3 px-4 font-bold text-[12px] text-on-surface uppercase tracking-wider text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant/50">
                            @forelse($guruMapels as $index => $item)
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
                                        <p class="text-[12px] text-on-surface-variant sm:hidden mt-1">{{ $item->mapel->nama_mapel }}</p>
                                    </td>
                                    <td class="py-3 px-4 hidden sm:table-cell">
                                        <span class="px-2.5 py-1 bg-sky-50 text-sky-700 border border-sky-100 text-[12px] font-bold rounded-lg">
                                            {{ $item->mapel->nama_mapel }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <span class="px-2.5 py-1 bg-green-50 text-secondary border border-green-200 text-[12px] font-bold rounded-lg">
                                            {{ $item->rombel->kelas->tingkat }} {{ $item->rombel->kelas->jurusan->singkatan }} {{ $item->rombel->tingkat }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-right">
                                        <form action="{{ route('penugasan.guru-mapel.destroy', $item->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin mencabut tugas guru mapel ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-1.5 text-error hover:bg-error-container/30 rounded-lg transition-colors inline-flex items-center gap-1 opacity-0 group-hover:opacity-100 focus:opacity-100" title="Cabut Tugas">
                                                <span class="material-symbols-outlined text-[18px]">person_remove</span>
                                                <span class="text-[12px] font-bold hidden xl:inline">Cabut</span>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-12 text-center text-on-surface-variant">
                                        <span class="material-symbols-outlined text-[48px] opacity-20 mb-2">assignment_late</span>
                                        <p class="text-[14px] font-medium">Belum ada data penugasan aktif.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    @push('styles')
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
    <style>
        .ts-control {
            border-radius: 0.5rem;
            border-color: #c4c5d5;
            padding: 0.625rem 0.75rem;
            font-size: 14px;
            background-color: #ffffff;
            color: #111c2d;
            min-height: 42px;
        }
        .ts-control.focus {
            border-color: #00288e;
            box-shadow: 0 0 0 1px #00288e;
        }
        .ts-dropdown {
            border-radius: 0.5rem;
            font-size: 14px;
            box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06);
            border-color: #c4c5d5;
        }
        .ts-dropdown .option:hover, .ts-dropdown .option.active {
            background-color: #f0f3ff;
            color: #00288e;
        }
    </style>
    @endpush

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new TomSelect('#guru_id', {
                create: false,
                placeholder: "-- Pilih Guru --",
                searchField: ['text']
            });
            
            new TomSelect('#mapel_id', {
                create: false,
                placeholder: "-- Pilih Mata Pelajaran --",
                searchField: ['text']
            });
        });
    </script>
    @endpush
</x-app-layout>
