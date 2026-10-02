<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'HospitalCare') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="page-shell">
        @include('layouts.navigation')
        <main class="min-w-0 lg:pl-[260px]">
            @isset($header)
                <header class="border-b border-slate-200/80 bg-white/85 px-4 py-5 backdrop-blur-xl sm:px-6 lg:px-9">
                    <div class="mx-auto flex max-w-[1440px] items-center justify-between gap-4">
                        <div>{{ $header }}</div>
                        <div class="hidden items-center gap-2 text-xs font-medium text-slate-400 sm:flex">
                            <span>Workspace</span><span>/</span><span class="text-slate-600">{{ trim(strip_tags($header)) }}</span>
                        </div>
                    </div>
                </header>
            @endisset
            {{ $slot }}
        </main>
    </div>
</body>
</html>
