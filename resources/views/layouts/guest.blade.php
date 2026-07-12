<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        {{-- App favicon --}}
        <link rel="icon" type="image/png" href="{{ asset('aknb.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Vite assets -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
            {{-- Guest layout slot for auth forms, logo now inside the card --}}
            <div class="w-full sm:max-w-md mt-6 px-6 py-6 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                {{-- App logo inside the card --}}
                <div class="flex flex-col items-center mb-6">
                    <a href="/">
                        <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                    </a>
                    <h2 class="mt-3 text-center text-gray-700 dark:text-gray-300 font-medium text-base">
                        SMK AK Nusa Bangsa
                    </h2>
                    <h2 class="mt-3 text-center text-gray-700 dark:text-gray-300 font-medium text-base">
                        Selamat Datang di Aplikasi Management 👋
                    </h2>
                </div>

                {{ $slot }}
            </div>
        </div>
    </body>
</html>
