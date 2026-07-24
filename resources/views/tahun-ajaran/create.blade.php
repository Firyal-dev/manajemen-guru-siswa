{{-- Modal: Create new academic year --}}
<x-modal name="buat-tahun-ajaran" focusable>
    <form method="post" action="{{ route('tahun-ajaran.store') }}" class="p-6">
        @csrf

        <h2 class="font-bold text-[16px] text-on-surface flex items-center gap-2">
            <span class="material-symbols-outlined text-primary">calendar_month</span>
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
            <label class="inline-flex items-center cursor-pointer">
                <input type="checkbox" name="aktif" value="1" {{ old('aktif') ? 'checked' : '' }} class="rounded border-outline-variant text-primary shadow-sm focus:ring-primary focus:ring-offset-0 w-4 h-4">
                <span class="ms-2 text-[13px] font-medium text-on-surface-variant">{{ __('Set sebagai tahun ajaran aktif') }}</span>
            </label>
        </div>

        {{-- Actions --}}
        <div class="mt-6 pt-4 border-t border-outline-variant flex justify-end gap-3">
            <x-secondary-button x-on:click.prevent="$dispatch('close-modal', 'buat-tahun-ajaran')">
                {{ __('Batal') }}
            </x-secondary-button>

            <x-primary-button>
                {{ __('Simpan') }}
            </x-primary-button>
        </div>
    </form>
</x-modal>
