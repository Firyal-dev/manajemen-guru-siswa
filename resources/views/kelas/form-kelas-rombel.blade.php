<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Tambah Kelas & Rombel
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Combined grade + study group creation form --}}
            <form method="POST" action="{{ route('kelas-rombel.store') }}" x-data="{ rombels: [] }">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">

                    {{-- Left: Grade data --}}
                    <x-card>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Data Kelas</h3>

                        {{-- Department selector --}}
                        <div class="mb-6">
                            <x-input-label for="jurusan_id" value="Jurusan" />
                            <select id="jurusan_id" name="jurusan_id" required
                                class="mt-1 block w-full border-gray-300 white:border-gray-700 white:bg-gray-900 dark:text-gray-700 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm @error('jurusan_id') border-red-500 dark:border-red-400 @enderror">
                                <option value="">Pilih jurusan</option>
                                @foreach ($jurusans as $j)
                                    <option value="{{ $j->id }}" @selected(old('jurusan_id') == $j->id)>
                                        {{ $j->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('jurusan_id')
                                <x-input-error :messages="$message" class="mt-2" />
                            @enderror
                        </div>

                        {{-- Grade level selector --}}
                        <div class="mb-6">
                            <x-input-label for="tingkat" value="Tingkat" />
                            <select id="tingkat" name="tingkat" required
                                class="mt-1 block w-full border-gray-300 white:border-gray-700 white:bg-gray-900 dark:text-gray-700 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm @error('tingkat') border-red-500 dark:border-red-400 @enderror">
                                <option value="">Pilih tingkat</option>
                                @foreach (['X', 'XI', 'XII', 'XIII'] as $t)
                                    <option value="{{ $t }}" @selected(old('tingkat') == $t)>{{ $t }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tingkat')
                                <x-input-error :messages="$message" class="mt-2" />
                            @enderror
                        </div>
                    </x-card>

                    {{-- Right: Study groups (dynamic Alpine.js list) --}}
                    <x-card>
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Data Rombel</h3>
                            <x-secondary-button type="button" @click="rombels.push({ tingkat: '', kurikulum_id: '1' })">
                                + Tambahkan rombel
                            </x-secondary-button>
                        </div>

                        <div class="max-h-96 overflow-y-auto pr-1">
                            <template x-if="rombels.length === 0">
                                <p class="text-sm text-gray-500 dark:text-gray-400 text-center py-8">
                                    Belum ada rombel ditambahkan
                                </p>
                            </template>

                            <template x-for="(rombel, index) in rombels" :key="index">
                                <div class="mb-4 p-4 rounded-lg border border-gray-200 dark:border-gray-600 relative">
                                    {{-- Hidden academic year ID --}}
                                    <input type="hidden" x-bind:name="`rombels[${index}][tahun_ajaran_id]`"
                                        value="{{ $tahunAjaran->id ?? '' }}" />

                                    {{-- Remove button --}}
                                    <button type="button" @click="rombels.splice(index, 1)"
                                        class="absolute top-2 right-2 text-gray-400 hover:text-red-500 dark:hover:text-red-400 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>

                                    {{-- Rombel number input --}}
                                    <div class="mb-3">
                                        <x-input-label x-bind:for="`rombel_${index}_tingkat`">
                                            <span x-text="`Rombel ${index + 1}`"></span>
                                        </x-input-label>
                                        <x-text-input type="number" x-bind:id="`rombel_${index}_tingkat`"
                                            x-bind:name="`rombels[${index}][tingkat]`" class="mt-1 block w-full"
                                            placeholder="Nomor rombel" min="1" x-model="rombel.tingkat" required />
                                    </div>

                                    {{-- Kurikulum selector --}}
                                    <div>
                                        <x-input-label x-bind:for="`rombel_${index}_kurikulum`" value="Kurikulum" />
                                        <select x-bind:id="`rombel_${index}_kurikulum`" x-bind:name="`rombels[${index}][kurikulum_id]`" required x-model="rombel.kurikulum_id"
                                            class="mt-1 block w-full border-gray-300 white:border-gray-700 white:bg-gray-900 dark:text-gray-700 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                            <option value="">Pilih kurikulum</option>
                                            @foreach ($kurikulums as $k)
                                                <option value="{{ $k->id }}">
                                                    {{ $k->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </x-card>
                </div>

                {{-- Submit / Cancel --}}
                <div class="flex items-center justify-center gap-3 mt-5">
                    <x-primary-button>Simpan</x-primary-button>
                    <a href="{{ route('kelas') }}">
                        <x-secondary-button type="button">Batal</x-secondary-button>
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
