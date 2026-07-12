{{-- Modal: Create new academic year --}}
<x-modal name="buat-tahun-ajaran" focusable>
    <form method="post" action="{{ route('tahun-ajaran.store') }}" class="p-6">
        @csrf

        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Buat Tahun Ajaran Baru') }}
        </h2>

        {{-- Start year --}}
        <div class="mt-6">
            <x-input-label for="tahun_mulai" :value="__('Tahun Mulai')" />
            <x-text-input
                id="tahun_mulai"
                name="tahun_mulai"
                type="number"
                min="2000"
                max="2100"
                placeholder="2024"
                class="mt-1 block w-full"
                :value="old('tahun_mulai')"
                required
            />
            <x-input-error :messages="$errors->get('tahun_mulai')" class="mt-2" />
        </div>

        {{-- End year --}}
        <div class="mt-4">
            <x-input-label for="tahun_selesai" :value="__('Tahun Selesai')" />
            <x-text-input
                id="tahun_selesai"
                name="tahun_selesai"
                type="number"
                min="2000"
                max="2100"
                placeholder="2025"
                class="mt-1 block w-full"
                :value="old('tahun_selesai')"
                required
            />
            <x-input-error :messages="$errors->get('tahun_selesai')" class="mt-2" />
        </div>

        {{-- Set as active checkbox --}}
        <div class="mt-4">
            <label class="inline-flex items-center">
                <input type="checkbox" name="aktif" value="1" {{ old('aktif') ? 'checked' : '' }} class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800">
                <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Set sebagai tahun ajaran aktif') }}</span>
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
