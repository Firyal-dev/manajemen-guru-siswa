<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ isset($guru) ? 'Edit Guru' : 'Tambah Guru' }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                {{-- Teacher form — used for both create and edit --}}
                <form method="POST" action="{{ isset($guru) ? route('guru.update', $guru) : route('guru.store') }}"
                    class="p-6" enctype="multipart/form-data">
                    @csrf
                    @isset($guru)
                        @method('PATCH')
                    @endisset

                    {{-- Photo upload --}}
                    <div class="mb-6">
                        <x-input-label for="url_foto" value="Foto" />
                        <input type="file" name="url_foto" id="url_foto" accept=".jpg,.png"
                            class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0
                                file:text-sm file:font-semibold
                                file:bg-indigo-50 dark:file:bg-indigo-900/30
                                file:text-indigo-700 dark:file:text-indigo-300
                                hover:file:bg-indigo-100 dark:hover:file:bg-indigo-900/50
                                cursor-pointer
                                border-gray-300 dark:border-gray-700 rounded-md shadow-sm
                                focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600
                                @error('url_foto') border-red-500 dark:border-red-400 @enderror"
                            :required="!isset($guru)">
                        @error('url_foto')
                            <x-input-error :messages="$message" class="mt-2" />
                        @enderror
                        @isset($guru)
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Biarkan kosong jika tidak ingin mengganti foto.</p>
                        @endisset
                    </div>

                    {{-- Nama --}}
                    <div class="mb-6">
                        <x-input-label for="nama" value="Nama" />
                        <x-text-input id="nama" name="nama" type="text"
                            class="mt-1 block w-full"
                            :value="old('nama', $guru->nama ?? '')"
                            required autofocus />
                        @error('nama')
                            <x-input-error :messages="$message" class="mt-2" />
                        @enderror
                    </div>

                    {{-- NIP --}}
                    <div class="mb-6">
                        <x-input-label for="nip" value="NIP" />
                        <x-text-input id="nip" name="nip" type="text"
                            class="mt-1 block w-full"
                            :value="old('nip', $guru->nip ?? '')"
                            required />
                        @error('nip')
                            <x-input-error :messages="$message" class="mt-2" />
                        @enderror
                    </div>

                    {{-- Religion selector --}}
                    <div class="mb-6">
                        <x-input-label for="agama" value="Agama" />
                        <select id="agama" name="agama" required
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm @error('agama') border-red-500 dark:border-red-400 @enderror">
                            <option value="">Pilih agama</option>
                            @php $selectedAgama = old('agama', $guru->agama ?? ''); @endphp
                            @foreach (['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu'] as $agama)
                                <option value="{{ $agama }}" @selected($agama === $selectedAgama)>{{ $agama }}</option>
                            @endforeach
                        </select>
                        @error('agama')
                            <x-input-error :messages="$message" class="mt-2" />
                        @enderror
                    </div>

                    {{-- Gender selector --}}
                    <div class="mb-6">
                        <x-input-label for="kelamin" value="Jenis Kelamin" />
                        <select id="kelamin" name="kelamin" required
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm @error('kelamin') border-red-500 dark:border-red-400 @enderror">
                            <option value="">Pilih jenis kelamin</option>
                            <option value="laki_laki" @selected(old('kelamin', $guru->kelamin->value ?? '') === 'laki_laki')>Laki-laki</option>
                            <option value="perempuan" @selected(old('kelamin', $guru->kelamin->value ?? '') === 'perempuan')>Perempuan</option>
                        </select>
                        @error('kelamin')
                            <x-input-error :messages="$message" class="mt-2" />
                        @enderror
                    </div>

                    {{-- Submit / Cancel --}}
                    <div class="flex items-center gap-3">
                        <x-primary-button>{{ isset($guru) ? 'Update' : 'Simpan' }}</x-primary-button>
                        <a href="{{ route('guru') }}">
                            <x-secondary-button type="button">Batal</x-secondary-button>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>