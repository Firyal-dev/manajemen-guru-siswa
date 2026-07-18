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

    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Lexend:wght@600;700&display=swap" rel="stylesheet"/>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "surface-variant": "#d8e3fb",
                        "on-secondary-container": "#00714d",
                        "deep-indigo": "#3730A3",
                        "secondary-fixed-dim": "#4edea3",
                        "primary-fixed": "#dde1ff",
                        "error-crimson": "#EF4444",
                        "secondary-fixed": "#6ffbbe",
                        "outline": "#757684",
                        "primary-fixed-dim": "#b8c4ff",
                        "on-background": "#111c2d",
                        "surface-gray": "#F9FAFB",
                        "on-primary-fixed-variant": "#173bab",
                        "inverse-on-surface": "#ecf1ff",
                        "on-primary-container": "#a8b8ff",
                        "on-error": "#ffffff",
                        "error": "#ba1a1a",
                        "on-secondary-fixed-variant": "#005236",
                        "inverse-surface": "#263143",
                        "tertiary-fixed-dim": "#ffb95f",
                        "secondary-container": "#6cf8bb",
                        "on-surface": "#111c2d",
                        "background": "#f9f9ff",
                        "on-primary": "#ffffff",
                        "outline-variant": "#c4c5d5",
                        "on-tertiary-container": "#ffa929",
                        "primary": "#00288e",
                        "surface-container-lowest": "#ffffff",
                        "on-tertiary": "#ffffff",
                        "on-tertiary-fixed": "#2a1700",
                        "surface": "#f9f9ff",
                        "primary-container": "#1e40af",
                        "tertiary-container": "#6b4200",
                        "on-surface-variant": "#444653",
                        "inverse-primary": "#b8c4ff",
                        "surface-container-high": "#dee8ff",
                        "tertiary": "#4c2e00",
                        "tertiary-fixed": "#ffddb8",
                        "on-secondary": "#ffffff",
                        "surface-dim": "#cfdaf2",
                        "secondary": "#006c49",
                        "error-container": "#ffdad6",
                        "on-error-container": "#93000a",
                        "surface-tint": "#3755c3",
                        "surface-container-low": "#f0f3ff",
                        "on-tertiary-fixed-variant": "#653e00",
                        "on-primary-fixed": "#001453",
                        "surface-container-highest": "#d8e3fb",
                        "on-secondary-fixed": "#002113",
                        "surface-container": "#e7eeff",
                        "surface-bright": "#f9f9ff",
                        "accent-purple": "#B348C7"
                    },
                    borderRadius: {
                        "DEFAULT": "0.5rem",
                        "sm": "0.25rem",
                        "lg": "0.75rem",
                        "xl": "1rem",
                        "2xl": "1.5rem",
                        "full": "9999px"
                    },
                    spacing: {
                        "container-max": "1280px",
                        "base": "8px",
                        "margin-desktop": "48px",
                        "gutter": "24px",
                        "margin-mobile": "16px"
                    },
                    fontFamily: {
                        "display": ["Lexend", "sans-serif"],
                        "headline": ["Lexend", "sans-serif"],
                        "body": ["Inter", "sans-serif"],
                        "label": ["Inter", "sans-serif"],
                    }
                }
            }
        };
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
        }
        .card-shadow { box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05), 0 2px 4px -1px rgba(0,0,0,0.03); }
        .nav-active {
            background-color: #dbeafe;
            color: #0f172a !important;
            font-weight: 700;
        }
        .nav-active *,
        .nav-active {
            color: #0f172a !important;
        }
        .nav-active:hover,
        .nav-active:focus {
            background-color: #c7d2fe;
            color: #0f172a !important;
        }
        .nav-active .material-symbols-outlined {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            color: #1d4ed8 !important;
        }
        .nav-active:hover .material-symbols-outlined,
        .nav-active:focus .material-symbols-outlined {
            color: #1e40af !important;
        }
        /* Scrollbar styling */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f0f3ff; }
        ::-webkit-scrollbar-thumb { background: #c4c5d5; border-radius: 999px; }
        ::-webkit-scrollbar-thumb:hover { background: #757684; }
        /* Sidebar transition */
        #sidebar { transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        @media (max-width: 768px) {
            #sidebar { transform: translateX(-100%); }
            #sidebar.open { transform: translateX(0); }
        }
        main { animation: fadeIn 0.2s ease; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(4px); } to { opacity: 1; transform: translateY(0); } }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-surface-gray text-on-surface min-h-screen">

<div id="mobileOverlay" class="fixed inset-0 bg-black/40 z-30 hidden md:hidden" onclick="closeSidebar()"></div>

