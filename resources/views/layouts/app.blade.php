<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Demo Application') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC] min-h-screen flex flex-col font-['Instrument_Sans']">

    <nav class="sticky top-0 z-50 w-full border-b border-black/5 dark:border-white/5 bg-white/70 dark:bg-[#0a0a0a]/70 backdrop-blur-xl">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex-shrink-0 flex items-center gap-2">
                    <div class="w-8 h-8 bg-orange-500 rounded-lg shadow-lg shadow-orange-500/20"></div>
                    <span class="font-bold text-xl tracking-tight">{{ config('app.name', 'Laravel') }}</span>
                </div>

                <div class="hidden md:flex items-center space-x-8 text-sm font-medium">
                    <a href="#" class="hover:text-orange-500 transition-colors">Dashboard</a>
                    <a href="#" class="text-black/50 dark:text-white/50 hover:text-orange-500 transition-colors">Projects</a>
                    <a href="#" class="text-black/50 dark:text-white/50 hover:text-orange-500 transition-colors">Settings</a>
                </div>

                <div class="flex items-center gap-4">
                    <button class="p-2 rounded-full hover:bg-black/5 dark:hover:bg-white/5 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2m8-10a4 4 0 100-8 4 4 0 000 8z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        {{-- Header Page (Opsional) --}}
        @if (isset($header))
        <header class="mb-10">
            {{ $header }}
        </header>
        @endif

        {{-- Slot Konten Utama --}}
        <div class="animate-in fade-in slide-in-from-bottom-4 duration-700">
            @yield('content')
        </div>
    </main>

    <footer class="border-t border-black/5 dark:border-white/5 py-8">
        <div class="max-w-7xl mx-auto px-4 text-center text-sm text-black/40 dark:text-white/40">
            &copy; {{ date('Y') }} {{ config('app.name') }}. Built with passion.
        </div>
    </footer>

</body>

</html>
