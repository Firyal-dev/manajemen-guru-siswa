<x-app-layout>
    <x-slot name="header">
        Atur Siswa Kelas
    </x-slot>

    <div class="mb-6">
        <a href="{{ route('kelas') }}" class="inline-flex items-center gap-2 text-primary font-bold text-[13px] hover:underline mb-4">
            <span class="material-symbols-outlined text-[16px]">arrow_back</span>
            Kembali ke Data Kelas
        </a>
        <h1 class="font-headline text-[28px] font-bold text-on-surface">Atur Siswa Kelas</h1>
        <p class="text-[14px] text-on-surface-variant mt-1">Pilih dan masukkan siswa ke kelas ini.</p>
    </div>

    @if (session('error'))
        <div class="mb-6 p-4 bg-error-container/30 text-error-crimson rounded-xl border border-error-crimson/20 flex items-center gap-3">
            <span class="material-symbols-outlined text-[20px]">error</span>
            <p class="text-[14px] font-bold">{{ session('error') }}</p>
        </div>
    @endif

    <div class="flex flex-col xl:flex-row gap-6">
        {{-- Left Pane: Rombel Info --}}
        <div class="xl:w-1/3">
            <div class="bg-surface rounded-xl border border-outline-variant card-shadow overflow-hidden sticky top-24">
                <div class="p-6 border-b border-outline-variant bg-surface-container-lowest">
                    <div class="w-14 h-14 bg-primary-container/20 text-primary rounded-2xl flex items-center justify-center mb-4 border border-primary/10">
                        <span class="material-symbols-outlined text-[28px]">meeting_room</span>
                    </div>
                    <h2 class="font-headline text-2xl font-bold text-on-surface mb-1">
                        {{ $rombel->kelas->tingkat }} {{ $rombel->kelas->jurusan->nama }} {{ $rombel->tingkat }}
                    </h2>
                    <p class="text-[13px] text-on-surface-variant font-medium">{{ $rombel->kelas->jurusan->nama }}</p>
                </div>
                
                <div class="p-6 space-y-5 bg-surface">
                    @php $wali = $rombel->guru->first(); @endphp
                    <div>
                        <p class="text-[11px] font-bold text-outline uppercase tracking-wider mb-2">Wali Kelas</p>
                        @if ($wali)
                            <div class="flex items-center gap-3 bg-surface-container-low p-3 rounded-xl border border-outline-variant/50">
                                <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center font-bold text-primary">
                                    {{ strtoupper(substr($wali->nama, 0, 2)) }}
                                </div>
                                <div>
                                    <p class="text-[14px] font-bold text-on-surface">{{ $wali->nama }}</p>
                                    <p class="text-[12px] text-on-surface-variant">{{ $wali->nip }}</p>
                                </div>
                            </div>
                        @else
                            <div class="flex items-center gap-3 bg-surface-container-lowest p-3 rounded-xl border border-outline-variant border-dashed">
                                <div class="w-10 h-10 rounded-full bg-surface-container-high flex items-center justify-center text-outline">
                                    <span class="material-symbols-outlined text-[18px]">person_off</span>
                                </div>
                                <p class="text-[13px] italic text-on-surface-variant">Belum ditugaskan</p>
                            </div>
                        @endif
                    </div>

                    <div>
                        <p class="text-[11px] font-bold text-outline uppercase tracking-wider mb-2">Tahun Ajaran</p>
                        <div class="flex items-center gap-2">
                            <span class="material-symbols-outlined text-secondary-fixed-dim">event</span>
                            <p class="text-[14px] font-bold text-on-surface">{{ $rombel->tahunAjaran->tahun_mulai }} / {{ $rombel->tahunAjaran->tahun_selesai }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Pane: Student List & Selection --}}
        <div class="xl:w-2/3">
            <form method="POST" action="{{ route('kelas-rombel.update-assign-siswa', $rombel) }}" 
                  x-data="studentAssignment({{ json_encode($assignedSiswaIds) }}, {{ $rombel->id }}, {{ $rombel->tahun_ajaran_id }})" 
                  @submit.prevent="submitForm"
                  class="bg-surface rounded-xl border border-outline-variant card-shadow overflow-hidden flex flex-col h-[700px]">
                @csrf
                
                {{-- Toolbar --}}
                <div class="p-5 border-b border-outline-variant bg-surface-container-lowest flex flex-col sm:flex-row gap-4 items-center justify-between shrink-0">
                    <div class="relative w-full sm:w-72">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant text-[20px]">search</span>
                        <input type="text" x-model="searchQuery" placeholder="Cari nama atau NIS siswa..."
                            class="w-full bg-surface-container-low border border-outline-variant text-on-surface text-[14px] rounded-lg pl-10 pr-4 py-2 focus:ring-1 focus:ring-primary focus:border-primary transition-all">
                    </div>
                    
                    <div class="flex items-center gap-4 text-[13px] font-medium text-on-surface-variant">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" x-model="showSelectedOnly" class="w-4 h-4 text-primary bg-surface border-outline-variant rounded focus:ring-primary focus:ring-2 focus:ring-offset-0 transition-colors">
                            <span>Hanya tampilkan yang terpilih</span>
                        </label>
                        <span>Terpilih: <strong class="text-primary font-bold" x-text="selectedIds.length"></strong></span>
                    </div>
                </div>

                {{-- Scrollable List --}}
                <div class="flex-1 overflow-y-auto bg-surface-gray p-5 relative">
                    {{-- Loader overlay --}}
                    <div x-show="loading" class="absolute inset-0 bg-surface/50 backdrop-blur-sm z-10 flex items-center justify-center">
                        <div class="w-8 h-8 border-4 border-primary border-t-transparent rounded-full animate-spin"></div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <template x-for="siswa in students" :key="siswa.id">
                            <label class="flex items-start p-3 rounded-xl border transition-all cursor-pointer select-none group relative overflow-hidden"
                                :class="selectedIds.includes(siswa.id) ? 'bg-primary-container/10 border-primary shadow-sm' : 'bg-surface border-outline-variant/60 hover:border-primary/50'">
                                
                                <div class="absolute right-0 top-0 bottom-0 w-1 bg-primary transition-transform duration-200"
                                     :class="selectedIds.includes(siswa.id) ? 'scale-y-100' : 'scale-y-0'"></div>
                                
                                <div class="flex items-center h-5 mt-0.5">
                                    <input type="checkbox" name="siswa_ids[]" :value="siswa.id" x-model="selectedIds"
                                        class="w-4 h-4 text-primary bg-surface-container border-outline-variant rounded focus:ring-primary focus:ring-2 focus:ring-offset-0 transition-colors">
                                </div>
                                <div class="ml-3 flex-1 min-w-0">
                                    <p class="text-[14px] font-bold text-on-surface truncate group-hover:text-primary transition-colors" x-text="siswa.nama"></p>
                                    <p class="text-[12px] text-on-surface-variant flex items-center gap-1 mt-0.5">
                                        <span class="material-symbols-outlined text-[14px] opacity-70">badge</span>
                                        <span x-text="siswa.nis"></span>
                                    </p>
                                    
                                    {{-- Warning if student is from another ACTIVE rombel --}}
                                    <template x-if="siswa.rombel_aktif && siswa.rombel_aktif.id !== currentRombelId">
                                        <div class="mt-2 inline-flex items-center gap-1 px-1.5 py-0.5 bg-amber-50 text-amber-700 border border-amber-200 rounded text-[10px] font-bold">
                                            <span class="material-symbols-outlined text-[12px]">warning</span>
                                            Sudah di kelas lain
                                        </div>
                                    </template>
                                </div>
                            </label>
                        </template>

                        <template x-if="students.length === 0 && !loading">
                            <div class="col-span-full py-12 text-center flex flex-col items-center justify-center text-on-surface-variant">
                                <span class="material-symbols-outlined text-[48px] opacity-20 mb-3">person_search</span>
                                <p class="text-[15px] font-bold">Tidak ada siswa yang cocok.</p>
                                <p class="text-[13px] mt-1">Coba ubah kata kunci pencarian Anda.</p>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- Pagination Controls --}}
                <div class="p-3 border-t border-outline-variant bg-surface flex items-center justify-between shrink-0">
                    <p class="text-[13px] text-on-surface-variant">
                        Menampilkan <span class="font-bold text-on-surface" x-text="students.length"></span> dari <span class="font-bold text-on-surface" x-text="total"></span> siswa
                    </p>
                    <div class="flex items-center gap-2">
                        <button type="button" @click="prevPage" :disabled="page === 1" class="p-1.5 rounded-lg border border-outline-variant text-on-surface hover:bg-surface-container-low disabled:opacity-50 disabled:cursor-not-allowed">
                            <span class="material-symbols-outlined text-[18px]">chevron_left</span>
                        </button>
                        <span class="text-[13px] font-bold text-on-surface px-2">Hal <span x-text="page"></span> / <span x-text="lastPage"></span></span>
                        <button type="button" @click="nextPage" :disabled="page === lastPage || lastPage === 0" class="p-1.5 rounded-lg border border-outline-variant text-on-surface hover:bg-surface-container-low disabled:opacity-50 disabled:cursor-not-allowed">
                            <span class="material-symbols-outlined text-[18px]">chevron_right</span>
                        </button>
                    </div>
                </div>

                {{-- Footer Actions --}}
                <div class="p-5 border-t border-outline-variant bg-surface-container-lowest flex items-center justify-end shrink-0">
                    <button type="submit" class="px-6 py-3 bg-primary text-white text-[14px] font-bold rounded-xl hover:bg-primary/90 transition-all flex items-center gap-2 shadow-sm">
                        <span class="material-symbols-outlined text-[20px]">save</span>
                        Simpan Penugasan Siswa
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('studentAssignment', (initialSelectedIds, currentRombelId, activeTaId) => ({
                currentRombelId: currentRombelId,
                activeTaId: activeTaId,
                searchQuery: '',
                selectedIds: initialSelectedIds,
                showSelectedOnly: false,
                students: [],
                loading: false,
                page: 1,
                lastPage: 1,
                total: 0,
                searchTimeout: null,
                
                init() {
                    this.fetchStudents();
                    
                    // Watch for search query and filter changes
                    this.$watch('searchQuery', () => {
                        clearTimeout(this.searchTimeout);
                        this.searchTimeout = setTimeout(() => {
                            this.page = 1;
                            this.fetchStudents();
                        }, 300);
                    });
                    
                    this.$watch('showSelectedOnly', () => {
                        this.page = 1;
                        this.fetchStudents();
                    });
                },
                
                async fetchStudents() {
                    this.loading = true;
                    try {
                        const payload = {
                            q: this.searchQuery,
                            page: this.page,
                            ta_id: this.activeTaId,
                            filter_selected: this.showSelectedOnly,
                            selected_ids: this.showSelectedOnly ? this.selectedIds : []
                        };
                        
                        const response = await fetch(`/kelas-rombel/api/siswas`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify(payload)
                        });
                        const data = await response.json();
                        this.students = data.data;
                        this.page = data.current_page;
                        this.lastPage = data.last_page;
                        this.total = data.total;
                    } catch (e) {
                        console.error("Failed to fetch students", e);
                    }
                    this.loading = false;
                },
                
                nextPage() {
                    if (this.page < this.lastPage) {
                        this.page++;
                        this.fetchStudents();
                    }
                },
                
                prevPage() {
                    if (this.page > 1) {
                        this.page--;
                        this.fetchStudents();
                    }
                },
                
                submitForm($event) {
                    const form = $event.target;
                    // Remove any previously appended hidden inputs
                    form.querySelectorAll('input.siswa-id-hidden').forEach(el => el.remove());
                    
                    // Append hidden inputs for each selected ID
                    this.selectedIds.forEach(id => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'siswa_ids[]';
                        input.value = id;
                        input.className = 'siswa-id-hidden';
                        form.appendChild(input);
                    });
                    
                    // Submit
                    form.submit();
                }
            }));
        });
    </script>
    @endpush
</x-app-layout>
