{{-- Modal content: student list inside a study group (placeholder for now) --}}
<div class="p-6">
    <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
        Daftar Siswa — <span x-text="selectedRombel?.display_nama"></span>
    </h2>
    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
        <span x-text="selectedRombel?.siswa_count ?? 0"></span> siswa
    </p>

    <table class="mt-4 w-full text-sm">
        <thead>
            <tr class="border-b dark:border-gray-700 text-left text-gray-500 dark:text-gray-400">
                <th class="py-2 pr-4 w-10 font-medium">No</th>
                <th class="py-2 pr-4 font-medium">Nama</th>
                <th class="py-2 font-medium">NIS</th>
            </tr>
        </thead>
        <tbody>
            <template x-if="selectedRombel?.siswa && selectedRombel.siswa.length > 0">
                <template x-for="(siswa, index) in selectedRombel.siswa" :key="index">
                    <tr class="border-b last:border-0 dark:border-gray-700 text-gray-900 dark:text-gray-100 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="py-2 pr-4 text-gray-700 dark:text-gray-300 font-medium" x-text="index + 1"></td>
                        <td class="py-2 pr-4" x-text="siswa.nama"></td>
                        <td class="py-2 text-gray-700 dark:text-gray-300" x-text="siswa.nis"></td>
                    </tr>
                </template>
            </template>
            <template x-if="!selectedRombel?.siswa || selectedRombel.siswa.length === 0">
                <tr class="text-gray-400 dark:text-gray-500">
                    <td class="py-8 text-center" colspan="3">Belum ada siswa terdaftar di rombel ini.</td>
                </tr>
            </template>
        </tbody>
    </table>

    <div class="mt-6 flex justify-end">
        <x-secondary-button @click="$dispatch('close-modal', 'detail-rombel')">Tutup</x-secondary-button>
    </div>
</div>
