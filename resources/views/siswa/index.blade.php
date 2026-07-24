<x-app-layout>
    <x-slot name="header">
        Data Siswa
    </x-slot>

    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="font-headline text-[28px] md:text-[32px] font-bold text-on-surface tracking-tight">Data Siswa</h1>
            <p class="text-[14px] md:text-[15px] text-on-surface-variant mt-1">Kelola data siswa dan riwayat kelasnya.</p>
        </div>
        <a href="{{ route('siswa.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-primary to-surface-tint text-white text-[14px] font-bold rounded-xl hover:shadow-lg hover:shadow-primary/30 transition-all duration-300 transform hover:-translate-y-0.5">
            <span class="material-symbols-outlined text-[20px]">add</span>
            Tambah Siswa
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 bg-green-50 text-secondary rounded-xl border border-green-200 flex items-center gap-3">
            <span class="material-symbols-outlined text-[20px]">check_circle</span>
            <p class="text-[14px] font-bold">{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-surface rounded-xl border border-outline-variant card-shadow overflow-hidden" x-data="{ selected: null }">
        <div class="flex flex-col lg:flex-row">
            
            {{-- Master List (Left side) --}}
            <div class="w-full lg:w-2/3 border-b lg:border-b-0 lg:border-r border-outline-variant">
                {{-- Toolbar --}}
                {{-- Toolbar --}}
                <div class="p-5 border-b border-outline-variant/60 flex items-center justify-between bg-surface-container-lowest">
                    <form method="GET" action="{{ route('siswa') }}" class="w-full">
                        <div class="flex flex-col md:flex-row gap-3">
                            <div class="relative flex-1 group">
                                <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px] group-focus-within:text-primary transition-colors">search</span>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Cari nama, NIS, atau NISN..."
                                    class="w-full bg-surface-container-low border border-outline-variant/60 text-on-surface text-[14px] rounded-xl pl-11 pr-10 py-2.5 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all shadow-sm">
                                @if (request('search'))
                                    <a href="{{ route('siswa', request()->except('search')) }}" class="absolute right-3 top-1/2 -translate-y-1/2 text-on-surface-variant hover:text-error-crimson flex items-center bg-surface-gray rounded-full p-0.5 transition-colors">
                                        <span class="material-symbols-outlined text-[18px]">close</span>
                                    </a>
                                @endif
                            </div>
                            
                            <div class="flex gap-2">
                                <div class="relative group">
                                    <select name="agama" class="bg-surface-container-low border border-outline-variant/60 text-on-surface text-[14px] rounded-xl pl-4 pr-10 py-2.5 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all shadow-sm appearance-none cursor-pointer" onchange="this.form.submit()">
                                        <option value="">Semua Agama</option>
                                        @foreach (['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $agama)
                                            <option value="{{ $agama }}" @selected(request('agama') == $agama)>{{ $agama }}</option>
                                        @endforeach
                                    </select>
                                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-on-surface-variant pointer-events-none group-focus-within:text-primary transition-colors">arrow_drop_down</span>
                                </div>
                                
                                <div class="relative group">
                                    <select name="kelamin" class="bg-surface-container-low border border-outline-variant/60 text-on-surface text-[14px] rounded-xl pl-4 pr-10 py-2.5 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all shadow-sm appearance-none cursor-pointer" onchange="this.form.submit()">
                                        <option value="">Semua Kelamin</option>
                                        <option value="laki_laki" @selected(request('kelamin') == 'laki_laki')>Laki-laki</option>
                                        <option value="perempuan" @selected(request('kelamin') == 'perempuan')>Perempuan</option>
                                    </select>
                                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-on-surface-variant pointer-events-none group-focus-within:text-primary transition-colors">arrow_drop_down</span>
                                </div>
                                
                                @if (request('agama') || request('kelamin'))
                                    <a href="{{ route('siswa', request()->only('search')) }}" class="flex items-center justify-center px-3.5 py-2.5 bg-error-container/30 text-error rounded-xl hover:bg-error-container border border-error-container transition-colors shadow-sm" title="Reset Filter">
                                        <span class="material-symbols-outlined text-[18px]">filter_alt_off</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-surface-gray border-b border-outline-variant/60">
                                <th class="py-3.5 px-4 font-bold text-[11px] text-on-surface-variant uppercase tracking-wider w-12 text-center">No</th>
                                <th class="py-3.5 px-4 font-bold text-[11px] text-on-surface-variant uppercase tracking-wider">Informasi Siswa</th>
                                <th class="py-3.5 px-4 font-bold text-[11px] text-on-surface-variant uppercase tracking-wider hidden sm:table-cell">Kelas</th>
                                <th class="py-3.5 px-4 font-bold text-[11px] text-on-surface-variant uppercase tracking-wider hidden md:table-cell">NISN</th>
                                <th class="py-3.5 px-4 font-bold text-[11px] text-on-surface-variant uppercase tracking-wider text-right pr-6">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant/40">
                            @forelse ($siswas as $index => $siswa)
                                @php
                                    $rombelAktif = $siswa->rombelAktif();
                                    $siswaRombel = '-';

                                    if ($rombelAktif) {
                                        $kelasLabel = trim("{$rombelAktif->kelas->tingkat} {$rombelAktif->kelas->jurusan->nama}");
                                        $rombelTingkat = trim($rombelAktif->tingkat);

                                        if ($kelasLabel && str_contains($rombelTingkat, $kelasLabel)) {
                                            $siswaRombel = $rombelTingkat;
                                        } elseif ($rombelTingkat && str_contains($kelasLabel, $rombelTingkat)) {
                                            $siswaRombel = $rombelTingkat;
                                        } elseif ($kelasLabel === $rombelTingkat) {
                                            $siswaRombel = $kelasLabel;
                                        } else {
                                            $siswaRombel = "{$kelasLabel} / {$rombelTingkat}";
                                        }
                                    }

                                    $siswaData = [
                                        'id'      => $siswa->id,
                                        'nama'    => $siswa->nama,
                                        'nis'     => $siswa->nis,
                                        'nisn'    => $siswa->nisn,
                                        'agama'   => $siswa->agama,
                                        'kelamin' => $siswa->kelamin?->value,
                                        'kelamin_label' => $siswa->kelamin?->label(),
                                        'rombel'  => $siswaRombel,
                                    ];

                                    // Dynamic gradient based on first letter
                                    $firstChar = strtoupper(substr($siswa->nama, 0, 1));
                                    $gradient = 'from-primary-fixed to-primary-fixed-dim text-primary';
                                    if(in_array($firstChar, ['A','B','C','D','E'])) $gradient = 'from-blue-100 to-blue-200 text-blue-700';
                                    elseif(in_array($firstChar, ['F','G','H','I','J'])) $gradient = 'from-emerald-100 to-emerald-200 text-emerald-700';
                                    elseif(in_array($firstChar, ['K','L','M','N','O'])) $gradient = 'from-amber-100 to-amber-200 text-amber-700';
                                    elseif(in_array($firstChar, ['P','Q','R','S','T'])) $gradient = 'from-purple-100 to-purple-200 text-purple-700';
                                    else $gradient = 'from-rose-100 to-rose-200 text-rose-700';
                                @endphp
                                <tr @click="selected = {{ json_encode(array_merge($siswaData, ['url_foto' => $siswa->url_foto, 'gradient' => $gradient])) }}"
                                    class="group cursor-pointer transition-all duration-200 hover:bg-surface-container-low"
                                    :class="selected?.id === {{ $siswa->id }} ? 'bg-primary/5 border-l-4 border-l-primary' : 'border-l-4 border-l-transparent'">
                                    
                                    <td class="py-4 px-4 text-[13px] text-on-surface-variant text-center font-medium">
                                        {{ ($siswas->currentPage() - 1) * $siswas->perPage() + $index + 1 }}
                                    </td>
                                    
                                    <td class="py-4 px-4">
                                        <div class="flex items-center gap-3">
                                            @if($siswa->url_foto)
                                                <img src="{{ asset('storage/' . $siswa->url_foto) }}" alt="Foto siswa" class="w-10 h-10 rounded-full object-cover border border-outline-variant shadow-sm flex-shrink-0">
                                            @else
                                                <div class="w-10 h-10 rounded-full bg-gradient-to-br {{ $gradient }} flex items-center justify-center font-bold text-[14px] shadow-sm flex-shrink-0 border border-white/50">
                                                    {{ $firstChar }}
                                                </div>
                                            @endif
                                            <div>
                                                <p class="font-bold text-[14px] text-on-surface group-hover:text-primary transition-colors">{{ $siswa->nama }}</p>
                                                <p class="text-[12px] text-on-surface-variant font-medium mt-0.5">NIS: {{ $siswa->nis }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td class="py-4 px-4 hidden sm:table-cell">
                                        <span class="px-2.5 py-1 bg-surface border border-outline-variant/60 text-on-surface-variant text-[11px] font-bold rounded-lg shadow-sm">
                                            {{ $siswaRombel ?? ($siswa->rombelAktif() ? trim("{$siswa->rombelAktif()->kelas->tingkat} {$siswa->rombelAktif()->kelas->jurusan->nama} / {$siswa->rombelAktif()->tingkat}") : '-') }}
                                        </span>
                                    </td>
                                    
                                    <td class="py-4 px-4 hidden md:table-cell text-[13px] text-on-surface-variant font-medium">
                                        {{ $siswa->nisn }}
                                    </td>
                                    
                                    <td class="py-4 px-4 text-right pr-6">
                                        <div class="w-8 h-8 rounded-full inline-flex items-center justify-center text-on-surface-variant group-hover:bg-primary group-hover:text-white transition-all duration-300" 
                                             :class="selected?.id === {{ $siswa->id }} ? 'bg-primary text-white shadow-md' : ''">
                                            <span class="material-symbols-outlined text-[20px]">chevron_right</span>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-12 text-center">
                                        <div class="flex flex-col items-center justify-center text-on-surface-variant">
                                            <span class="material-symbols-outlined text-[48px] mb-3 opacity-50">person_off</span>
                                            <p class="text-[14px] font-medium">Belum ada data siswa ditemukan.</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                {{-- Pagination --}}
                @if($siswas->hasPages())
                <div class="p-4 border-t border-outline-variant/60 bg-surface-container-lowest overflow-x-auto w-full">
                    {{ $siswas->links() }}
                </div>
                @endif
            </div>

            {{-- Detail Panel (Right side) --}}
            <div class="w-full lg:w-1/3 bg-gradient-to-b from-surface-gray to-surface relative overflow-hidden flex flex-col">
                {{-- Empty State --}}
                <div x-show="!selected" class="absolute inset-0 flex flex-col items-center justify-center p-8 text-center text-on-surface-variant transition-opacity duration-300">
                    <div class="w-24 h-24 rounded-full bg-primary/5 flex items-center justify-center mb-6 animate-pulse border-4 border-white shadow-sm">
                        <span class="material-symbols-outlined text-[48px] text-primary/40">touch_app</span>
                    </div>
                    <h3 class="font-headline text-[18px] font-bold text-on-surface mb-2">Belum Ada Pilihan</h3>
                    <p class="text-[14px] font-medium opacity-80">Pilih siswa pada tabel di samping untuk melihat detail profil secara lengkap.</p>
                </div>
                
                {{-- Selected State --}}
                <div x-show="selected" style="display: none;" class="flex-1 flex flex-col h-full overflow-y-auto">
                    <template x-if="selected">
                        <div class="pb-6">
                            {{-- Banner Cover --}}
                            <div class="h-32 bg-gradient-to-br from-primary to-surface-tint relative">
                                <div class="absolute inset-0 bg-white/10 mix-blend-overlay"></div>
                            </div>

                            {{-- Profile Info --}}
                            <div class="px-6 relative flex flex-col items-center text-center -mt-14 mb-6">
                                <template x-if="selected.url_foto">
                                    <img :src="'{{ asset('storage') }}/' + selected.url_foto" alt="Foto siswa" class="w-28 h-28 rounded-full object-cover border-4 border-white shadow-md mx-auto bg-white" />
                                </template>
                                <template x-if="!selected.url_foto">
                                    <div class="w-28 h-28 rounded-full flex items-center justify-center text-4xl font-bold shadow-md border-4 border-white mx-auto bg-gradient-to-br"
                                        :class="selected.gradient">
                                        <span x-text="selected.nama.charAt(0).toUpperCase()"></span>
                                    </div>
                                </template>
                                
                                <h3 class="font-headline text-[22px] font-bold text-on-surface mt-4 leading-tight" x-text="selected.nama"></h3>
                                <p class="inline-flex items-center gap-1.5 px-3 py-1 bg-surface-container-high text-primary font-bold text-[12px] rounded-full mt-2 border border-primary/20">
                                    <span class="material-symbols-outlined text-[14px]">badge</span>
                                    NIS: <span x-text="selected.nis"></span>
                                </p>
                            </div>

                            {{-- Info Cards --}}
                            <div class="px-6 space-y-3 mb-8">
                                <div class="bg-surface rounded-xl p-3.5 border border-outline-variant/40 shadow-sm flex items-center gap-3.5 hover:border-primary/30 transition-colors">
                                    <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center text-primary flex-shrink-0">
                                        <span class="material-symbols-outlined text-[20px]">id_card</span>
                                    </div>
                                    <div>
                                        <p class="text-[11px] font-bold text-on-surface-variant uppercase tracking-wider">NISN</p>
                                        <p class="text-[14px] font-bold text-on-surface" x-text="selected.nisn"></p>
                                    </div>
                                </div>
                                
                                <div class="bg-surface rounded-xl p-3.5 border border-outline-variant/40 shadow-sm flex items-center gap-3.5 hover:border-amber-500/30 transition-colors">
                                    <div class="w-10 h-10 rounded-full bg-amber-500/10 flex items-center justify-center text-amber-600 flex-shrink-0">
                                        <span class="material-symbols-outlined text-[20px]">meeting_room</span>
                                    </div>
                                    <div>
                                        <p class="text-[11px] font-bold text-on-surface-variant uppercase tracking-wider">Kelas / Rombel</p>
                                        <p class="text-[14px] font-bold text-on-surface" x-text="selected.rombel"></p>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="bg-surface rounded-xl p-3.5 border border-outline-variant/40 shadow-sm flex flex-col gap-2 hover:border-emerald-500/30 transition-colors">
                                        <div class="w-8 h-8 rounded-full bg-emerald-500/10 flex items-center justify-center text-emerald-600">
                                            <span class="material-symbols-outlined text-[16px]">synagogue</span>
                                        </div>
                                        <div>
                                            <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Agama</p>
                                            <p class="text-[13px] font-bold text-on-surface" x-text="selected.agama"></p>
                                        </div>
                                    </div>
                                    <div class="bg-surface rounded-xl p-3.5 border border-outline-variant/40 shadow-sm flex flex-col gap-2 hover:border-sky-500/30 transition-colors">
                                        <div class="w-8 h-8 rounded-full bg-sky-500/10 flex items-center justify-center text-sky-600">
                                            <span class="material-symbols-outlined text-[16px]">wc</span>
                                        </div>
                                        <div>
                                            <p class="text-[10px] font-bold text-on-surface-variant uppercase tracking-wider">Kelamin</p>
                                            <p class="text-[13px] font-bold text-on-surface" x-text="selected.kelamin_label"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Actions --}}
                            <div class="px-6 flex flex-col gap-2 mt-auto">
                                <a :href="'{{ url('siswa') }}/' + selected.id + '/edit'" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-surface text-primary text-[14px] font-bold rounded-xl border border-primary hover:bg-primary hover:text-white transition-all shadow-sm">
                                    <span class="material-symbols-outlined text-[18px]">edit_square</span>
                                    Edit Profil Siswa
                                </a>
                                <form method="POST" :id="'delete-siswa-form-' + selected.id" x-bind:action="'{{ url('siswa') }}/' + selected.id">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" @click="confirmDelete('delete-siswa-form-' + selected.id, selected.nama, true)" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-surface text-error text-[14px] font-bold rounded-xl border border-error-container hover:bg-error hover:text-white hover:border-error transition-all shadow-sm group">
                                        <span class="material-symbols-outlined text-[18px] group-hover:animate-bounce">delete</span>
                                        Hapus Data
                                    </button>
                                </form>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
            
        </div>
    </div>

</x-app-layout>

