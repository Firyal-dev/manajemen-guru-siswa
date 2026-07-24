{{-- Main navigation with desktop + responsive mobile menus (Material Design 3 style) --}}
<nav x-data="{ open: false }" class="bg-surface border-b border-outline-variant card-shadow relative z-30">
    {{-- Primary Navigation Menu --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                {{-- Logo --}}
                <div class="shrink-0 flex items-center gap-2">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2">
                        <x-application-logo class="block h-9 w-9 object-contain rounded-lg" />
                        <span class="hidden md:inline font-headline text-[15px] font-bold text-primary leading-tight">Master Data</span>
                    </a>
                </div>

                {{-- Desktop nav links --}}
                <div class="hidden sm:flex sm:items-center sm:ms-8 sm:space-x-1">
                    <a href="{{ route('dashboard') }}"
                        class="inline-flex items-center gap-2 h-16 px-3 border-l-4 text-[13px] font-semibold transition-colors duration-150 {{ request()->routeIs('dashboard') ? 'bg-primary-container/10 text-primary border-l-primary' : 'border-l-transparent text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface' }}">
                        <span class="material-symbols-outlined text-[20px]">dashboard</span>
                        {{ __('Beranda') }}
                    </a>
                    <a href="{{ route('tahun-ajaran.index') }}"
                        class="inline-flex items-center gap-2 h-16 px-3 border-l-4 text-[13px] font-semibold transition-colors duration-150 {{ request()->routeIs('tahun-ajaran.*') ? 'bg-primary-container/10 text-primary border-l-primary' : 'border-l-transparent text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface' }}">
                        <span class="material-symbols-outlined text-[20px]">calendar_month</span>
                        {{ __('Tahun Ajaran') }}
                    </a>
                    <a href="{{ route('kurikulum.index') }}"
                        class="inline-flex items-center gap-2 h-16 px-3 border-l-4 text-[13px] font-semibold transition-colors duration-150 {{ request()->routeIs('kurikulum.*') ? 'bg-primary-container/10 text-primary border-l-primary' : 'border-l-transparent text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface' }}">
                        <span class="material-symbols-outlined text-[20px]">menu_book</span>
                        {{ __('Kurikulum') }}
                    </a>
                    <a href="{{ route('guru') }}"
                        class="inline-flex items-center gap-2 h-16 px-3 border-l-4 text-[13px] font-semibold transition-colors duration-150 {{ request()->routeIs('guru') ? 'bg-primary-container/10 text-primary border-l-primary' : 'border-l-transparent text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface' }}">
                        <span class="material-symbols-outlined text-[20px]">manage_accounts</span>
                        {{ __('Guru') }}
                    </a>
                    <a href="{{ route('siswa') }}"
                        class="inline-flex items-center gap-2 h-16 px-3 border-l-4 text-[13px] font-semibold transition-colors duration-150 {{ request()->routeIs('siswa') ? 'bg-primary-container/10 text-primary border-l-primary' : 'border-l-transparent text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface' }}">
                        <span class="material-symbols-outlined text-[20px]">groups</span>
                        {{ __('Siswa') }}
                    </a>
                    <a href="{{ route('kelas') }}"
                        class="inline-flex items-center gap-2 h-16 px-3 border-l-4 text-[13px] font-semibold transition-colors duration-150 {{ request()->routeIs('kelas') ? 'bg-primary-container/10 text-primary border-l-primary' : 'border-l-transparent text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface' }}">
                        <span class="material-symbols-outlined text-[20px]">meeting_room</span>
                        {{ __('Kelas') }}
                    </a>

                    {{-- Penugasan Dropdown --}}
                    <div class="hidden sm:flex sm:items-center">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center gap-2 h-16 px-3 border-l-4 text-[13px] font-semibold transition-colors duration-150 focus:outline-none {{ request()->routeIs('penugasan.*') ? 'bg-primary-container/10 text-primary border-l-primary' : 'border-l-transparent text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface' }}">
                                    <span class="material-symbols-outlined text-[20px]">assignment_ind</span>
                                    <span>Penugasan</span>
                                    <span class="material-symbols-outlined text-[18px]">expand_more</span>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <div class="bg-surface rounded-xl border border-outline-variant card-shadow overflow-hidden py-1.5 min-w-[200px]">
                                    <a href="{{ route('penugasan.wali-kelas') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-[13px] font-semibold transition-colors {{ request()->routeIs('penugasan.wali-kelas') ? 'bg-primary-container/10 text-primary' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface' }}">
                                        <span class="material-symbols-outlined text-[18px]">supervisor_account</span>
                                        {{ __('Wali Kelas') }}
                                    </a>
                                    <a href="{{ route('penugasan.guru-mapel') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-[13px] font-semibold transition-colors {{ request()->routeIs('penugasan.guru-mapel') ? 'bg-primary-container/10 text-primary' : 'text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface' }}">
                                        <span class="material-symbols-outlined text-[18px]">assignment_ind</span>
                                        {{ __('Guru Mapel') }}
                                    </a>
                                </div>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </div>
            </div>

            {{-- Settings dropdown (desktop) --}}
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center gap-2 px-3 py-2 rounded-full text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface transition-colors focus:outline-none">
                            <div class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center font-bold text-[12px]">
                                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                            </div>
                            <span class="text-[13px] font-semibold text-on-surface">{{ Auth::user()->name }}</span>
                            <span class="material-symbols-outlined text-[18px]">expand_more</span>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="bg-surface rounded-xl border border-outline-variant card-shadow overflow-hidden py-1.5 min-w-[200px]">
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 px-4 py-2.5 text-[13px] font-semibold text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface transition-colors">
                                <span class="material-symbols-outlined text-[18px]">person</span>
                                {{ __('Profil Saya') }}
                            </a>

                            {{-- Logout --}}
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                    this.closest('form').submit();"
                                    class="flex items-center gap-2.5 px-4 py-2.5 text-[13px] font-semibold text-error hover:bg-error-container/20 transition-colors">
                                    <span class="material-symbols-outlined text-[18px]">logout</span>
                                    {{ __('Keluar') }}
                                </a>
                            </form>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            {{-- Hamburger (mobile) --}}
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-lg text-on-surface-variant hover:text-on-surface hover:bg-surface-container-low focus:outline-none transition-colors duration-150">
                    <span class="material-symbols-outlined" x-text="open ? 'close' : 'menu'">menu</span>
                </button>
            </div>
        </div>
    </div>

    {{-- Responsive Navigation Menu (mobile) --}}
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden border-t border-outline-variant bg-surface-container-lowest">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('dashboard') }}"
                class="flex items-center gap-3 pl-4 pr-4 py-2.5 border-l-4 text-[14px] font-semibold transition-colors duration-150 {{ request()->routeIs('dashboard') ? 'bg-primary-container/10 text-primary border-l-primary' : 'border-l-transparent text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface' }}">
                <span class="material-symbols-outlined text-[20px]">dashboard</span>
                {{ __('Beranda') }}
            </a>
            <a href="{{ route('tahun-ajaran.index') }}"
                class="flex items-center gap-3 pl-4 pr-4 py-2.5 border-l-4 text-[14px] font-semibold transition-colors duration-150 {{ request()->routeIs('tahun-ajaran.*') ? 'bg-primary-container/10 text-primary border-l-primary' : 'border-l-transparent text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface' }}">
                <span class="material-symbols-outlined text-[20px]">calendar_month</span>
                {{ __('Tahun Ajaran') }}
            </a>
            <a href="{{ route('kurikulum.index') }}"
                class="flex items-center gap-3 pl-4 pr-4 py-2.5 border-l-4 text-[14px] font-semibold transition-colors duration-150 {{ request()->routeIs('kurikulum.*') ? 'bg-primary-container/10 text-primary border-l-primary' : 'border-l-transparent text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface' }}">
                <span class="material-symbols-outlined text-[20px]">menu_book</span>
                {{ __('Kurikulum') }}
            </a>
            <a href="{{ route('guru') }}"
                class="flex items-center gap-3 pl-4 pr-4 py-2.5 border-l-4 text-[14px] font-semibold transition-colors duration-150 {{ request()->routeIs('guru') ? 'bg-primary-container/10 text-primary border-l-primary' : 'border-l-transparent text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface' }}">
                <span class="material-symbols-outlined text-[20px]">manage_accounts</span>
                {{ __('Guru') }}
            </a>
            <a href="{{ route('siswa') }}"
                class="flex items-center gap-3 pl-4 pr-4 py-2.5 border-l-4 text-[14px] font-semibold transition-colors duration-150 {{ request()->routeIs('siswa') ? 'bg-primary-container/10 text-primary border-l-primary' : 'border-l-transparent text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface' }}">
                <span class="material-symbols-outlined text-[20px]">groups</span>
                {{ __('Siswa') }}
            </a>
            <a href="{{ route('kelas') }}"
                class="flex items-center gap-3 pl-4 pr-4 py-2.5 border-l-4 text-[14px] font-semibold transition-colors duration-150 {{ request()->routeIs('kelas') ? 'bg-primary-container/10 text-primary border-l-primary' : 'border-l-transparent text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface' }}">
                <span class="material-symbols-outlined text-[20px]">meeting_room</span>
                {{ __('Kelas') }}
            </a>

            {{-- Responsive Penugasan --}}
            <div class="pt-3 pb-1 border-t border-outline-variant mt-2">
                <div class="px-4 pb-2 text-[11px] font-bold text-outline uppercase tracking-widest">Penugasan</div>
                <div class="space-y-1">
                    <a href="{{ route('penugasan.wali-kelas') }}"
                        class="flex items-center gap-3 pl-4 pr-4 py-2.5 border-l-4 text-[14px] font-semibold transition-colors duration-150 {{ request()->routeIs('penugasan.wali-kelas') ? 'bg-primary-container/10 text-primary border-l-primary' : 'border-l-transparent text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface' }}">
                        <span class="material-symbols-outlined text-[20px]">supervisor_account</span>
                        {{ __('Wali Kelas') }}
                    </a>
                    <a href="{{ route('penugasan.guru-mapel') }}"
                        class="flex items-center gap-3 pl-4 pr-4 py-2.5 border-l-4 text-[14px] font-semibold transition-colors duration-150 {{ request()->routeIs('penugasan.guru-mapel') ? 'bg-primary-container/10 text-primary border-l-primary' : 'border-l-transparent text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface' }}">
                        <span class="material-symbols-outlined text-[20px]">assignment_ind</span>
                        {{ __('Guru Mapel') }}
                    </a>
                </div>
            </div>
        </div>

        {{-- Responsive: user settings --}}
        <div class="pt-3 pb-3 border-t border-outline-variant">
            <div class="px-4 flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-primary text-white flex items-center justify-center font-bold text-[13px] flex-shrink-0">
                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                </div>
                <div class="min-w-0">
                    <p class="font-semibold text-[14px] text-on-surface truncate">{{ Auth::user()->name }}</p>
                    <p class="text-[12px] text-on-surface-variant truncate">{{ Auth::user()->email }}</p>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <a href="{{ route('profile.edit') }}"
                    class="flex items-center gap-3 pl-4 pr-4 py-2.5 border-l-4 border-l-transparent text-[14px] font-semibold text-on-surface-variant hover:bg-surface-container-low hover:text-on-surface transition-colors duration-150">
                    <span class="material-symbols-outlined text-[20px]">person</span>
                    {{ __('Profil Saya') }}
                </a>

                {{-- Logout --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();"
                        class="flex items-center gap-3 pl-4 pr-4 py-2.5 border-l-4 border-l-transparent text-[14px] font-semibold text-error hover:bg-error-container/20 transition-colors duration-150">
                        <span class="material-symbols-outlined text-[20px]">logout</span>
                        {{ __('Keluar') }}
                    </a>
                </form>
            </div>
        </div>
    </div>

    {{-- Create academic year modal --}}
    @include('tahun-ajaran.create')
</nav>
