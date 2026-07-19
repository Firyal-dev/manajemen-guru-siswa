<div class="p-0 flex flex-col h-[80vh] md:h-auto md:max-h-[85vh] bg-surface rounded-2xl overflow-hidden">
    {{-- Header --}}
    <div class="px-6 py-5 border-b border-outline-variant bg-surface-container-lowest flex items-start justify-between shrink-0">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 bg-primary-container/20 rounded-xl flex items-center justify-center text-primary">
                <span class="material-symbols-outlined text-[24px]">meeting_room</span>
            </div>
            <div>
                <h2 class="font-headline text-xl font-bold text-on-surface flex items-center gap-2">
                    Daftar Siswa <span class="text-outline-variant px-1">|</span> <span x-text="selectedRombel?.display_nama"></span>
                </h2>
                <p class="text-[13px] text-on-surface-variant font-medium mt-1">
                    Jumlah: <span x-text="selectedRombel?.siswa_count ?? 0"></span> siswa aktif
                </p>
            </div>
        </div>
        <button @click="$dispatch('close-modal', 'detail-rombel')" class="p-2 text-on-surface-variant hover:bg-surface-container-low rounded-full transition-colors flex items-center justify-center">
            <span class="material-symbols-outlined text-[20px]">close</span>
        </button>
    </div>

    {{-- Content / Table --}}
    <div class="flex-1 overflow-y-auto bg-surface-gray p-6">
        <div class="bg-surface rounded-xl border border-outline-variant card-shadow overflow-hidden">
            <table class="w-full text-[14px]">
                <thead>
                    <tr class="bg-surface-container-lowest border-b border-outline-variant">
                        <th class="py-3 px-5 text-left font-bold text-on-surface w-16">No</th>
                        <th class="py-3 px-5 text-left font-bold text-on-surface">Nama Lengkap</th>
                        <th class="py-3 px-5 text-left font-bold text-on-surface w-32">NIS</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-outline-variant">
                    <template x-if="selectedRombel?.siswa && selectedRombel.siswa.length > 0">
                        <template x-for="(siswa, index) in selectedRombel.siswa" :key="index">
                            <tr class="hover:bg-surface-container-lowest transition-colors group">
                                <td class="py-3 px-5 text-on-surface-variant font-medium" x-text="index + 1"></td>
                                <td class="py-3 px-5 text-on-surface font-semibold group-hover:text-primary transition-colors" x-text="siswa.nama"></td>
                                <td class="py-3 px-5 text-on-surface-variant" x-text="siswa.nis"></td>
                            </tr>
                        </template>
                    </template>
                    <template x-if="!selectedRombel?.siswa || selectedRombel.siswa.length === 0">
                        <tr>
                            <td class="py-12 px-5 text-center text-on-surface-variant" colspan="3">
                                <div class="flex flex-col items-center justify-center gap-2">
                                    <span class="material-symbols-outlined text-[40px] text-outline opacity-50">person_off</span>
                                    <p class="font-medium text-[14px]">Belum ada siswa di kelas ini.</p>
                                </div>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>

    {{-- Footer Actions --}}
    <div class="px-6 py-4 border-t border-outline-variant bg-surface-container-lowest flex items-center justify-between shrink-0">
        <button @click="$dispatch('close-modal', 'detail-rombel')" class="px-5 py-2.5 text-[14px] font-bold text-on-surface-variant hover:bg-surface-container-low rounded-lg transition-colors">
            Kembali
        </button>
        <template x-if="selectedRombel?.id">
            <a :href="`/kelas-rombel/${selectedRombel.id}/assign-siswa`" class="px-6 py-2.5 bg-primary text-white text-[14px] font-bold rounded-lg hover:bg-primary/90 transition-colors flex items-center gap-2 shadow-sm">
                <span class="material-symbols-outlined text-[18px]">group_add</span>
                Atur Siswa
            </a>
        </template>
    </div>
</div>
