<x-app-layout>
    <x-slot name="header">
        {{-- Header: title + action buttons --}}
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                    {{ __('Manajemen Kelas') }}
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Tahun ajaran 2025/2026</p>
            </div>

            <div>
                <a href="{{ route('jurusan.create') }}">
                    <x-primary-button>Tambah Jurusan</x-primary-button>
                </a>
                <a href="{{ route('kelas-rombel.create') }}">
                    <x-primary-button>Tambah Kelas & Rombel</x-primary-button>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col gap-4" x-data="{ selectedRombel: null }">

            {{-- Per-department listing --}}
            @foreach ($jurusans as $jurusan)
                <x-card x-data="{ open: true }">
                    {{-- Collapsible header: department name + rombel count --}}
                    <div @click="open = !open" class="flex items-center justify-between cursor-pointer select-none">
                        <div class="flex items-center gap-2">
                            <span x-text="open ? '▼' : '▶'" class="text-xs text-gray-400"></span>
                            <span class="font-semibold text-gray-900 dark:text-gray-100">{{ $jurusan->singkatan }}</span>
                            @if ($jurusan->kepanjangan ?? false)
                                <span
                                    class="text-sm text-gray-500 dark:text-gray-400">({{ $jurusan->kepanjangan }})</span>
                            @endif
                        </div>
                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $jurusan->kelas->sum(fn($k) => $k->rombel->count()) }} rombel
                        </span>
                    </div>

                    {{-- Collapsible body: study group cards --}}
                    <div x-show="open" x-transition.duration.200ms class="mt-4 flex flex-wrap gap-3">
                        @foreach ($jurusan->kelas->sortBy('tingkat') as $kelas)
                            @foreach ($kelas->rombel as $rombel)
                                @php $displayNama = "{$kelas->tingkat} {$jurusan->singkatan} {$rombel->tingkat}" @endphp
                                <x-card
                                    class="w-56 !p-4 space-y-2 border-gray-100 dark:border-gray-600 shadow-none !bg-gray-50 dark:!bg-gray-900/50 cursor-pointer hover:shadow-md transition-shadow"
                                    @click="selectedRombel = { display_nama: '{{ $displayNama }}', siswa_count: {{ $rombel->siswa->count() }} }; $dispatch('open-modal', 'detail-rombel')">
                                    <div class="flex items-start justify-between gap-2">
                                        <div class="font-medium text-gray-900 dark:text-gray-100">{{ $displayNama }}</div>
                                        <x-button-danger
                                            type="button"
                                            class="!px-3 !py-1.5 !text-[10px]"
                                            @click.stop="$dispatch('open-modal', 'confirm-delete-rombel-{{ $rombel->id }}')">
                                            Hapus
                                        </x-button-danger>
                                    </div>
                                    {{-- Student count --}}
                                    <div class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $rombel->siswa->count() }} siswa</div>
                                    {{-- Homeroom teacher --}}
                                    @php $wali = $rombel->guru->first(); @endphp
                                    @if ($wali)
                                        <div class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300">
                                            <span
                                                class="w-7 h-7 rounded-full bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center text-xs font-medium text-indigo-700 dark:text-indigo-300">
                                                {{ str($wali->nama)->substr(0, 2)->upper() }}
                                            </span>
                                            {{ $wali->nama }}
                                        </div>
                                    @else
                                        <div class="flex items-center gap-2 text-sm text-gray-400 dark:text-gray-500">
                                            <span
                                                class="w-7 h-7 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-xs">
                                                ?
                                            </span>
                                            Belum ada wali
                                        </div>
                                    @endif
                                </x-card>

                                {{-- Delete confirmation modal per rombel --}}
                                <x-modal name="confirm-delete-rombel-{{ $rombel->id }}" :show="false" maxWidth="sm">
                                    <div class="p-6">
                                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Hapus rombel?</h3>
                                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                                            Yakin ingin menghapus <span class="font-semibold">{{ $displayNama }}</span>?
                                        </p>

                                        <div class="mt-6 flex justify-end gap-3">
                                            <x-secondary-button type="button"
                                                @click="$dispatch('close-modal', 'confirm-delete-rombel-{{ $rombel->id }}')">
                                                Batal
                                            </x-secondary-button>

                                            <form action="{{ route('kelas-rombel.destroy', $rombel) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <x-button-danger type="submit">Hapus</x-button-danger>
                                            </form>
                                        </div>
                                    </div>
                                </x-modal>
                            @endforeach
                        @endforeach
                    </div>
                </x-card>
            @endforeach

            {{-- Modal showing student list in a rombel --}}
            <x-modal name="detail-rombel" :show="false" maxWidth="2xl">
                @include('kelas.detail-rombel')
            </x-modal>
        </div>
    </div>
</x-app-layout>
