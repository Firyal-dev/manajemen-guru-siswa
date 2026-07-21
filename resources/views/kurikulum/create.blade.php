{{-- Modal: Create new kurikulum --}}
<x-modal name="buat-kurikulum" focusable>
    <form method="post" action="{{ route('kurikulum.store') }}" class="p-6">
        @csrf

        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Tambah Kurikulum Baru') }}
        </h2>

        {{-- Nama Kurikulum --}}
        <div class="mt-6">
            <x-input-label for="nama" :value="__('Nama Kurikulum')" />
            <x-text-input
                id="nama"
                name="nama"
                type="text"
                placeholder="Contoh: Kurikulum Merdeka"
                class="mt-1 block w-full"
                :value="old('nama')"
                required
            />
            <x-input-error :messages="$errors->get('nama')" class="mt-2" />
        </div>

        {{-- Kode Kurikulum --}}
        <div class="mt-4">
            <x-input-label for="kode" :value="__('Kode Kurikulum (Opsional)')" />
            <x-text-input
                id="kode"
                name="kode"
                type="text"
                placeholder="Contoh: KM"
                class="mt-1 block w-full"
                :value="old('kode')"
            />
            <x-input-error :messages="$errors->get('kode')" class="mt-2" />
        </div>

        {{-- Set as active checkbox --}}
        <div class="mt-4">
            <label class="inline-flex items-center">
                <input type="checkbox" name="status" value="1" {{ old('status', true) ? 'checked' : '' }} class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Set sebagai aktif') }}</span>
            </label>
        </div>

        {{-- Actions --}}
        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Batal') }}
            </x-secondary-button>

            <x-primary-button class="ms-3">
                {{ __('Simpan') }}
            </x-primary-button>
        </div>
    </form>
</x-modal>
