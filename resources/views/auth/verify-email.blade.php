<x-guest-layout>
    {{-- Email verification notice --}}
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Terima kasih sudah mendaftar! Sebelum mulai, silakan verifikasi alamat email Anda dengan mengklik tautan yang baru saja kami kirim. Jika email belum diterima, kami akan mengirimkannya lagi.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
            {{ __('Tautan verifikasi baru sudah dikirim ke alamat email yang Anda gunakan saat mendaftar.') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        {{-- Resend verification --}}
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    {{ __('Kirim Ulang Email Verifikasi') }}
                </x-primary-button>
            </div>
        </form>

        {{-- Logout --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
