<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
@php
    $currentUser = auth()->user()->name ?? 'Admin';
@endphp

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SMNS') }}</title>

    {{-- App favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('aknb.png') }}">

    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Lexend:wght@600;700&display=swap"
        rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Native cross-document View Transitions (MPA) — smooth fade/slide between full page loads */
        @view-transition {
            navigation: auto;
        }
        ::view-transition-old(root) {
            animation: 150ms cubic-bezier(0.4, 0, 0.2, 1) both smns-fade-out;
        }
        ::view-transition-new(root) {
            animation: 200ms cubic-bezier(0.4, 0, 0.2, 1) both smns-fade-in;
        }
        @keyframes smns-fade-out {
            to { opacity: 0; transform: translateY(-4px); }
        }
        @keyframes smns-fade-in {
            from { opacity: 0; transform: translateY(4px); }
        }
        @media (prefers-reduced-motion: reduce) {
            ::view-transition-old(root),
            ::view-transition-new(root) { animation: none !important; }
        }

        body {
            font-family: 'Inter', sans-serif;
        }


        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }

        .card-shadow {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
        }

        .nav-item {
            border-left: 3px solid transparent;
        }

        .nav-active {
            background-color: rgba(0, 40, 142, 0.06);
            color: #00288e !important;
            font-weight: 700;
            border-left-color: #00288e;
        }

        .nav-active *,
        .nav-active {
            color: #00288e !important;
        }

        .nav-active:hover,
        .nav-active:focus {
            background-color: rgba(0, 40, 142, 0.1);
            color: #00288e !important;
        }

        .nav-active .material-symbols-outlined {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            color: #00288e !important;
        }

        /* Scrollbar styling */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f0f3ff;
        }

        ::-webkit-scrollbar-thumb {
            background: #c4c5d5;
            border-radius: 999px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #757684;
        }

        /* Sidebar transition */
        #sidebar {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @media (max-width: 768px) {
            #sidebar {
                transform: translateX(-100%);
            }

            #sidebar.open {
                transform: translateX(0);
            }
        }

        main {
            animation: fadeIn 0.2s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(4px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes modalSlideIn {
            from {
                opacity: 0;
                transform: translateY(16px) scale(0.97);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }
    </style>
    @stack('styles')
</head>

<body class="bg-surface-gray text-on-surface min-h-screen">

    <div id="mobileOverlay" class="fixed inset-0 bg-black/40 z-30 hidden md:hidden" onclick="closeSidebar()"></div>

    <aside id="sidebar"
        class="fixed left-0 top-0 h-full w-72 flex flex-col z-40 bg-surface border-r border-outline-variant md:translate-x-0">
        <div class="p-5 border-b border-outline-variant flex items-center gap-3">
            <div class="w-12 h-12 rounded-2xl overflow-hidden bg-white/90 flex items-center justify-center shadow-sm">
                <img src="{{ asset('aknb.png') }}" alt="Logo Master Data" class="h-10 w-10 object-contain" />
            </div>
            <div>
                <h1 class="font-display text-[18px] font-bold text-primary leading-tight">Master Data</h1>
                <p class="text-[11px] text-on-surface-variant font-medium">SMK AK Nusa Bangsa</p>
            </div>
        </div>

        <nav class="flex-1 overflow-y-auto py-4 px-3 space-y-1">
            <div class="px-3 py-1.5">
                <span class="text-[10px] font-bold text-outline uppercase tracking-widest">Menu Utama</span>
            </div>
            <a href="{{ route('dashboard') }}"
                class="nav-item flex items-center gap-3 px-3 py-2.5 -ml-[3px] pl-[15px] rounded-lg transition-colors duration-150 text-on-surface-variant hover:text-primary hover:bg-surface-container-high {{ request()->routeIs('dashboard') ? 'nav-active' : '' }}">
                <span class="material-symbols-outlined text-[20px]">dashboard</span>
                <span class="text-[13px] font-semibold">Dashboard</span>
            </a>
            <a href="{{ route('tahun-ajaran.index') }}"
                class="nav-item flex items-center gap-3 px-3 py-2.5 -ml-[3px] pl-[15px] rounded-lg transition-colors duration-150 text-on-surface-variant hover:text-primary hover:bg-surface-container-high {{ request()->routeIs('tahun-ajaran.*') ? 'nav-active' : '' }}">
                <span class="material-symbols-outlined text-[20px]">calendar_month</span>
                <span class="text-[13px] font-semibold">Tahun Ajaran</span>
            </a>

            <div class="px-3 py-1.5 mt-4">
                <span class="text-[10px] font-bold text-outline uppercase tracking-widest">Master Users</span>
            </div>
            <a href="{{ route('guru') }}"
                class="nav-item flex items-center gap-3 px-3 py-2.5 -ml-[3px] pl-[15px] rounded-lg transition-colors duration-150 text-on-surface-variant hover:text-primary hover:bg-surface-container-high {{ request()->routeIs('guru') ? 'nav-active' : '' }}">
                <span class="material-symbols-outlined text-[20px]">manage_accounts</span>
                <span class="text-[13px] font-semibold">Data Guru</span>
            </a>
            <a href="{{ route('siswa') }}"
                class="nav-item flex items-center gap-3 px-3 py-2.5 -ml-[3px] pl-[15px] rounded-lg transition-colors duration-150 text-on-surface-variant hover:text-primary hover:bg-surface-container-high {{ request()->routeIs('siswa') ? 'nav-active' : '' }}">
                <span class="material-symbols-outlined text-[20px]">groups</span>
                <span class="text-[13px] font-semibold">Data Siswa</span>
            </a>
            <a href="{{ route('mapel.index') }}"
                class="nav-item flex items-center gap-3 px-3 py-2.5 -ml-[3px] pl-[15px] rounded-lg transition-colors duration-150 text-on-surface-variant hover:text-primary hover:bg-surface-container-high {{ request()->routeIs('mapel.*') ? 'nav-active' : '' }}">
                <span class="material-symbols-outlined text-[20px]">menu_book</span>
                <span class="text-[13px] font-semibold">Data Mapel</span>
            </a>

            <div class="px-3 py-1.5 mt-4">
                <span class="text-[10px] font-bold text-outline uppercase tracking-widest">Akademik</span>
            </div>
            <a href="{{ route('kelas') }}"
                class="nav-item flex items-center gap-3 px-3 py-2.5 -ml-[3px] pl-[15px] rounded-lg transition-colors duration-150 text-on-surface-variant hover:text-primary hover:bg-surface-container-high {{ request()->routeIs('kelas') ? 'nav-active' : '' }}">
                <span class="material-symbols-outlined text-[20px]">meeting_room</span>
                <span class="text-[13px] font-semibold">Manajemen Kelas</span>
            </a>
            <a href="{{ route('jurusan.index') }}"
                class="nav-item flex items-center gap-3 px-3 py-2.5 -ml-[3px] pl-[15px] rounded-lg transition-colors duration-150 text-on-surface-variant hover:text-primary hover:bg-surface-container-high {{ request()->routeIs('jurusan.*') ? 'nav-active' : '' }}">
                <span class="material-symbols-outlined text-[20px]">school</span>
                <span class="text-[13px] font-semibold">Manajemen Jurusan</span>
            </a>

            <div class="px-3 py-1.5 mt-4">
                <span class="text-[10px] font-bold text-outline uppercase tracking-widest">Penugasan</span>
            </div>
            <a href="{{ route('penugasan.wali-kelas') }}"
                class="nav-item flex items-center gap-3 px-3 py-2.5 -ml-[3px] pl-[15px] rounded-lg transition-colors duration-150 text-on-surface-variant hover:text-primary hover:bg-surface-container-high {{ request()->routeIs('penugasan.wali-kelas') ? 'nav-active' : '' }}">
                <span class="material-symbols-outlined text-[20px]">supervisor_account</span>
                <span class="text-[13px] font-semibold">Wali Kelas</span>
            </a>
            <a href="{{ route('penugasan.guru-mapel') }}"
                class="nav-item flex items-center gap-3 px-3 py-2.5 -ml-[3px] pl-[15px] rounded-lg transition-colors duration-150 text-on-surface-variant hover:text-primary hover:bg-surface-container-high {{ request()->routeIs('penugasan.guru-mapel') ? 'nav-active' : '' }}">
                <span class="material-symbols-outlined text-[20px]">assignment_ind</span>
                <span class="text-[13px] font-semibold">Guru Mapel</span>
            </a>
        </nav>

        <div class="p-4 border-t border-outline-variant">
            <div class="flex items-center gap-3">
                <div
                    class="w-9 h-9 rounded-full bg-primary text-white flex items-center justify-center font-bold text-sm flex-shrink-0">
                    {{ strtoupper(substr($currentUser, 0, 2)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-[13px] font-semibold text-on-surface truncate">{{ $currentUser }}</p>
                    <p class="text-[11px] text-on-surface-variant capitalize">Administrator</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="p-1.5 text-on-surface-variant hover:text-error-crimson hover:bg-error-container/20 rounded-lg transition-colors cursor-pointer"
                        title="Logout">
                        <span class="material-symbols-outlined text-[20px]">logout</span>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <header
        class="fixed top-0 right-0 left-0 md:left-72 h-16 flex items-center justify-between px-4 md:px-gutter z-20 bg-surface border-b border-outline-variant card-shadow">
        <div class="flex items-center gap-3">
            <button onclick="toggleSidebar()"
                class="md:hidden p-2 text-on-surface-variant hover:bg-surface-container-low rounded-lg transition-colors cursor-pointer">
                <span class="material-symbols-outlined">menu</span>
            </button>
            <div class="hidden md:flex items-center gap-2 text-on-surface-variant">
                @isset($header)
                    <span class="text-[14px] text-primary font-bold border-b-2 border-primary pb-0.5">{{ $header }}</span>
                @endisset
            </div>
            <span class="md:hidden font-headline text-[18px] font-bold text-primary">Master Data</span>
        </div>

        <div class="flex items-center gap-2 md:gap-4">
            <a href="{{ route('profile.edit') }}"
                class="p-2 text-on-surface-variant hover:bg-surface-container-low rounded-full transition-all flex items-center justify-center">
                <span class="material-symbols-outlined">person</span>
            </a>

            <div class="hidden md:flex flex-col items-end">
                <span class="text-[13px] font-semibold text-on-surface">{{ $currentUser }}</span>
                <span class="text-[11px] text-on-surface-variant">Admin App</span>
            </div>
            <div class="w-8 h-8 rounded-full bg-primary text-white flex items-center justify-center font-bold text-xs">
                {{ strtoupper(substr($currentUser, 0, 2)) }}
            </div>
        </div>
    </header>

    <main class="md:ml-72 pt-16 min-h-screen">
        <div class="p-4 md:p-6 lg:p-8">
            {{ $slot }}
        </div>
    </main>

    {{-- Create academic year modal --}}
    @include('tahun-ajaran.create')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobileOverlay');
            sidebar.classList.toggle('open');
            overlay.classList.toggle('hidden');
        }
        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('mobileOverlay');
            sidebar.classList.remove('open');
            overlay.classList.add('hidden');
        }

        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('#sidebar a').forEach(function (link) {
                link.addEventListener('click', closeSidebar);
            });
        });

        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        @if (session('success'))
            Toast.fire({
                icon: 'success',
                title: "{!! session('success') !!}"
            });
        @endif

        @if (session('error'))
            Toast.fire({
                icon: 'error',
                title: "{!! session('error') !!}"
            });
        @endif

        window.confirmDelete = function(formId, itemName = 'data ini', requireReason = false) {
            let swalOptions = {
                title: 'Konfirmasi Hapus',
                html: `Apakah Anda yakin ingin menghapus <b>${itemName}</b>? Tindakan ini tidak dapat dibatalkan.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#757684',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                reverseButtons: true
            };

            if (requireReason) {
                swalOptions.input = 'textarea';
                swalOptions.inputLabel = 'Alasan penghapusan *';
                swalOptions.inputPlaceholder = 'Contoh: Pindah sekolah, dll.';
                swalOptions.inputAttributes = {
                    'aria-label': 'Alasan penghapusan'
                };
                swalOptions.inputValidator = (value) => {
                    if (!value) {
                        return 'Alasan penghapusan wajib diisi!'
                    }
                };
            }

            Swal.fire(swalOptions).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById(formId);
                    if (requireReason && result.value) {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'alasan_hapus';
                        input.value = result.value;
                        form.appendChild(input);
                    }
                    form.submit();
                }
            });
        }

        window.confirmAction = function (formId, title, text, icon = 'warning', confirmBtnText = 'Ya, Lanjutkan') {
            Swal.fire({
                title: title,
                html: text,
                icon: icon,
                showCancelButton: true,
                confirmButtonColor: '#00288e',
                cancelButtonColor: '#757684',
                confirmButtonText: confirmBtnText,
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        }
    </script>
    @stack('scripts')
</body>

</html>
