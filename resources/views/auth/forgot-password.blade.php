<x-guest-layout>
    <div class="mb-8"><p class="eyebrow">Account recovery</p><h1 class="mt-2 text-3xl font-extrabold tracking-tight text-slate-950">Reset your password</h1><p class="mt-3 text-sm leading-6 text-slate-500">{{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}</p></div>
    <x-auth-session-status class="mb-5" :status="session('status')" />
    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">@csrf
        <div><x-input-label for="email" :value="__('Email address')" class="form-label" /><x-text-input id="email" class="auth-field" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="you@example.com" /><x-input-error :messages="$errors->get('email')" class="mt-2" /></div>
        <button type="submit" class="btn-primary w-full">{{ __('Email password reset link') }} <span class="ml-2">→</span></button>
    </form>
</x-guest-layout>
