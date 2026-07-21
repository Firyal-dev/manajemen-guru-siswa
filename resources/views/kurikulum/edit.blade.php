{{-- Modal: Edit kurikulum --}}
<x-modal name="edit-kurikulum-{{ $k->id }}" focusable>
    <form method="post" action="{{ route('kurikulum.update', $k->id) }}" class="p-6">
        @csrf
        @method('PATCH')

        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Edit Kurikulum') }}
        </h2>

        {{-- Nama Kurikulum --}}
        <div class="mt-6">
            <x-input-label for="nama_{{ $k->id }}" :value="__('Nama Kurikulum')" />
            <x-text-input
                id="nama_{{ $k->id }}"
                name="nama"
                type="text"
                class="mt-1 block w-full"
                :value="old('nama', $k->nama)"
                required
            />
            <x-input-error :messages="$errors->get('nama')" class="mt-2" />
        </div>

        {{-- Kode Kurikulum --}}
        <div class="mt-4">
            <x-input-label for="kode_{{ $k->id }}" :value="__('Kode Kurikulum')" />
            <x-text-input
                id="kode_{{ $k->id }}"
                name="kode"
                type="text"
                class="mt-1 block w-full"
                :value="old('kode', $k->kode)"
            />
            <x-input-error :messages="$errors->get('kode')" class="mt-2" />
        </div>

        {{-- Set as active checkbox --}}
        <div class="mt-4">
            <label class="inline-flex items-center">
                <input type="checkbox" name="status" value="1" {{ old('status', $k->status) ? 'checked' : '' }} class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Status Aktif') }}</span>
            </label>
        </div>

        {{-- Actions --}}
        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Batal') }}
            </x-secondary-button>

            <x-primary-button class="ms-3">
                {{ __('Simpan Perubahan') }}
            </x-primary-button>
        </div>
    </form>
</x-modal>
