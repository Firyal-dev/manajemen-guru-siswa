<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Tambah Jurusan
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                {{-- Create department form --}}
                <form method="POST" action="{{ route('jurusan.store') }}" class="p-6">
                    @csrf

                    {{-- Abbreviation (e.g. RPL) --}}
                    <div class="mb-6">
                        <x-input-label for="singkatan" value="Singkatan" />
                        <x-text-input id="singkatan" name="singkatan" type="text"
                            class="mt-1 block w-full"
                            :value="old('singkatan')"
                            placeholder="RPL"
                            required autofocus />
                        @error('singkatan')
                            <x-input-error :messages="$message" class="mt-2" />
                        @enderror
                    </div>

                    {{-- Full name (e.g. Rekayasa Perangkat Lunak) --}}
                    <div class="mb-6">
                        <x-input-label for="kepanjangan" value="Kepanjangan" />
                        <x-text-input id="kepanjangan" name="kepanjangan" type="text"
                            class="mt-1 block w-full"
                            :value="old('kepanjangan')"
                            placeholder="Rekayasa Perangkat Lunak"
                            required />
                        @error('kepanjangan')
                            <x-input-error :messages="$message" class="mt-2" />
                        @enderror
                    </div>

                    {{-- Submit / Cancel --}}
                    <div class="flex items-center gap-3">
                        <x-primary-button>Simpan</x-primary-button>
                        <a href="{{ route('kelas') }}">
                            <x-secondary-button type="button">Batal</x-secondary-button>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
