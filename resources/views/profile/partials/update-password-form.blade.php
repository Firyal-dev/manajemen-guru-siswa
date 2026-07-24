{{-- Password update form --}}
<section>
    <header>
        <h2 class="font-bold text-[16px] text-on-surface flex items-center gap-2">
            <span class="material-symbols-outlined text-primary">lock</span>
            {{ __('Ubah Kata Sandi') }}
        </h2>

        <p class="mt-1 text-[13px] text-on-surface-variant">
            {{ __('Gunakan kata sandi yang panjang dan sulit ditebak agar akun tetap aman.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        {{-- Current password --}}
        <div>
            <x-input-label for="update_password_current_password" :value="__('Kata Sandi Saat Ini')" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        {{-- New password --}}
        <div>
            <x-input-label for="update_password_password" :value="__('Kata Sandi Baru')" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        {{-- Confirm new password --}}
        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Konfirmasi Kata Sandi Baru')" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        {{-- Actions --}}
        <div class="pt-4 border-t border-outline-variant flex items-center gap-4">
            <x-primary-button>{{ __('Simpan') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-[13px] font-semibold text-secondary flex items-center gap-1"
                ><span class="material-symbols-outlined text-[16px]">check_circle</span>{{ __('Tersimpan.') }}</p>
            @endif
        </div>
    </form>
</section>
