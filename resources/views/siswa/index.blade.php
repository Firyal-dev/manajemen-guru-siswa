<x-app-layout>
    <x-slot name="header">
        {{-- Header: title + add button --}}
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Manajemen Siswa') }}
            </h2>
            <a href="{{ route('siswa.create') }}">
                <x-primary-button>Tambah Siswa</x-primary-button>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Flash success message --}}
            @if (session('success'))
                <div class="mb-4 px-4 py-3 rounded-lg bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 text-sm font-medium">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Master-detail layout: table (left) + detail panel (right) --}}
            <x-master-detail placeholder="Pilih siswa untuk melihat detail">
                <x-slot name="table">
                    {{-- Search bar --}}
                    <div class="px-4 mb-4">
                        <form method="GET" action="{{ route('siswa') }}">
                            <div class="relative">
                                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Cari nama, NIS, atau NISN..."
                                    class="w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm
                                           focus:border-indigo-500 focus:ring-indigo-500
                                           dark:bg-gray-900 dark:text-gray-300 text-sm pl-9 pr-8">
                                @if (request('search'))
                                    <a href="{{ route('siswa') }}"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                        &times;
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>

                    {{-- Student table --}}
                    <table class="w-full text-base">
                        <thead>
                            <tr class="border-b dark:border-gray-700 text-left text-gray-500 dark:text-gray-400">
                                <th class="py-3 px-4 font-medium w-12">No</th>
                                <th class="py-3 px-4 font-medium">Nama</th>
                                <th class="py-3 px-4 font-medium">NIS</th>
                                <th class="py-3 px-4 font-medium">NISN</th>
                                <th class="py-3 px-4 font-medium">Kelas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($siswas as $index => $siswa)
                                @php
                                    $siswaData = [
                                        'id'      => $siswa->id,
                                        'nama'    => $siswa->nama,
                                        'nis'     => $siswa->nis,
                                        'nisn'    => $siswa->nisn,
                                        'agama'   => $siswa->agama,
                                        'kelamin' => $siswa->kelamin?->value,
                                        'kelamin_label' => $siswa->kelamin?->label(),
                                        'rombel'  => $siswa->rombel?->kelas?->nama_kelas ?? '-',
                                        'tingkat' => $siswa->rombel?->tingkat ?? '-',
                                    ];
                                @endphp
                                <tr @click="selected = {{ json_encode($siswaData) }}"
                                    class="cursor-pointer border-b dark:border-gray-700 last:border-0 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
                                    :class="selected?.id === {{ $siswa->id }} && 'bg-indigo-50 dark:bg-indigo-900/30'">
                                    <td class="py-3 px-4 text-gray-700 dark:text-gray-300">
                                        {{ ($siswas->currentPage() - 1) * $siswas->perPage() + $index + 1 }}
                                    </td>
                                    <td class="py-3 px-4 text-gray-900 dark:text-gray-100">{{ $siswa->nama }}</td>
                                    <td class="py-3 px-4 text-gray-700 dark:text-gray-300">{{ $siswa->nis }}</td>
                                    <td class="py-3 px-4 text-gray-700 dark:text-gray-300">{{ $siswa->nisn }}</td>
                                    <td class="py-3 px-4 text-gray-700 dark:text-gray-300">
                                        {{ $siswa->rombel?->tingkat ?? '-' }} {{ $siswa->rombel?->kelas?->nama_kelas ?? '' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-8 text-center text-gray-500 dark:text-gray-400">
                                        Belum ada data siswa.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    {{-- Pagination --}}
                    <div class="mt-6 px-4">
                        {{ $siswas->links() }}
                    </div>
                </x-slot>

                {{-- Detail panel: shows when a student is selected --}}
                <div x-show="selected">
                    <template x-if="selected">
                        <div>
                            {{-- Avatar + name header --}}
                            <div class="flex items-center gap-4 mb-6">
                                <div class="w-16 h-16 rounded-full flex items-center justify-center text-2xl font-bold text-white"
                                    :class="selected.kelamin === 'laki_laki' ? 'bg-blue-500' : 'bg-pink-500'">
                                    <span x-text="selected.nama.charAt(0).toUpperCase()"></span>
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100"
                                        x-text="selected.nama"></h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400" x-text="`NIS: ${selected.nis}`"></p>
                                </div>
                            </div>

                            {{-- Detail fields --}}
                            <dl class="mt-4 space-y-4">
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">NISN</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100" x-text="selected.nisn"></dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Agama</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100" x-text="selected.agama"></dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Jenis Kelamin</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100" x-text="selected.kelamin_label"></dd>
                                </div>
                                <div>
                                    <dt class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Kelas / Rombel</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100">
                                        <span x-text="selected.tingkat"></span>
                                        <span x-text="selected.rombel"></span>
                                    </dd>
                                </div>
                            </dl>

                            {{-- Action buttons --}}
                            <div class="mt-6 flex gap-2">
                                <a :href="'{{ url('siswa') }}/' + selected.id + '/edit'">
                                    <x-secondary-button>Edit</x-secondary-button>
                                </a>
                                <x-danger-button @click="$dispatch('open-modal', 'confirm-hapus-siswa')">
                                    Hapus
                                </x-danger-button>
                            </div>
                        </div>
                    </template>
                </div>

                {{-- Delete confirmation modal with reason --}}
                <x-modal name="confirm-hapus-siswa" :show="false" maxWidth="sm">
                    <div class="p-6">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            Konfirmasi Hapus
                        </h2>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            Yakin ingin menghapus data siswa
                            <span class="font-semibold" x-text="selected?.nama"></span>?
                            Tindakan ini tidak dapat dibatalkan.
                        </p>

                        <form method="POST" x-bind:action="'{{ url('siswa') }}/' + selected?.id"
                              @submit="$dispatch('close-modal', 'confirm-hapus-siswa')">
                            @csrf
                            @method('DELETE')

                            {{-- Alasan penghapusan --}}
                            <div class="mt-4">
                                <label for="alasan_hapus" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Alasan penghapusan <span class="text-red-500">*</span>
                                </label>
                                <textarea
                                    id="alasan_hapus"
                                    name="alasan_hapus"
                                    rows="3"
                                    required
                                    placeholder="Contoh: Siswa pindah sekolah, double data, dll."
                                    class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                ></textarea>
                            </div>

                            <div class="mt-5 flex justify-end gap-3">
                                <x-secondary-button type="button" @click="$dispatch('close-modal', 'confirm-hapus-siswa')">
                                    Batal
                                </x-secondary-button>
                                <x-danger-button type="submit">Hapus</x-danger-button>
                            </div>
                        </form>
                    </div>
                </x-modal>
            </x-master-detail>
        </div>
    </div>
</x-app-layout>
