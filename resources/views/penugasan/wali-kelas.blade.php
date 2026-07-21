<x-app-layout>
    <x-slot name="header">
        Penugasan Wali Kelas
    </x-slot>

    <div class="mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="font-headline text-[28px] font-bold text-on-surface">Penugasan Wali Kelas</h1>
            <p class="text-[14px] text-on-surface-variant mt-1">Tugaskan guru sebagai wali kelas.</p>
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

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 overflow-visible">
        
        {{-- Form Penugasan --}}
        <div class="lg:col-span-1 overflow-visible">
            <div class="bg-surface rounded-xl border border-outline-variant card-shadow overflow-visible">
                <div class="p-5 border-b border-outline-variant bg-surface-container-lowest rounded-t-xl">
                    <h2 class="font-bold text-[16px] text-on-surface flex items-center gap-2">
                        <span class="material-symbols-outlined text-primary">assignment_ind</span>
                        Tugaskan Wali Kelas Baru
                    </h2>
                </div>
                
                <form method="post" action="{{ route('penugasan.wali-kelas.store') }}" class="p-5 space-y-5 relative z-0 overflow-visible">
                    @csrf
                    
                    <div class="relative">
                        <label class="block text-[13px] font-bold text-on-surface mb-2">Pilih Guru</label>
                        <input type="hidden" id="guru_id" name="guru_id" required>
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
                                @foreach($gurus as $guru)
                                    <button type="button" data-value="{{ $guru->id }}" class="w-full text-left px-3 py-2 hover:bg-surface-container-high transition-colors text-[14px] text-on-surface">{{ $guru->nama }}</button>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="relative">
                        <label class="block text-[13px] font-bold text-on-surface mb-2">Pilih Kelas</label>
                        <input type="hidden" id="rombel_id" name="rombel_id" required>
                        <div class="bg-surface-container-lowest border border-outline-variant rounded-lg p-3 h-48">
                            <div class="px-0 pb-3 border-b border-outline-variant mb-3">
                                <label class="sr-only" for="rombel_search">Cari Kelas</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-3 flex items-center text-on-surface-variant">
                                        <span class="material-symbols-outlined text-[18px]">search</span>
                                    </span>
                                    <input id="rombel_search" type="text" placeholder="Cari kelas..." class="w-full pl-10 pr-3 py-2 rounded-lg border border-outline-variant bg-surface-container-lowest text-[14px] text-on-surface focus:ring-1 focus:ring-primary focus:border-primary transition-all" />
                                </div>
                            </div>
                            <div id="rombel_options" class="space-y-2 overflow-y-auto h-[calc(100%-64px)] px-0">
                                @foreach($rombels as $rombel)
                                <label data-value="{{ $rombel->id }}" class="rombel-option flex items-center p-2 rounded-lg hover:bg-surface-container-low transition-colors cursor-pointer border border-transparent hover:border-outline-variant/30">
                                    <input type="radio" name="rombel_radio" value="{{ $rombel->id }}" class="rombel-input w-4 h-4 text-primary bg-surface-container border-outline-variant focus:ring-primary focus:ring-2 focus:ring-offset-0">
                                    <span class="ms-2 text-[13px] font-medium text-on-surface">{{ $rombel->tingkat }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        <p class="text-[11px] text-on-surface-variant mt-2 flex items-center gap-1">
                            <span class="material-symbols-outlined text-[14px]">info</span>
                            Satu kelas hanya bisa memiliki satu wali kelas.
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
                                <th class="py-3 px-4 font-bold text-[12px] text-on-surface uppercase tracking-wider">Kelas</th>
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

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const customDropdown = (buttonId, dropdownId, searchId, optionsId, hiddenInputId, displayTextId) => {
                const button = document.getElementById(buttonId);
                const dropdown = document.getElementById(dropdownId);
                const search = document.getElementById(searchId);
                const options = document.getElementById(optionsId);
                const hiddenInput = document.getElementById(hiddenInputId);
                const displayText = document.getElementById(displayTextId);

                if (!button || !dropdown || !search || !options || !hiddenInput || !displayText) {
                    return;
                }

                button.addEventListener('click', function () {
                    const isOpen = !dropdown.classList.contains('hidden');
                    if (isOpen) {
                        dropdown.classList.add('hidden');
                        button.setAttribute('aria-expanded', 'false');
                    } else {
                        dropdown.classList.remove('hidden');
                        button.setAttribute('aria-expanded', 'true');
                        search.focus();
                    }
                });

                options.querySelectorAll('button[data-value]').forEach(option => {
                    option.addEventListener('click', function () {
                        hiddenInput.value = this.dataset.value;
                        displayText.textContent = this.textContent.trim();
                        displayText.classList.remove('text-on-surface-variant');
                        displayText.classList.add('text-on-surface');
                        dropdown.classList.add('hidden');
                        button.setAttribute('aria-expanded', 'false');
                    });
                });

                search.addEventListener('input', function () {
                    const query = this.value.trim().toLowerCase();
                    options.querySelectorAll('button[data-value]').forEach(option => {
                        const text = option.textContent.trim().toLowerCase();
                        option.style.display = query && !text.includes(query) ? 'none' : 'block';
                    });
                });
            };

            customDropdown('guru_select_button', 'guru_select_dropdown', 'guru_search', 'guru_select_options', 'guru_id', 'guru_select_text');
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Close guru dropdown when clicking outside or pressing Escape
            document.addEventListener('click', function (e) {
                const button = document.getElementById('guru_select_button');
                const dropdown = document.getElementById('guru_select_dropdown');
                if (!button || !dropdown) return;
                if (!button.contains(e.target) && !dropdown.contains(e.target)) {
                    if (!dropdown.classList.contains('hidden')) {
                        dropdown.classList.add('hidden');
                        button.setAttribute('aria-expanded', 'false');
                    }
                }
            });

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') {
                    const button = document.getElementById('guru_select_button');
                    const dropdown = document.getElementById('guru_select_dropdown');
                    if (!button || !dropdown) return;
                    if (!dropdown.classList.contains('hidden')) {
                        dropdown.classList.add('hidden');
                        button.setAttribute('aria-expanded', 'false');
                    }
                }
            });

            // Rombel: searchable list and toggle-select (click again to deselect)
            const rombelHidden = document.getElementById('rombel_id');
            const rombelSearch = document.getElementById('rombel_search');
            const rombelOptions = document.getElementById('rombel_options');

            if (rombelHidden && rombelSearch && rombelOptions) {
                // Filter rombel list
                rombelSearch.addEventListener('input', function () {
                    const q = this.value.trim().toLowerCase();
                    rombelOptions.querySelectorAll('.rombel-option').forEach(label => {
                        const text = label.textContent.trim().toLowerCase();
                        label.style.display = q && !text.includes(q) ? 'none' : 'flex';
                    });
                });

                // Handle toggle selection
                rombelOptions.querySelectorAll('.rombel-option').forEach(label => {
                    const input = label.querySelector('input[type="radio"]');
                    if (!input) return;
                    let wasChecked = false;

                    input.addEventListener('mousedown', function () {
                        wasChecked = this.checked;
                    });

                    input.addEventListener('click', function (e) {
                        if (wasChecked) {
                            // Deselect
                            this.checked = false;
                            rombelHidden.value = '';
                            label.classList.remove('bg-surface-container-high', 'border-outline-variant/30');
                        } else {
                            // Select this and clear others' highlight
                            rombelOptions.querySelectorAll('.rombel-option').forEach(l => l.classList.remove('bg-surface-container-high', 'border-outline-variant/30'));
                            label.classList.add('bg-surface-container-high', 'border-outline-variant/30');
                            rombelHidden.value = this.value;
                        }
                    });
                });

                // If a label itself (not just the input) is clicked, ensure focus/selection
                rombelOptions.querySelectorAll('.rombel-option').forEach(label => {
                    label.addEventListener('click', function (e) {
                        const input = this.querySelector('input[type="radio"]');
                        if (!input) return;
                        // let the input click handler manage selection/deselection
                    });
                });
            }
        });
    </script>
    @endpush
</x-app-layout>
