<x-guest-layout>
    {{-- Instructions --}}
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Lupa kata sandi? Tidak masalah. Masukkan alamat email Anda, dan kami akan mengirimkan tautan untuk membuat kata sandi baru.') }}
    </div>

    {{-- Session status --}}
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        {{-- Email field --}}
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Kirim Tautan Atur Ulang Kata Sandi') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
