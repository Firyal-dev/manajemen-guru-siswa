<x-app-layout>
    <x-slot name="header">
        Data Siswa
    </x-slot>

    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="font-headline text-[28px] font-bold text-on-surface">Data Siswa</h1>
            <p class="text-[14px] text-on-surface-variant mt-1">Kelola data siswa dan riwayat kelasnya.</p>
        </div>
        <a href="{{ route('siswa.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-secondary text-white text-[14px] font-bold rounded-lg hover:bg-secondary/90 transition-colors shadow-sm">
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
                <div class="p-4 border-b border-outline-variant flex items-center justify-between bg-surface-container-lowest">
                    <form method="GET" action="{{ route('siswa') }}" class="w-full">
                        <div class="flex flex-col md:flex-row gap-3">
                            <div class="relative flex-1">
                                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px]">search</span>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Cari nama, NIS, atau NISN..."
                                    class="w-full bg-surface-container-low border border-outline-variant text-on-surface text-[14px] rounded-lg pl-10 pr-10 py-2 focus:ring-1 focus:ring-secondary focus:border-secondary transition-all">
                                @if (request('search'))
                                    <a href="{{ route('siswa', request()->except('search')) }}" class="absolute right-3 top-1/2 -translate-y-1/2 text-on-surface-variant hover:text-error-crimson flex items-center">
                                        <span class="material-symbols-outlined text-[18px]">close</span>
                                    </a>
                                @endif
                            </div>
                            
                            <div class="flex gap-2">
                                <select name="agama" class="bg-surface-container-low border border-outline-variant text-on-surface text-[14px] rounded-lg px-3 py-2 focus:ring-1 focus:ring-secondary focus:border-secondary transition-all" onchange="this.form.submit()">
                                    <option value="">Semua Agama</option>
                                    @foreach (['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $agama)
                                        <option value="{{ $agama }}" @selected(request('agama') == $agama)>{{ $agama }}</option>
                                    @endforeach
                                </select>
                                
                                <select name="kelamin" class="bg-surface-container-low border border-outline-variant text-on-surface text-[14px] rounded-lg px-3 py-2 focus:ring-1 focus:ring-secondary focus:border-secondary transition-all" onchange="this.form.submit()">
                                    <option value="">Semua Kelamin</option>
                                    <option value="laki_laki" @selected(request('kelamin') == 'laki_laki')>Laki-laki</option>
                                    <option value="perempuan" @selected(request('kelamin') == 'perempuan')>Perempuan</option>
                                </select>
                                
                                @if (request('agama') || request('kelamin'))
                                    <a href="{{ route('siswa', request()->only('search')) }}" class="flex items-center justify-center px-3 py-2 bg-error-container/30 text-error rounded-lg hover:bg-error-container border border-error-container transition-colors" title="Reset Filter">
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
                            <tr class="bg-surface-container-low border-b border-outline-variant">
                                <th class="py-3 px-4 font-bold text-[12px] text-on-surface uppercase tracking-wider w-12 text-center">No</th>
                                <th class="py-3 px-4 font-bold text-[12px] text-on-surface uppercase tracking-wider">Informasi Siswa</th>
                                <th class="py-3 px-4 font-bold text-[12px] text-on-surface uppercase tracking-wider hidden sm:table-cell">Kelas</th>
                                <th class="py-3 px-4 font-bold text-[12px] text-on-surface uppercase tracking-wider hidden md:table-cell">NISN</th>
                                <th class="py-3 px-4 font-bold text-[12px] text-on-surface uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant/50">
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
                                @endphp
                                <tr @click="selected = {{ json_encode(array_merge($siswaData, ['url_foto' => $siswa->url_foto])) }}"
                                    :class="selected?.id === {{ $siswa->id }} ? 'bg-secondary/10 border-l-4 border-l-secondary' : 'border-l-4 border-l-transparent'">
                                    
                                    <td class="py-3 px-4 text-[13px] text-on-surface-variant text-center font-medium">
                                        {{ ($siswas->currentPage() - 1) * $siswas->perPage() + $index + 1 }}
                                    </td>
                                    
                                    <td class="py-3 px-4">
                                        <div class="flex items-center gap-3">
                                             <div class="w-9 h-9 rounded-full overflow-hidden border border-outline-variant">
                                            @if($siswa->url_foto)
                                                <img src="{{ asset('storage/' . $siswa->url_foto) }}" alt="Foto siswa" class="w-9 h-9 rounded-full object-cover">
                                            @else
                                                <div class="w-9 h-9 rounded-full bg-green-100 text-secondary flex items-center justify-center font-bold text-[13px]">
                                                    {{ str($siswa->nama)->substr(0, 1)->upper() }}
                                                </div>
                                            @endif
                                        </div>
                                            <div>
                                                <p class="font-bold text-[14px] text-on-surface">{{ $siswa->nama }}</p>
                                                <p class="text-[12px] text-on-surface-variant">NIS: {{ $siswa->nis }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td class="py-3 px-4 hidden sm:table-cell">
                                        <span class="px-2.5 py-1 bg-surface-container-high text-on-surface-variant text-[11px] font-bold rounded-lg border border-outline-variant/30">
                                            {{ $siswaRombel ?? ($siswa->rombelAktif() ? trim("{$siswa->rombelAktif()->kelas->tingkat} {$siswa->rombelAktif()->kelas->jurusan->nama} / {$siswa->rombelAktif()->tingkat}") : '-') }}
                                        </span>
                                    </td>
                                    
                                    <td class="py-3 px-4 hidden md:table-cell text-[13px] text-on-surface-variant font-medium">
                                        {{ $siswa->nisn }}
                                    </td>
                                    
                                    <td class="py-3 px-4">
                                        <button class="p-1.5 rounded-lg text-secondary hover:bg-green-100 transition-colors" title="Lihat Detail">
                                            <span class="material-symbols-outlined text-[20px]">chevron_right</span>
                                        </button>
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
                <div class="p-4 border-t border-outline-variant bg-surface-container-lowest">
                    {{ $siswas->links() }}
                </div>
                @endif
            </div>

            {{-- Detail Panel (Right side) --}}
            <div class="w-full lg:w-1/3 bg-surface-container-lowest">
                <div x-show="!selected" class="h-full flex flex-col items-center justify-center p-8 text-center text-on-surface-variant min-h-[300px]">
                    <span class="material-symbols-outlined text-[64px] opacity-20 mb-4">touch_app</span>
                    <p class="text-[15px] font-medium">Pilih siswa pada tabel untuk melihat detail.</p>
                </div>
                
                <div x-show="selected" style="display: none;" class="p-6">
                    <template x-if="selected">
                        <div>
                            <div class="flex flex-col items-center text-center mb-6">
                                <div class="relative mb-4">
                                     <template x-if="selected.url_foto">
                                            <img :src="'{{ asset('storage') }}/' + selected.url_foto" alt="Foto siswa" class="w-24 h-24 rounded-full object-cover border-4 border-white shadow-sm mx-auto" />
                                        </template>
                                        <template x-if="!selected.url_foto">
                                            <div class="w-24 h-24 rounded-full flex items-center justify-center text-3xl font-bold text-white shadow-sm border-4 border-white"
                                                :class="selected.kelamin === 'laki_laki' ? 'bg-blue-500' : 'bg-pink-500'">
                                                <span x-text="selected.nama.charAt(0).toUpperCase()"></span>
                                            </div>
                                        </template>
                                <p class="text-[14px] text-secondary font-semibold mt-1" x-text="`NIS: ${selected.nis}`"></p>
                            </div>

                            <div class="space-y-4 mb-8">
                                <div class="bg-surface-container-low p-3 rounded-lg border border-outline-variant/50 flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-secondary/20 flex items-center justify-center text-secondary">
                                        <span class="material-symbols-outlined text-[18px]">badge</span>
                                    </div>
                                    <div>
                                        <p class="text-[11px] font-bold text-on-surface-variant uppercase">NISN</p>
                                        <p class="text-[14px] font-medium text-on-surface" x-text="selected.nisn"></p>
                                    </div>
                                </div>
                                
                                <div class="bg-surface-container-low p-3 rounded-lg border border-outline-variant/50 flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-amber-50 flex items-center justify-center text-amber-600">
                                        <span class="material-symbols-outlined text-[18px]">meeting_room</span>
                                    </div>
                                    <div>
                                        <p class="text-[11px] font-bold text-on-surface-variant uppercase">Kelas</p>
                                        <p class="text-[14px] font-medium text-on-surface">
                                            <span x-text="selected.rombel"></span>
                                        </p>
                                    </div>
                                </div>
                                
                                <div class="bg-surface-container-low p-3 rounded-lg border border-outline-variant/50 flex flex-col sm:flex-row justify-between gap-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-surface-container-high flex items-center justify-center text-on-surface-variant">
                                            <span class="material-symbols-outlined text-[18px]">synagogue</span>
                                        </div>
                                        <div>
                                            <p class="text-[11px] font-bold text-on-surface-variant uppercase">Agama</p>
                                            <p class="text-[14px] font-medium text-on-surface" x-text="selected.agama"></p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-sky-50 flex items-center justify-center text-sky-600">
                                            <span class="material-symbols-outlined text-[18px]">wc</span>
                                        </div>
                                        <div>
                                            <p class="text-[11px] font-bold text-on-surface-variant uppercase">Kelamin</p>
                                            <p class="text-[14px] font-medium text-on-surface" x-text="selected.kelamin_label"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex flex-col gap-2">
                                <a :href="'{{ url('siswa') }}/' + selected.id + '/edit'" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-surface-container text-secondary text-[14px] font-bold rounded-lg border border-secondary-fixed-dim hover:bg-surface-container-high transition-colors">
                                    <span class="material-symbols-outlined text-[18px]">edit</span>
                                    Edit Data
                                </a>
                                <form method="POST" :id="'delete-siswa-form-' + selected.id" x-bind:action="'{{ url('siswa') }}/' + selected.id">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" @click="confirmDelete('delete-siswa-form-' + selected.id, selected.nama, true)" class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-error-container/50 text-error text-[14px] font-bold rounded-lg hover:bg-error-container transition-colors">
                                        <span class="material-symbols-outlined text-[18px]">delete</span>
                                        Hapus
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

