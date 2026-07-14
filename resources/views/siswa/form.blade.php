<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ isset($siswa) ? 'Edit Siswa' : 'Tambah Siswa' }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                {{-- Student form — used for both create and edit --}}
                <form method="POST" action="{{ isset($siswa) ? route('siswa.update', $siswa) : route('siswa.store') }}"
                    class="p-6">
                    @csrf
                    @isset($siswa)
                        @method('PATCH')
                    @endisset

                    {{-- Nama Lengkap --}}
                    <div class="mb-6">
                        <x-input-label for="nama" value="Nama Lengkap" />
                        <x-text-input id="nama" name="nama" type="text"
                            class="mt-1 block w-full"
                            :value="old('nama', $siswa->nama ?? '')"
                            required autofocus />
                        @error('nama')
                            <x-input-error :messages="$message" class="mt-2" />
                        @enderror
                    </div>

                    {{-- NIS --}}
                    <div class="mb-6">
                        <x-input-label for="nis" value="NIS (Nomor Induk Siswa)" />
                        <x-text-input id="nis" name="nis" type="text"
                            class="mt-1 block w-full"
                            :value="old('nis', $siswa->nis ?? '')"
                            required />
                        @error('nis')
                            <x-input-error :messages="$message" class="mt-2" />
                        @enderror
                    </div>

                    {{-- NISN --}}
                    <div class="mb-6">
                        <x-input-label for="nisn" value="NISN (Nomor Induk Siswa Nasional)" />
                        <x-text-input id="nisn" name="nisn" type="text"
                            class="mt-1 block w-full"
                            :value="old('nisn', $siswa->nisn ?? '')"
                            required />
                        @error('nisn')
                            <x-input-error :messages="$message" class="mt-2" />
                        @enderror
                    </div>

                    {{-- Religion selector --}}
                    <div class="mb-6">
                        <x-input-label for="agama" value="Agama" />
                        <select id="agama" name="agama" required
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm @error('agama') border-red-500 dark:border-red-400 @enderror">
                            <option value="">Pilih agama</option>
                            @php $selectedAgama = old('agama', $siswa->agama ?? ''); @endphp
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
                            <option value="laki_laki" @selected(old('kelamin', $siswa->kelamin?->value ?? '') === 'laki_laki')>Laki-laki</option>
                            <option value="perempuan" @selected(old('kelamin', $siswa->kelamin?->value ?? '') === 'perempuan')>Perempuan</option>
                        </select>
                        @error('kelamin')
                            <x-input-error :messages="$message" class="mt-2" />
                        @enderror
                    </div>

                    {{-- Rombel / Class selector --}}
                    <div class="mb-6">
                        <x-input-label for="rombel_id" value="Kelas / Rombel" />
                        <select id="rombel_id" name="rombel_id"
                            class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm @error('rombel_id') border-red-500 dark:border-red-400 @enderror">
                            <option value="">-- Pilih kelas (opsional) --</option>
                            @foreach ($rombels as $rombel)
                                <option value="{{ $rombel->id }}"
                                    @selected(old('rombel_id', $siswa->rombel_id ?? '') == $rombel->id)>
                                    {{ $rombel->tingkat }} {{ $rombel->kelas?->nama_kelas ?? '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('rombel_id')
                            <x-input-error :messages="$message" class="mt-2" />
                        @enderror
                    </div>

                    {{-- Submit / Cancel --}}
                    <div class="flex items-center gap-3">
                        <x-primary-button>{{ isset($siswa) ? 'Update' : 'Simpan' }}</x-primary-button>
                        <a href="{{ route('siswa') }}">
                            <x-secondary-button type="button">Batal</x-secondary-button>
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
