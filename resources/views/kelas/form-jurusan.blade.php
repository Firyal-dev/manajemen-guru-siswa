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

                    {{-- Department name --}}
                    <div class="mb-6">
                        <x-input-label for="nama" value="Nama Jurusan" />
                        <x-text-input id="nama" name="nama" type="text"
                            class="mt-1 block w-full"
                            :value="old('nama')"
                            placeholder="Rekayasa Perangkat Lunak"
                            required autofocus />
                        @error('nama')
                            <x-input-error :messages="$message" class="mt-2" />
                        @enderror
                    </div>

                    {{-- Study length in years --}}
                    <div class="mb-6">
                        <x-input-label for="panjang_tahun_ajaran" value="Lama Masa Studi (Tahun)" />
                        <x-text-input id="panjang_tahun_ajaran" name="panjang_tahun_ajaran" type="number"
                            class="mt-1 block w-full"
                            :value="old('panjang_tahun_ajaran', 3)"
                            min="1" max="6"
                            required />
                        @error('panjang_tahun_ajaran')
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
