{{-- Modal: Edit kurikulum --}}
<x-modal name="edit-kurikulum-{{ $k->id }}" focusable>
    <form method="post" action="{{ route('kurikulum.update', $k->id) }}" class="p-6">
        @csrf
        @method('PATCH')

        <h2 class="font-bold text-[16px] text-on-surface flex items-center gap-2">
            <span class="material-symbols-outlined text-primary">edit</span>
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
            <label class="inline-flex items-center cursor-pointer">
                <input type="checkbox" name="status" value="1" {{ old('status', $k->status) ? 'checked' : '' }} class="rounded border-outline-variant text-primary shadow-sm focus:ring-primary focus:ring-offset-0 w-4 h-4">
                <span class="ms-2 text-[13px] font-medium text-on-surface-variant">{{ __('Status Aktif') }}</span>
            </label>
        </div>

        {{-- Actions --}}
        <div class="mt-6 pt-4 border-t border-outline-variant flex justify-end gap-3">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Batal') }}
            </x-secondary-button>

            <x-primary-button>
                {{ __('Simpan Perubahan') }}
            </x-primary-button>
        </div>
    </form>
</x-modal>
