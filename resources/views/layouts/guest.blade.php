<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'CarePoint') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-white font-sans antialiased">
    <main class="grid min-h-screen lg:grid-cols-[1.02fr_.98fr]">
        <section class="relative hidden overflow-hidden bg-gradient-to-br from-[#0f3f86] via-[#1556b5] to-[#4386e8] px-12 py-10 text-white lg:flex lg:flex-col xl:px-20">
            <div class="absolute -right-32 -top-24 h-96 w-96 rounded-full border border-white/10"></div><div class="absolute -right-16 -top-8 h-64 w-64 rounded-full border border-white/10"></div><div class="absolute -bottom-36 -left-24 h-[30rem] w-[30rem] rounded-full bg-white/5"></div>
            <a href="/" class="relative z-10 flex items-center gap-3"><span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-white/15 text-2xl font-extrabold">+</span><span class="text-xl font-extrabold tracking-tight">CarePoint</span></a>
            <div class="relative z-10 my-auto max-w-xl py-14">
                <p class="mb-5 inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-3.5 py-2 text-xs font-bold tracking-wide text-blue-50"><span class="h-2 w-2 rounded-full bg-emerald-300"></span> HEALTHCARE, CONNECTED</p>
                <h1 class="text-4xl font-extrabold leading-[1.12] tracking-tight xl:text-5xl">Better care starts with a better connection.</h1>
                <p class="mt-5 max-w-lg text-base leading-7 text-blue-100">A calm, coordinated experience for patients and care teams. Your health journey, thoughtfully managed.</p>
                <div class="relative mt-12 overflow-hidden rounded-[28px] border border-white/20 bg-white/10 p-6 shadow-2xl shadow-blue-950/10 backdrop-blur-sm">
                    <div class="absolute -right-7 -top-10 h-40 w-40 rounded-full bg-cyan-300/10 blur-2xl"></div>
                    <div class="relative flex items-center justify-between gap-4"><div><p class="text-sm font-bold">Your care team is here</p><p class="mt-1 text-xs text-blue-100">One place for every step forward</p></div><div class="flex -space-x-3"><span class="flex h-11 w-11 items-center justify-center rounded-full border-2 border-blue-500 bg-sky-200 text-sm font-bold text-blue-800">DR</span><span class="flex h-11 w-11 items-center justify-center rounded-full border-2 border-blue-500 bg-emerald-200 text-sm font-bold text-emerald-800">RN</span><span class="flex h-11 w-11 items-center justify-center rounded-full border-2 border-blue-500 bg-amber-100 text-sm font-bold text-amber-800">+</span></div></div>
                    <div class="relative mt-6 h-2 overflow-hidden rounded-full bg-white/15"><div class="h-full w-2/3 rounded-full bg-gradient-to-r from-cyan-200 to-white"></div></div><div class="relative mt-2 flex justify-between text-[11px] text-blue-100"><span>Care plan</span><span>Appointments · Records · Support</span></div>
                </div>
            </div>
            <div class="relative z-10 flex items-center justify-between text-xs text-blue-100"><span>© {{ date('Y') }} CarePoint Health</span><span>Compassion in every connection</span></div>
        </section>
        <section class="flex min-h-screen flex-col px-5 py-7 sm:px-10 lg:px-12 xl:px-20">
            <div class="flex items-center justify-between lg:justify-end"><a href="/" class="flex items-center gap-2 font-extrabold text-slate-900 lg:hidden"><span class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-600 text-xl text-white">+</span>CarePoint</a><a href="/" class="text-sm font-semibold text-slate-500 transition hover:text-blue-700">← <span class="hidden sm:inline">Back to home</span><span class="sm:hidden">Home</span></a></div>
            <div class="mx-auto my-auto w-full max-w-[430px] py-10 animate-rise-in">{{ $slot }}</div>
            <p class="text-center text-xs text-slate-400">Secure access · Your health information stays private</p>
        </section>
    </main>
</body>
</html>
