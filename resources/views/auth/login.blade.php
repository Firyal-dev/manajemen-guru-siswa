<x-guest-layout>
    {{-- Left Side: Branding / Illustration --}}
    <div class="hidden md:flex flex-col justify-center items-center w-1/2 bg-gradient-to-br from-primary to-primary-container p-12 text-white relative overflow-hidden">
        {{-- Inner Decorative pattern --}}
        <div class="absolute inset-0 opacity-10 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCI+CiAgPGNpcmNsZSBjeD0iMiIgY3k9IjIiIHI9IjIiIGZpbGw9IiNmZmYiLz4KPC9zdmc+')] bg-repeat z-0"></div>
        
        <div class="relative z-10 w-full max-w-sm flex flex-col items-center text-center">
            <div class="w-24 h-24 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center mb-8 border border-white/30 shadow-lg">
                <img src="{{ asset('aknb.png') }}" alt="Logo" class="w-16 h-16 object-contain">
            </div>
            
            <h1 class="font-headline text-3xl font-bold mb-4 leading-tight">Sistem Manajemen<br>Guru & Siswa</h1>
            <p class="text-white/80 font-medium text-[15px] mb-8">SMK AK Nusa Bangsa</p>
            
            <div class="bg-white/10 backdrop-blur-sm border border-white/20 rounded-xl p-4 w-full">
                <div class="flex items-center gap-3 text-left">
                    <span class="material-symbols-outlined text-secondary-fixed">school</span>
                    <p class="text-[13px] text-white/90">Kelola data akademik, absensi, dan penugasan secara terpusat.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Right Side: Login Form --}}
    <div class="w-full md:w-1/2 p-8 sm:p-12 flex flex-col justify-center bg-surface relative z-10">
        
        {{-- Mobile Header (Hidden on Desktop) --}}
        <div class="md:hidden flex flex-col items-center text-center mb-8">
            <img src="{{ asset('aknb.png') }}" alt="Logo" class="w-16 h-16 object-contain mb-4">
            <h1 class="font-headline text-2xl font-bold text-on-surface">Masuk ke Akun</h1>
            <p class="text-[14px] text-on-surface-variant mt-1">SMK AK Nusa Bangsa</p>
        </div>

        <div class="hidden md:block mb-8">
            <h2 class="font-headline text-2xl font-bold text-on-surface">Selamat Datang 👋</h2>
            <p class="text-[14px] text-on-surface-variant mt-2">Silakan masuk menggunakan email dan kata sandi Anda.</p>
        </div>

        {{-- Session status messages --}}
        @if (session('status'))
            <div class="mb-6 p-4 bg-green-50 text-secondary rounded-xl border border-green-200 flex items-center gap-3">
                <span class="material-symbols-outlined text-[20px]">check_circle</span>
                <p class="text-[13px] font-bold">{{ session('status') }}</p>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            {{-- Email field --}}
            <div>
                <label for="email" class="block text-[13px] font-bold text-on-surface mb-2">Email Akun</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">mail</span>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                        class="w-full bg-surface-container-lowest border border-outline-variant text-on-surface text-[14px] rounded-xl pl-10 pr-4 py-3 focus:ring-1 focus:ring-primary focus:border-primary transition-all placeholder:text-on-surface-variant/50" 
                        placeholder="admin@sekolah.com">
                </div>
                @error('email')
                    <p class="mt-2 text-[12px] text-error font-medium">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password field --}}
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label for="password" class="block text-[13px] font-bold text-on-surface">Kata Sandi</label>
                </div>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-on-surface-variant">lock</span>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="w-full bg-surface-container-lowest border border-outline-variant text-on-surface text-[14px] rounded-xl pl-10 pr-4 py-3 focus:ring-1 focus:ring-primary focus:border-primary transition-all placeholder:text-on-surface-variant/50"
                        placeholder="••••••••">
                </div>
                @error('password')
                    <p class="mt-2 text-[12px] text-error font-medium">{{ $message }}</p>
                @enderror
            </div>

            {{-- Remember Me --}}
            <div class="flex items-center pt-2">
                <label for="remember_me" class="flex items-center cursor-pointer group">
                    <input id="remember_me" type="checkbox" name="remember" 
                        class="w-4 h-4 text-primary bg-surface-container border-outline-variant rounded focus:ring-primary focus:ring-2 focus:ring-offset-0 transition-colors">
                    <span class="ml-2 text-[13px] font-medium text-on-surface-variant group-hover:text-on-surface transition-colors">Ingat saya</span>
                </label>
            </div>

            {{-- Actions --}}
            <div class="pt-4">
                <button type="submit" class="w-full py-3.5 bg-primary text-white text-[14px] font-bold rounded-xl hover:bg-primary/90 transition-all flex items-center justify-center gap-2 shadow-lg shadow-primary/20">
                    Masuk ke Sistem
                    <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                </button>
            </div>
            
            <p class="text-center text-[12px] text-on-surface-variant pt-6">
                &copy; {{ date('Y') }} SMK AK Nusa Bangsa. All rights reserved.
            </p>
        </form>
    </div>
</x-guest-layout>
