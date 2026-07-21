<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Manajemen Guru Siswa') }} - Login</title>

    {{-- App favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('aknb.png') }}">

    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Lexend:wght@600;700&display=swap" rel="stylesheet"/>

    <!-- Vite assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-body text-on-surface bg-surface-container antialiased selection:bg-primary selection:text-white min-h-screen flex items-center justify-center p-4">
    
    {{-- Decorative Background Elements --}}
    <div class="fixed inset-0 z-0 overflow-hidden pointer-events-none">
        <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-primary/10 rounded-full blur-[100px]"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-secondary/10 rounded-full blur-[100px]"></div>
    </div>

    {{-- Main Content Container --}}
    <div class="relative z-10 w-full max-w-[1000px] flex flex-col md:flex-row bg-surface rounded-2xl shadow-xl overflow-hidden border border-outline-variant/30 min-h-[500px]">
        {{ $slot }}
    </div>

</body>
</html>
