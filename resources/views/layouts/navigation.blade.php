@php
    $user = Auth::user();
    $homeRoute = match ($user->role) {
        'admin' => route('admin.dashboard'),
        'doctor' => route('doctor.dashboard'),
        default => route('dashboard'),
    };
    $links = [['Dashboard', $homeRoute, 'dashboard']];
    if ($user->role === 'admin') {
        $links = array_merge($links, [
            ['Departments', route('admin.departments'), 'admin.departments'],
            ['Doctors', route('admin.doctors'), 'admin.doctors'],
            ['Patients', route('admin.patients'), 'admin.patients'],
            ['Appointments', route('admin.appointments'), 'admin.appointments'],
            ['Billing', route('admin.bills'), 'admin.bills'],
        ]);
    }
@endphp
<div x-data="{ mobileOpen: false, profileOpen: false }">
    <div class="sticky top-0 z-30 flex h-[68px] items-center justify-between border-b border-slate-200/80 bg-white/90 px-4 backdrop-blur-xl lg:hidden">
        <a href="{{ $homeRoute }}" class="flex items-center gap-2.5">
            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-blue-600 text-lg font-extrabold text-white shadow-md shadow-blue-600/20">+</span>
            <span class="font-extrabold tracking-tight text-slate-900">Care<span class="text-blue-600">Point</span></span>
        </a>
        <button type="button" @click="mobileOpen = !mobileOpen" :aria-expanded="mobileOpen.toString()" aria-label="Toggle navigation" class="rounded-xl border border-slate-200 p-2.5 text-slate-600">
            <svg x-show="!mobileOpen" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
            <svg x-show="mobileOpen" x-cloak class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" d="m6 6 12 12M18 6 6 18"/></svg>
        </button>
    </div>
    <aside class="fixed inset-y-0 left-0 z-40 hidden w-[260px] flex-col border-r border-slate-200/80 bg-white px-5 pb-5 pt-7 lg:flex">
        <a href="{{ $homeRoute }}" class="mb-10 flex items-center gap-3 px-2">
            <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-blue-600 text-2xl font-extrabold text-white shadow-lg shadow-blue-600/20">+</span>
            <span><span class="block text-lg font-extrabold tracking-tight text-slate-900">CarePoint</span><span class="block text-[10px] font-bold uppercase tracking-[.16em] text-slate-400">Care management</span></span>
        </a>
        <p class="mb-3 px-3 text-[10px] font-extrabold uppercase tracking-[.16em] text-slate-400">Workspace</p>
        <nav aria-label="Main navigation" class="space-y-1">
            @foreach ($links as [$label, $href, $routeName])
                @php($active = request()->routeIs($routeName) || ($routeName === 'dashboard' && request()->routeIs('admin.dashboard', 'doctor.dashboard')))
                <a href="{{ $href }}" @class(['group flex items-center gap-3 rounded-xl px-3.5 py-3 text-sm font-semibold transition', 'bg-blue-50 text-blue-700' => $active, 'text-slate-500 hover:bg-slate-50 hover:text-slate-900' => !$active])>
                    <span @class(['flex h-8 w-8 items-center justify-center rounded-lg text-xs font-extrabold', 'bg-white text-blue-600 shadow-sm' => $active, 'bg-slate-100 text-slate-500 group-hover:bg-white' => !$active])>{{ strtoupper(substr($label, 0, 1)) }}</span>{{ $label }}
                    @if ($active)<span class="ml-auto h-1.5 w-1.5 rounded-full bg-blue-600"></span>@endif
                </a>
            @endforeach
        </nav>
        <div class="mt-auto rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-700 p-4 text-white shadow-lg shadow-blue-700/15">
            <div class="mb-3 flex h-9 w-9 items-center justify-center rounded-xl bg-white/15 text-lg">✦</div>
            <p class="text-sm font-bold">Care, connected.</p>
            <p class="mt-1 text-xs leading-5 text-blue-100">Your healthcare workspace, all in one place.</p>
        </div>
        <div class="relative mt-4 border-t border-slate-100 pt-4">
            <button @click="profileOpen = !profileOpen" class="flex w-full items-center gap-3 rounded-xl p-2 text-left hover:bg-slate-50" aria-label="Open profile menu" :aria-expanded="profileOpen.toString()">
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-blue-100 text-sm font-bold text-blue-700">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                <span class="min-w-0 flex-1"><span class="block truncate text-sm font-bold text-slate-800">{{ $user->name }}</span><span class="block text-xs capitalize text-slate-400">{{ $user->role }}</span></span><span class="text-slate-400">⌄</span>
            </button>
            <div x-show="profileOpen" x-cloak x-transition @click.outside="profileOpen = false" class="absolute bottom-14 left-0 z-50 w-full rounded-xl border border-slate-100 bg-white p-2 shadow-xl">
                <a href="{{ route('profile.edit') }}" class="block rounded-lg px-3 py-2 text-sm text-slate-600 hover:bg-slate-50">Profile & settings</a>
                <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="w-full rounded-lg px-3 py-2 text-left text-sm font-medium text-rose-600 hover:bg-rose-50">Log out</button></form>
            </div>
        </div>
    </aside>
    <div x-show="mobileOpen" x-cloak x-transition.opacity @click="mobileOpen = false" class="fixed inset-0 z-40 bg-slate-950/30 lg:hidden"></div>
    <aside x-show="mobileOpen" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" class="fixed inset-y-0 left-0 z-50 flex w-[280px] flex-col border-r border-slate-200 bg-white p-5 pt-7 lg:hidden">
        <div class="mb-8 flex items-center justify-between"><a href="{{ $homeRoute }}" class="font-extrabold text-slate-900">Care<span class="text-blue-600">Point</span></a><button @click="mobileOpen = false" aria-label="Close navigation" class="rounded-lg p-2 text-slate-500">✕</button></div>
        <nav aria-label="Mobile navigation" class="space-y-1">
            @foreach ($links as [$label, $href, $routeName])
                @php($active = request()->routeIs($routeName) || ($routeName === 'dashboard' && request()->routeIs('admin.dashboard', 'doctor.dashboard')))
                <a href="{{ $href }}" @click="mobileOpen = false" @class(['block rounded-xl px-4 py-3 text-sm font-semibold', 'bg-blue-50 text-blue-700' => $active, 'text-slate-600 hover:bg-slate-50' => !$active])>{{ $label }}</a>
            @endforeach
            <a href="{{ route('profile.edit') }}" class="block rounded-xl px-4 py-3 text-sm font-semibold text-slate-600">Profile</a>
        </nav>
        <div class="mt-auto border-t border-slate-100 pt-4"><p class="mb-3 text-sm font-bold text-slate-800">{{ $user->name }}</p><form method="POST" action="{{ route('logout') }}">@csrf<button class="text-sm font-semibold text-rose-600">Log out</button></form></div>
    </aside>
</div>
