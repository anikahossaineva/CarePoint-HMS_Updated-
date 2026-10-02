<x-guest-layout>
    <div class="mb-8"><p class="eyebrow">Account recovery</p><h1 class="mt-2 text-3xl font-extrabold tracking-tight text-slate-950">Choose a new password</h1><p class="mt-2 text-sm text-slate-500">Set a new password to secure your CarePoint account.</p></div>
    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">@csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        <div><x-input-label for="email" :value="__('Email address')" class="form-label" /><x-text-input id="email" class="auth-field" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" placeholder="you@example.com" /><x-input-error :messages="$errors->get('email')" class="mt-2" /></div>
        <div x-data="{ show: false }"><x-input-label for="password" :value="__('New password')" class="form-label" /><div class="relative"><x-text-input id="password" class="auth-field pr-16" x-bind:type="show ? 'text' : 'password'" type="password" name="password" required autocomplete="new-password" placeholder="New password" /><button type="button" @click="show = !show" class="absolute inset-y-0 right-3 my-auto h-8 rounded-lg px-2 text-xs font-bold text-slate-400 hover:text-blue-700" :aria-label="show ? 'Hide password' : 'Show password'" x-text="show ? 'Hide' : 'Show'"></button></div><x-input-error :messages="$errors->get('password')" class="mt-2" /></div>
        <div><x-input-label for="password_confirmation" :value="__('Confirm password')" class="form-label" /><x-text-input id="password_confirmation" class="auth-field" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Re-enter new password" /><x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" /></div>
        <button type="submit" class="btn-primary w-full">{{ __('Reset password') }} <span class="ml-2">→</span></button>
    </form>
</x-guest-layout>