<aside id="sidebar" class="fixed left-0 top-0 h-full w-72 flex flex-col z-40 bg-surface border-r border-outline-variant md:translate-x-0">
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
        <a href="{{ route('dashboard') }}" class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-150 text-on-surface-variant hover:text-primary hover:bg-surface-container-high {{ request()->routeIs('dashboard') ? 'nav-active' : '' }}">
            <span class="material-symbols-outlined text-[22px]">dashboard</span>
            <span class="text-[14px] font-semibold">Dashboard</span>
        </a>
        <a href="{{ route('tahun-ajaran.index') }}" class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-150 text-on-surface-variant hover:text-primary hover:bg-surface-container-high {{ request()->routeIs('tahun-ajaran.*') ? 'nav-active' : '' }}">
            <span class="material-symbols-outlined text-[22px]">calendar_month</span>
            <span class="text-[14px] font-semibold">Tahun Ajaran</span>
        </a>
        
        <div class="px-3 py-1.5 mt-4">
            <span class="text-[10px] font-bold text-outline uppercase tracking-widest">Master Users</span>
        </div>
        <a href="{{ route('guru') }}" class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-150 text-on-surface-variant hover:text-primary hover:bg-surface-container-high {{ request()->routeIs('guru') ? 'nav-active' : '' }}">
            <span class="material-symbols-outlined text-[22px]">manage_accounts</span>
            <span class="text-[14px] font-semibold">Data Guru</span>
        </a>
        <a href="{{ route('siswa') }}" class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-150 text-on-surface-variant hover:text-primary hover:bg-surface-container-high {{ request()->routeIs('siswa') ? 'nav-active' : '' }}">
            <span class="material-symbols-outlined text-[22px]">groups</span>
            <span class="text-[14px] font-semibold">Data Siswa</span>
        </a>
        <a href="{{ route('mapel.index') }}" class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-150 text-on-surface-variant hover:text-primary hover:bg-surface-container-high {{ request()->routeIs('mapel.*') ? 'nav-active' : '' }}">
            <span class="material-symbols-outlined text-[22px]">menu_book</span>
            <span class="text-[14px] font-semibold">Data Mapel</span>
        </a>
        
        <div class="px-3 py-1.5 mt-4">
            <span class="text-[10px] font-bold text-outline uppercase tracking-widest">Akademik</span>
        </div>
        <a href="{{ route('kelas') }}" class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-150 text-on-surface-variant hover:text-primary hover:bg-surface-container-high {{ request()->routeIs('kelas') ? 'nav-active' : '' }}">
            <span class="material-symbols-outlined text-[22px]">meeting_room</span>
            <span class="text-[14px] font-semibold">Manajemen Kelas</span>
        </a>
        
        <div class="px-3 py-1.5 mt-4">
            <span class="text-[10px] font-bold text-outline uppercase tracking-widest">Penugasan</span>
        </div>
        <a href="{{ route('penugasan.wali-kelas') }}" class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-150 text-on-surface-variant hover:text-primary hover:bg-surface-container-high {{ request()->routeIs('penugasan.wali-kelas') ? 'nav-active' : '' }}">
            <span class="material-symbols-outlined text-[22px]">supervisor_account</span>
            <span class="text-[14px] font-semibold">Wali Kelas</span>
        </a>
        <a href="{{ route('penugasan.guru-mapel') }}" class="nav-item flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-150 text-on-surface-variant hover:text-primary hover:bg-surface-container-high {{ request()->routeIs('penugasan.guru-mapel') ? 'nav-active' : '' }}">
            <span class="material-symbols-outlined text-[22px]">assignment_ind</span>
            <span class="text-[14px] font-semibold">Guru Mapel</span>
        </a>
    </nav>

    <div class="p-4 border-t border-outline-variant">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-full bg-primary text-white flex items-center justify-center font-bold text-sm flex-shrink-0">
                {{ strtoupper(substr($currentUser, 0, 2)) }}
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-[13px] font-semibold text-on-surface truncate">{{ $currentUser }}</p>
                <p class="text-[11px] text-on-surface-variant capitalize">Administrator</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="p-1.5 text-on-surface-variant hover:text-error-crimson hover:bg-error-container/20 rounded-lg transition-colors" title="Logout">
                    <span class="material-symbols-outlined text-[20px]">logout</span>
                </button>
            </form>
        </div>
    </div>
</aside>

<header class="fixed top-0 right-0 left-0 md:left-72 h-16 flex items-center justify-between px-4 md:px-gutter z-20 bg-surface border-b border-outline-variant card-shadow">
    <div class="flex items-center gap-3">
        <button onclick="toggleSidebar()" class="md:hidden p-2 text-on-surface-variant hover:bg-surface-container-low rounded-lg transition-colors">
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
        <a href="{{ route('profile.edit') }}" class="p-2 text-on-surface-variant hover:bg-surface-container-low rounded-full transition-all flex items-center justify-center">
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

<x-toast />

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
</script>
@stack('scripts')
</body>
</html>
