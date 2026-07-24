{{-- Profile information update form --}}
<section>
    <header>
        <h2 class="font-bold text-[16px] text-on-surface flex items-center gap-2">
            <span class="material-symbols-outlined text-primary">badge</span>
            {{ __('Informasi Akun') }}
        </h2>

        <p class="mt-1 text-[13px] text-on-surface-variant">
            {{ __("Perbarui nama dan alamat email akun Anda.") }}
        </p>
    </header>

    {{-- Hidden form for email verification resend --}}
    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

        {{-- Name --}}
        <div>
            <x-input-label for="name" :value="__('Nama')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        {{-- Email --}}
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            {{-- Email verification notice --}}
            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-[13px] mt-2 text-on-surface-variant">
                        {{ __('Alamat email Anda belum diverifikasi.') }}

                        <button form="send-verification" class="underline font-semibold text-primary hover:text-primary/80 rounded focus:outline-none focus:ring-1 focus:ring-primary focus:ring-offset-2">
                            {{ __('Klik di sini untuk mengirim ulang email verifikasi.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-bold text-[13px] text-secondary">
                            {{ __('Email verifikasi baru sudah dikirim ke alamat email Anda.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        {{-- Actions --}}
        <div class="pt-4 border-t border-outline-variant flex items-center gap-4">
            <x-primary-button>{{ __('Simpan') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
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
