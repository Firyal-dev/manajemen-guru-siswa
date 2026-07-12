<x-app-layout>
    <x-slot name="header">
        {{-- Header: title + add button --}}
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Manajemen Guru') }}
            </h2>
            <a href="{{ route('guru.create') }}">
                <x-primary-button>Tambah Guru</x-primary-button>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Master-detail layout: table (left) + detail panel (right) --}}
            <x-master-detail placeholder="Pilih guru untuk melihat detail">
                <x-slot name="table">
                    {{-- Search bar --}}
                    <div class="px-4 mb-4">
                        <form method="GET" action="{{ route('guru') }}">
                            <div class="relative">
                                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Cari nama atau NIP..."
                                    class="w-full rounded-md border-gray-300 dark:border-gray-700 shadow-sm
                                           focus:border-indigo-500 focus:ring-indigo-500
                                           dark:bg-gray-900 dark:text-gray-300 text-sm pl-9 pr-8">
                                @if (request('search'))
                                    <a href="{{ route('guru') }}"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                        &times;
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>

                    {{-- Teacher table --}}
                    <table class="w-full text-base">
                        <thead>
                            <tr class="border-b dark:border-gray-700 text-left text-gray-500 dark:text-gray-400">
                                <th class="py-3 px-4 font-medium w-12">No</th>
                                <th class="py-3 px-4 font-medium">Nama</th>
                                <th class="py-3 px-4 font-medium">NIP</th>
                                <th class="py-3 px-4 font-medium">Agama</th>
                                <th class="py-3 px-4 font-medium">Kelamin</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($gurus as $index => $guru)
                                <tr @click="selected = {{ $guru->toJson() }}"
                                    class="cursor-pointer border-b dark:border-gray-700 last:border-0 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors"
                                    :class="selected?.id === {{ $guru->id }} && 'bg-indigo-50 dark:bg-indigo-900/30'">
                                    <td class="py-3 px-4 text-gray-700 dark:text-gray-300">{{ $index + 1 }}</td>
                                    <td class="py-3 px-4 text-gray-900 dark:text-gray-100">{{ $guru->nama }}</td>
                                    <td class="py-3 px-4 text-gray-700 dark:text-gray-300">{{ $guru->nip }}</td>
                                    <td class="py-3 px-4 text-gray-700 dark:text-gray-300">{{ $guru->agama }}</td>
                                    <td class="py-3 px-4 text-gray-700 dark:text-gray-300">
                                        {{ $guru->kelamin->label() }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-8 text-center text-gray-500 dark:text-gray-400">
                                        Belum ada data guru.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{-- Pagination --}}
                    <div class="mt-6 px-4">
                        {{ $gurus->links() }}
                    </div>
                </x-slot>

                {{-- Detail panel: shows when a teacher is selected --}}
                <div x-show="selected">
                    <template x-if="selected">
                        <div>
                            {{-- Photo + name header --}}
                            <div class="flex items-center gap-4 mb-6">
                                <img :src="`/storage/${selected.url_foto}`" alt="Foto profil"
                                    class="w-20 h-20 rounded-full object-cover bg-gray-200 dark:bg-gray-700"
                                    x-on:error.once="$event.target.src='{{ asset('user-placeholder.png') }}'">
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100"
                                        x-text="selected.nama"></h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400" x-text="selected.nip"></p>
                                </div>
                            </div>

                            {{-- Detail fields --}}
                            <dl class="mt-6 space-y-4">
                                <div>
                                    <dt
                                        class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        NIP</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100" x-text="selected.nip">
                                    </dd>
                                </div>
                                <div>
                                    <dt
                                        class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Agama</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100" x-text="selected.agama">
                                    </dd>
                                </div>
                                <div>
                                    <dt
                                        class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                        Jenis Kelamin</dt>
                                    <dd class="mt-1 text-sm text-gray-900 dark:text-gray-100"
                                        x-text="selected.kelamin === 'laki_laki' ? 'Laki-laki' : 'Perempuan'"></dd>
                                </div>
                            </dl>

                            {{-- Action buttons --}}
                            <div class="mt-6 flex gap-2">
                                <a :href="`/guru/${selected.id}/edit`">
                                    <x-secondary-button>Edit</x-secondary-button>
                                </a>
                                <x-danger-button @click="$dispatch('open-modal', 'confirm-hapus')">
                                    Hapus
                                </x-danger-button>
                            </div>
                        </div>
                    </template>
                </div>

                {{-- Delete confirmation modal --}}
                <x-modal name="confirm-hapus" :show="false" maxWidth="sm">
                    <div class="p-6">
                        <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                            Konfirmasi Hapus
                        </h2>
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                            Yakin ingin menghapus data guru
                            <span class="font-semibold" x-text="selected.nama"></span>?
                        </p>
                        <div class="mt-6 flex justify-end gap-3">
                            <x-secondary-button @click="$dispatch('close-modal', 'confirm-hapus')">
                                Batal
                            </x-secondary-button>
                            <form method="POST" x-bind:action="`/guru/${selected.id}`"
                                  @submit="$dispatch('close-modal', 'confirm-hapus')">
                                @csrf
                                @method('DELETE')
                                <x-danger-button type="submit">Hapus</x-danger-button>
                            </form>
                        </div>
                    </div>
                </x-modal>
            </x-master-detail>
        </div>
    </div>
</x-app-layout>
