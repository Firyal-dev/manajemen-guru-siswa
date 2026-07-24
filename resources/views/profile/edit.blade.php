<x-app-layout>
    <x-slot name="header">
        Profil Saya
    </x-slot>

    <div class="mb-6">
        <h1 class="font-headline text-[28px] font-bold text-on-surface">Profil Saya</h1>
        <p class="text-[14px] text-on-surface-variant mt-1">Kelola informasi akun, kata sandi, dan keamanan Anda.</p>
    </div>

    <div class="max-w-2xl space-y-6">
        {{-- Update profile info form --}}
        <div class="bg-surface rounded-xl border border-outline-variant card-shadow overflow-hidden">
            <div class="p-6">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        {{-- Change password form --}}
        <div class="bg-surface rounded-xl border border-outline-variant card-shadow overflow-hidden">
            <div class="p-6">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        {{-- Delete account section --}}
        <div class="bg-surface rounded-xl border border-outline-variant card-shadow overflow-hidden">
            <div class="p-6">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</x-app-layout>
