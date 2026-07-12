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
            <tr class="text-gray-400 dark:text-gray-500">
                <td class="py-8 text-center" colspan="3">(Data siswa akan muncul di sini)</td>
            </tr>
        </tbody>
    </table>

    <div class="mt-6 flex justify-end">
        <x-secondary-button @click="$dispatch('close-modal', 'detail-rombel')">Tutup</x-secondary-button>
    </div>
</div>
