{{-- Modal: Create new kurikulum --}}
<x-modal name="buat-kurikulum" focusable>
    <form method="post" action="{{ route('kurikulum.store') }}" class="p-6">
        @csrf

        <h2 class="font-bold text-[16px] text-on-surface flex items-center gap-2">
            <span class="material-symbols-outlined text-primary">menu_book</span>
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
            <label class="inline-flex items-center cursor-pointer">
                <input type="checkbox" name="status" value="1" {{ old('status', true) ? 'checked' : '' }} class="rounded border-outline-variant text-primary shadow-sm focus:ring-primary focus:ring-offset-0 w-4 h-4">
                <span class="ms-2 text-[13px] font-medium text-on-surface-variant">{{ __('Set sebagai aktif') }}</span>
            </label>
        </div>

        {{-- Actions --}}
        <div class="mt-6 pt-4 border-t border-outline-variant flex justify-end gap-3">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Batal') }}
            </x-secondary-button>

            <x-primary-button>
                {{ __('Simpan') }}
            </x-primary-button>
        </div>
    </form>
</x-modal>
