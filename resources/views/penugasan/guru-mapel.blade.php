<x-app-layout>
    <x-slot name="header">
        Penugasan Guru Mata Pelajaran
    </x-slot>

    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="font-headline text-[28px] font-bold text-on-surface">Guru Mata Pelajaran</h1>
            <p class="text-[14px] text-on-surface-variant mt-1">Tugaskan guru untuk mengajar mata pelajaran di berbagai kelas.</p>
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
                        Tugaskan Guru Mata Pelajaran Baru
                    </h2>
                </div>
                
                <form method="post" action="{{ route('penugasan.guru-mapel.store') }}" class="p-5 space-y-5">
                    @csrf
                    
                    <div class="relative">
                        <label class="block text-[13px] font-bold text-on-surface mb-2">Pilih Guru</label>
                        <input type="hidden" id="guru_id" name="guru_id" value="{{ old('guru_id') }}" required>
                        <button type="button" id="guru_select_button" class="w-full text-left bg-surface-container-lowest border border-outline-variant text-on-surface text-[14px] rounded-lg p-2.5 focus:ring-1 focus:ring-primary focus:border-primary transition-all flex items-center justify-between" aria-haspopup="listbox" aria-expanded="false">
                            <span id="guru_select_text" class="text-on-surface-variant">-- Pilih Guru --</span>
                            <span class="material-symbols-outlined">arrow_drop_down</span>
                        </button>
                        <div id="guru_select_dropdown" class="hidden absolute left-0 right-0 mt-2 z-50 bg-surface border border-outline-variant rounded-lg shadow-lg overflow-hidden">
                            <div class="px-3 py-2 border-b border-outline-variant">
                                <label class="sr-only" for="guru_search">Cari Guru</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-3 flex items-center text-on-surface-variant">
                                        <span class="material-symbols-outlined text-[18px]">search</span>
                                    </span>
                                    <input id="guru_search" type="text" placeholder="Cari Guru..." class="w-full pl-10 pr-3 py-2 rounded-lg border border-outline-variant bg-surface-container-lowest text-[14px] text-on-surface focus:ring-1 focus:ring-primary focus:border-primary transition-all" />
                                </div>
                            </div>
                            <div id="guru_select_options" class="max-h-64 overflow-y-auto">
                                <!-- Options akan diload via AJAX -->
                            </div>
                        </div>
                    </div>

                    <div class="relative">
                        <label class="block text-[13px] font-bold text-on-surface mb-2">Pilih Mata Pelajaran</label>
                        <input type="hidden" id="mapel_id" name="mapel_id" value="{{ old('mapel_id') }}" required>
                        <button type="button" id="mapel_select_button" class="w-full text-left bg-surface-container-lowest border border-outline-variant text-on-surface text-[14px] rounded-lg p-2.5 focus:ring-1 focus:ring-primary focus:border-primary transition-all flex items-center justify-between" aria-haspopup="listbox" aria-expanded="false">
                            <span id="mapel_select_text" class="text-on-surface-variant">-- Pilih Mata Pelajaran --</span>
                            <span class="material-symbols-outlined">arrow_drop_down</span>
                        </button>
                        <div id="mapel_select_dropdown" class="hidden absolute left-0 right-0 mt-2 z-50 bg-surface border border-outline-variant rounded-lg shadow-lg overflow-hidden">
                            <div class="px-3 py-2 border-b border-outline-variant">
                                <label class="sr-only" for="mapel_search">Cari Mata Pelajaran</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-3 flex items-center text-on-surface-variant">
                                        <span class="material-symbols-outlined text-[18px]">search</span>
                                    </span>
                                    <input id="mapel_search" type="text" placeholder="Cari Mata Pelajaran..." class="w-full pl-10 pr-3 py-2 rounded-lg border border-outline-variant bg-surface-container-lowest text-[14px] text-on-surface focus:ring-1 focus:ring-primary focus:border-primary transition-all" />
                                </div>
                            </div>
                            <div id="mapel_select_options" class="max-h-64 overflow-y-auto">
                                <!-- Options akan diload via AJAX -->
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-[13px] font-bold text-on-surface mb-2">Pilih Kelas </label>
                        <div class="bg-surface-container-lowest border border-outline-variant rounded-lg p-3 h-48 overflow-y-auto">
                            <div class="grid grid-cols-2 gap-2" id="rombel_grid">
                                @foreach($rombels as $rombel)
                                <label class="rombel-label flex items-center p-2 rounded-lg hover:bg-surface-container-low transition-colors cursor-pointer border border-transparent hover:border-outline-variant/30" data-jurusan-id="{{ $rombel->kelas->jurusan_id ?? '' }}">
                                    <input type="checkbox" name="rombel_id[]" value="{{ $rombel->id }}" @checked(in_array($rombel->id, old('rombel_id', []))) class="w-4 h-4 text-primary bg-surface-container border-outline-variant rounded focus:ring-primary focus:ring-2 focus:ring-offset-0">
                                    <span class="ms-2 text-[13px] font-medium text-on-surface">{{ $rombel->tingkat }} ({{ $rombel->kelas->jurusan->nama }})</span>
                                </label>
                                @endforeach
                            </div>
                            <p id="rombel_empty_hint" class="hidden text-[12px] text-on-surface-variant text-center py-6 flex-col items-center justify-center gap-1">
                                <span class="material-symbols-outlined text-[28px] opacity-30 block mx-auto">filter_alt_off</span>
                                Tidak ada kelas yang sesuai dengan jurusan mata pelajaran kejuruan ini.
                            </p>
                        </div>
                        <p id="rombel_filter_hint" class="hidden text-[11px] text-primary mt-2 items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">filter_alt</span>
                            Kelas ditampilkan otomatis sesuai jurusan mata pelajaran kejuruan yang dipilih.
                        </p>
                        <p class="text-[11px] text-on-surface-variant mt-2 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">info</span>
                            Bisa memilih lebih dari 1 kelas.
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
                
                <div class="overflow-x-auto cursor-grab" id="guru-mapel-table-wrapper">
                    <table class="min-w-[840px] w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-surface-container-low border-b border-outline-variant">
                                <th class="py-3 px-4 font-bold text-[12px] text-on-surface uppercase tracking-wider w-12 text-center whitespace-nowrap">No</th>
                                <th class="py-3 px-4 font-bold text-[12px] text-on-surface uppercase tracking-wider whitespace-nowrap">Informasi Guru</th>
                                <th class="py-3 px-4 font-bold text-[12px] text-on-surface uppercase tracking-wider hidden sm:table-cell whitespace-nowrap">Mata Pelajaran</th>
                                <th class="py-3 px-4 font-bold text-[12px] text-on-surface uppercase tracking-wider whitespace-nowrap">Kelas</th>
                                <th class="py-3 px-4 font-bold text-[12px] text-on-surface uppercase tracking-wider text-right whitespace-nowrap">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant/50">
                            @php
                                $grouped = $guruMapels->groupBy(function($i) { return $i->guru->id; });
                            @endphp
                            @forelse($grouped as $gIndex => $items)
                                @php
                                    $first = $items->first();
                                    $uniqueMapels = $items->pluck('mapel.nama_mapel')->unique()->values();
                                    $firstUnique = $uniqueMapels->first();
                                    $assignments = $items->map(function($it){ return ['id' => $it->id, 'mapel' => $it->mapel->nama_mapel, 'rombel' => $it->rombel->tingkat]; })->toJson();
                                @endphp
                                <tr class="hover:bg-surface-container-highest transition-colors group">
                                    <td class="py-3 px-4 text-[13px] text-on-surface-variant text-center font-medium whitespace-nowrap">
                                        {{ $loop->index + 1 }}
                                    </td>
                                    <td class="py-3 px-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-primary-container/20 text-primary flex items-center justify-center font-bold text-[12px]">
                                                {{ substr($first->guru->nama, 0, 1) }}
                                            </div>
                                            <p class="font-bold text-[14px] text-on-surface">{{ $first->guru->nama }}</p>
                                        </div>
                                        <p class="text-[12px] text-on-surface-variant sm:hidden mt-1 whitespace-nowrap">
                                            {{ $firstUnique }}
                                            <span class="inline-block ms-2 align-middle px-2 py-0.5 bg-primary-container/10 text-primary text-[12px] font-bold rounded-full">{{ $items->count() }}</span>
                                        </p>
                                    </td>
                                    <td class="py-3 px-4 hidden sm:table-cell whitespace-nowrap">
                                            <span class="px-2.5 py-1 bg-sky-50 text-sky-700 border border-sky-100 text-[12px] font-bold rounded-lg inline-flex items-center gap-2">
                                            <span>{{ $firstUnique }}</span>
                                            <span class="inline-block px-2 py-0.5 bg-primary-container/10 text-primary text-[12px] font-bold rounded-full">{{ $items->count() }}</span>
                                            </span>
                                    </td>
                                    <td class="py-3 px-4 whitespace-nowrap">
                                        @php
                                            $rombelLabels = $items->pluck('rombel.tingkat')->unique()->values();
                                        @endphp
                                        <span class="px-2.5 py-1 bg-green-50 text-secondary border border-green-200 text-[12px] font-bold rounded-lg">
                                            {{ $rombelLabels->join(', ') }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 text-right whitespace-nowrap">
                                        <div class="inline-flex items-center gap-2">
                                            <button type="button" class="p-1.5 text-primary hover:bg-primary-container/20 rounded-lg transition-colors inline-flex items-center gap-1 detail-button" title="Detail" data-assignments='{{ $assignments }}'>
                                                <span class="material-symbols-outlined text-[18px]">list</span>
                                                <span class="text-[12px] font-bold hidden xl:inline">Detail</span>
                                            </button>

                                            <button type="button" class="p-1.5 text-secondary hover:bg-surface-container-highest rounded-lg transition-colors inline-flex items-center gap-1 edit-button" title="Edit" data-assignments='{{ $assignments }}'>
                                                <span class="material-symbols-outlined text-[18px]">edit</span>
                                                <span class="text-[12px] font-bold hidden xl:inline">Edit</span>
                                            </button>
                                        </div>
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

    <!-- Detail Modal -->
    <div id="guruDetailModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>
        <div class="relative bg-surface rounded-2xl border border-outline-variant w-full max-w-2xl overflow-hidden shadow-2xl" style="animation: modalSlideIn 0.25s ease-out;">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-primary to-primary-container px-6 py-5">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                            <span class="material-symbols-outlined text-white text-[22px]">assignment</span>
                        </div>
                        <div>
                            <h3 class="font-headline font-bold text-[18px] text-white">Detail Penugasan</h3>
                            <p class="text-[12px] text-white/70">Daftar mata pelajaran & kelas yang ditugaskan</p>
                        </div>
                    </div>
                    <button type="button" class="text-white/80 hover:text-white hover:bg-white/20 rounded-full p-2 transition-colors close-detail-modal">
                        <span class="material-symbols-outlined text-[20px]">close</span>
                    </button>
                </div>
            </div>
            <!-- Modal Body -->
            <div class="px-6 py-4">
                <div id="detailModalContent" class="space-y-2.5 max-h-[360px] overflow-y-auto pr-1">
                    <!-- populated by JS -->
                </div>
            </div>
            <!-- Modal Footer -->
            <div class="px-6 py-3 border-t border-outline-variant/50 bg-surface-container-lowest flex justify-between items-center">
                <p id="detailModalCount" class="text-[12px] text-on-surface-variant"></p>
                <button type="button" class="px-4 py-2 text-[13px] font-bold text-primary hover:bg-primary-container/10 rounded-lg transition-colors close-detail-modal">Tutup</button>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="guruEditModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>
        <div class="relative bg-surface rounded-2xl border border-outline-variant w-full max-w-2xl overflow-hidden shadow-2xl" style="animation: modalSlideIn 0.25s ease-out;">
            <!-- Modal Header -->
            <div class="bg-gradient-to-r from-secondary to-green-700 px-6 py-5">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-white/20 flex items-center justify-center">
                            <span class="material-symbols-outlined text-white text-[22px]">edit_note</span>
                        </div>
                        <div>
                            <h3 class="font-headline font-bold text-[18px] text-white">Edit Penugasan</h3>
                            <p class="text-[12px] text-white/70">Kelola atau cabut mata pelajaran yang ditugaskan</p>
                        </div>
                    </div>
                    <button type="button" class="text-white/80 hover:text-white hover:bg-white/20 rounded-full p-2 transition-colors close-edit-modal">
                        <span class="material-symbols-outlined text-[20px]">close</span>
                    </button>
                </div>
            </div>
            <!-- Modal Body -->
            <div class="px-6 py-4">
                <div id="editModalContent" class="space-y-2.5 max-h-[360px] overflow-y-auto pr-1">
                    <!-- populated by JS -->
                </div>
            </div>
            <!-- Modal Footer -->
            <div class="px-6 py-3 border-t border-outline-variant/50 bg-surface-container-lowest flex justify-end">
                <button type="button" class="px-4 py-2 text-[13px] font-bold text-secondary hover:bg-green-50 rounded-lg transition-colors close-edit-modal">Tutup</button>
            </div>
        </div>
    </div>

    <!-- Confirm Detach Modal -->
    <div id="confirmDetachModal" class="hidden fixed inset-0 flex items-center justify-center" style="z-index:99999;">
        <div class="absolute inset-0 bg-black/40 z-0"></div>
        <div class="relative bg-surface rounded-xl border border-outline-variant w-full max-w-md p-5 z-10">
            <h4 class="font-bold text-[15px] text-on-surface mb-2">Konfirmasi Cabut Mata Pelajaran</h4>
            <p id="confirmDetachText" class="text-[13px] text-on-surface-variant mb-4">Yakin ingin mencabut mata pelajaran ini?</p>
            <div class="flex justify-end gap-2">
                <button type="button" class="py-2 px-4 bg-surface-container-low rounded-lg close-confirm-detach">Batal</button>
                <form id="detachForm" method="POST" action="" class="m-0">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="py-2 px-4 bg-error text-white rounded-lg">Cabut</button>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const customDropdown = (buttonId, dropdownId, searchId, optionsId, hiddenInputId, displayTextId, apiUrl = null, extraParams = {}) => {
                const button = document.getElementById(buttonId);
                const dropdown = document.getElementById(dropdownId);
                const search = document.getElementById(searchId);
                const options = document.getElementById(optionsId);
                const hiddenInput = document.getElementById(hiddenInputId);
                const displayText = document.getElementById(displayTextId);

                if (!button || !dropdown || !search || !options || !hiddenInput || !displayText) {
                    return;
                }

                const fetchOptions = async (query = '') => {
                    if (!apiUrl) return;
                    options.innerHTML = '<div class="px-3 py-2 text-[13px] text-on-surface-variant text-center">Memuat...</div>';
                    try {
                        const params = new URLSearchParams({ q: query, ...extraParams });
                        const res = await fetch(`${apiUrl}?${params.toString()}`);
                        const data = await res.json();
                        
                        options.innerHTML = '';
                        if (data.length === 0) {
                            options.innerHTML = '<div class="px-3 py-2 text-[13px] text-on-surface-variant text-center">Tidak ada data ditemukan</div>';
                            return;
                        }
                        
                        data.forEach(item => {
                            const btn = document.createElement('button');
                            btn.type = 'button';
                            btn.className = 'w-full text-left px-3 py-2 hover:bg-surface-container-high transition-colors text-[14px] text-on-surface';
                            btn.dataset.value = item.id;
                            if (item.kelompok !== undefined) btn.dataset.kelompok = item.kelompok;
                            if (item.jurusan_id !== undefined) btn.dataset.jurusanId = item.jurusan_id;
                            btn.textContent = item.text;
                            
                            btn.addEventListener('click', function () {
                                hiddenInput.value = this.dataset.value;
                                if (this.hasAttribute('data-kelompok')) {
                                    hiddenInput.dataset.kelompok = this.dataset.kelompok;
                                    hiddenInput.dataset.jurusanId = this.dataset.jurusanId;
                                }
                                hiddenInput.dispatchEvent(new Event('change'));
                                
                                displayText.textContent = this.textContent.trim();
                                displayText.classList.remove('text-on-surface-variant');
                                displayText.classList.add('text-on-surface');
                                dropdown.classList.add('hidden');
                                button.setAttribute('aria-expanded', 'false');
                            });
                            options.appendChild(btn);
                        });
                    } catch (e) {
                        options.innerHTML = '<div class="px-3 py-2 text-[13px] text-error text-center">Gagal memuat data</div>';
                    }
                };

                button.addEventListener('click', function () {
                    const isOpen = !dropdown.classList.contains('hidden');
                    if (isOpen) {
                        dropdown.classList.add('hidden');
                        button.setAttribute('aria-expanded', 'false');
                    } else {
                        dropdown.classList.remove('hidden');
                        button.setAttribute('aria-expanded', 'true');
                        search.focus();
                        if (apiUrl && options.children.length === 0) {
                            fetchOptions();
                        }
                    }
                });

                let searchTimeout;
                search.addEventListener('input', function () {
                    const query = this.value.trim().toLowerCase();
                    if (apiUrl) {
                        clearTimeout(searchTimeout);
                        searchTimeout = setTimeout(() => {
                            fetchOptions(query);
                        }, 300);
                    } else {
                        options.querySelectorAll('button[data-value]').forEach(option => {
                            const text = option.textContent.trim().toLowerCase();
                            option.style.display = query && !text.includes(query) ? 'none' : 'block';
                        });
                    }
                });

                // Pulihkan pilihan dari old input (setelah validasi gagal)
                if (hiddenInput.value && !apiUrl) {
                    const selected = options.querySelector(`button[data-value="${hiddenInput.value}"]`);
                    if (selected) {
                        if (selected.hasAttribute('data-kelompok')) {
                            hiddenInput.dataset.kelompok = selected.dataset.kelompok;
                            hiddenInput.dataset.jurusanId = selected.dataset.jurusanId;
                        }
                        displayText.textContent = selected.textContent.trim();
                        displayText.classList.remove('text-on-surface-variant');
                        displayText.classList.add('text-on-surface');
                    }
                }
            };

            customDropdown('guru_select_button', 'guru_select_dropdown', 'guru_search', 'guru_select_options', 'guru_id', 'guru_select_text', '/penugasan/gurus');
            customDropdown('mapel_select_button', 'mapel_select_dropdown', 'mapel_search', 'mapel_select_options', 'mapel_id', 'mapel_select_text', '/penugasan/mapels');

            document.addEventListener('click', function (event) {
                const dropdowns = document.querySelectorAll('[id$="_select_dropdown"]');
                dropdowns.forEach(dropdown => {
                    const button = document.getElementById(dropdown.id.replace('_dropdown', '_button'));
                    if (!dropdown.classList.contains('hidden') && button && !dropdown.contains(event.target) && !button.contains(event.target)) {
                        dropdown.classList.add('hidden');
                        button.setAttribute('aria-expanded', 'false');
                    }
                });
            });

            const mapelInput = document.getElementById('mapel_id');
            const rombelEmptyHint = document.getElementById('rombel_empty_hint');
            const rombelFilterHint = document.getElementById('rombel_filter_hint');

            function applyRombelFilter() {
                if (!mapelInput) return;

                const kelompok = (mapelInput.dataset.kelompok || '').toLowerCase();
                const jurusanId = String(mapelInput.dataset.jurusanId || '');
                const isKejuruan = kelompok === 'kejuruan' && jurusanId !== '';
                const rombelLabels = document.querySelectorAll('.rombel-label');
                let visibleCount = 0;

                rombelLabels.forEach(label => {
                    const labelJurusanId = String(label.dataset.jurusanId || '');
                    const hide = isKejuruan && jurusanId !== labelJurusanId;

                    if (hide) {
                        label.style.display = 'none';
                        const checkbox = label.querySelector('input[type="checkbox"]');
                        if (checkbox) checkbox.checked = false;
                    } else {
                        label.style.display = 'flex';
                        visibleCount++;
                    }
                });

                // Petunjuk filter aktif
                if (rombelFilterHint) {
                    rombelFilterHint.classList.toggle('hidden', !isKejuruan);
                    rombelFilterHint.classList.toggle('flex', isKejuruan);
                }

                // Petunjuk kosong bila mapel kejuruan tapi tak ada rombel sesuai
                if (rombelEmptyHint) {
                    const showEmpty = isKejuruan && visibleCount === 0;
                    rombelEmptyHint.classList.toggle('hidden', !showEmpty);
                    rombelEmptyHint.classList.toggle('flex', showEmpty);
                }
            }

            if (mapelInput) {
                mapelInput.addEventListener('change', applyRombelFilter);
                // Terapkan saat load (mis. setelah old input / validasi error)
                applyRombelFilter();
            }

            const tableWrapper = document.getElementById('guru-mapel-table-wrapper');
            if (tableWrapper) {
                let isDragging = false;
                let startX = 0;
                let scrollLeft = 0;

                const onMouseDown = function (e) {
                    isDragging = true;
                    tableWrapper.classList.remove('cursor-grab');
                    tableWrapper.classList.add('cursor-grabbing');
                    // disable text selection while dragging
                    try { document.body.style.userSelect = 'none'; } catch (err) {}
                    startX = e.pageX - tableWrapper.offsetLeft;
                    scrollLeft = tableWrapper.scrollLeft;
                };

                const onMouseLeave = function () {
                    if (!isDragging) return;
                    isDragging = false;
                    tableWrapper.classList.remove('cursor-grabbing');
                    tableWrapper.classList.add('cursor-grab');
                    // restore text selection
                    try { document.body.style.userSelect = ''; } catch (err) {}
                };

                const onMouseUp = function () {
                    if (!isDragging) return;
                    isDragging = false;
                    tableWrapper.classList.remove('cursor-grabbing');
                    tableWrapper.classList.add('cursor-grab');
                    // restore text selection
                    try { document.body.style.userSelect = ''; } catch (err) {}
                };

                const onMouseMove = function (e) {
                    if (!isDragging) return;
                    e.preventDefault();
                    const x = e.pageX - tableWrapper.offsetLeft;
                    const walk = (x - startX) * 1.5;
                    tableWrapper.scrollLeft = scrollLeft - walk;
                };

                tableWrapper.addEventListener('mousedown', onMouseDown);
                tableWrapper.addEventListener('mouseleave', onMouseLeave);
                tableWrapper.addEventListener('mouseup', onMouseUp);
                tableWrapper.addEventListener('mousemove', onMouseMove);
            }

            // Detail & Edit modal handlers
            const detailModal = document.getElementById('guruDetailModal');
            const detailContent = document.getElementById('detailModalContent');
            const editModal = document.getElementById('guruEditModal');
            const editContent = document.getElementById('editModalContent');
            const confirmDetachModal = document.getElementById('confirmDetachModal');
            const confirmDetachText = document.getElementById('confirmDetachText');
            const detachForm = document.getElementById('detachForm');
            const baseDestroyUrl = "{{ url('penugasan/guru-mapel') }}";

            const closeDetailButtons = document.querySelectorAll('.close-detail-modal');
            closeDetailButtons.forEach(b => b.addEventListener('click', () => detailModal.classList.add('hidden')));

            const closeEditButtons = document.querySelectorAll('.close-edit-modal');
            closeEditButtons.forEach(b => b.addEventListener('click', () => editModal.classList.add('hidden')));

            const detailModalCount = document.getElementById('detailModalCount');

            document.querySelectorAll('.detail-button').forEach(btn => {
                btn.addEventListener('click', function () {
                    const assignments = JSON.parse(this.getAttribute('data-assignments') || '[]');
                    detailContent.innerHTML = '';
                    assignments.forEach((a, idx) => {
                        const node = document.createElement('div');
                        node.className = 'group flex items-center gap-4 p-3.5 rounded-xl border border-outline-variant/60 bg-surface-container-lowest hover:bg-surface-container-low hover:border-primary/30 transition-all duration-150';
                        node.innerHTML = `
                            <div class="w-8 h-8 rounded-lg bg-primary-container/15 text-primary flex items-center justify-center font-bold text-[13px] flex-shrink-0">
                                ${idx + 1}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-sky-50 text-sky-700 border border-sky-100 text-[12px] font-bold rounded-lg">
                                        <span class="material-symbols-outlined text-[14px]">menu_book</span>
                                        ${a.mapel}
                                    </span>
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-green-50 text-green-700 border border-green-200 text-[12px] font-bold rounded-lg">
                                        <span class="material-symbols-outlined text-[14px]">meeting_room</span>
                                        ${a.rombel}
                                    </span>
                                </div>
                            </div>`;
                        detailContent.appendChild(node);
                    });
                    if (detailModalCount) {
                        detailModalCount.textContent = `Total: ${assignments.length} penugasan`;
                    }
                    detailModal.classList.remove('hidden');
                });
            });

            document.querySelectorAll('.edit-button').forEach(btn => {
                btn.addEventListener('click', function () {
                    const assignments = JSON.parse(this.getAttribute('data-assignments') || '[]');
                    editContent.innerHTML = '';
                    assignments.forEach((a, idx) => {
                        const node = document.createElement('div');
                        node.className = 'group flex items-center gap-4 p-3.5 rounded-xl border border-outline-variant/60 bg-surface-container-lowest hover:bg-surface-container-low hover:border-secondary/30 transition-all duration-150';
                        node.innerHTML = `
                            <div class="w-8 h-8 rounded-lg bg-green-100 text-secondary flex items-center justify-center font-bold text-[13px] flex-shrink-0">
                                ${idx + 1}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-sky-50 text-sky-700 border border-sky-100 text-[12px] font-bold rounded-lg">
                                        <span class="material-symbols-outlined text-[14px]">menu_book</span>
                                        ${a.mapel}
                                    </span>
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-green-50 text-green-700 border border-green-200 text-[12px] font-bold rounded-lg">
                                        <span class="material-symbols-outlined text-[14px]">meeting_room</span>
                                        ${a.rombel}
                                    </span>
                                </div>
                            </div>
                            <button type="button" class="py-1.5 px-3 bg-error/10 text-error border border-error/20 hover:bg-error hover:text-white rounded-lg detach-btn inline-flex items-center gap-1.5 transition-colors flex-shrink-0" data-id="${a.id}" data-mapel="${a.mapel}">
                                <span class="material-symbols-outlined text-[16px]">person_remove</span>
                                <span class="text-[12px] font-bold">Cabut</span>
                            </button>`;
                        editContent.appendChild(node);
                    });
                    editModal.classList.remove('hidden');
                });
            });

            document.addEventListener('click', function (e) {
                if (e.target.classList && e.target.closest('.detach-btn')) {
                    const btn = e.target.closest('.detach-btn');
                    const id = btn.dataset.id;
                    const mapel = btn.dataset.mapel;
                    confirmDetachText.textContent = `Yakin ingin mencabut mata pelajaran "${mapel}" dari guru ini?`;
                    detachForm.action = `${baseDestroyUrl}/${id}`;
                    confirmDetachModal.classList.remove('hidden');
                }
            });

            document.querySelectorAll('.close-confirm-detach').forEach(b => b.addEventListener('click', () => confirmDetachModal.classList.add('hidden')));
        });
    </script>
    @endpush
</x-app-layout>
