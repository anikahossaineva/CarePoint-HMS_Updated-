<x-guest-layout>
    <div class="mb-8"><p class="eyebrow">Security check</p><h1 class="mt-2 text-3xl font-extrabold tracking-tight text-slate-950">Confirm your password</h1><p class="mt-3 text-sm leading-6 text-slate-500">{{ __('This is a secure area of the application. Please confirm your password before continuing.') }}</p></div>
    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">@csrf
        <div><x-input-label for="password" :value="__('Password')" class="form-label" /><x-text-input id="password" class="auth-field" type="password" name="password" required autocomplete="current-password" placeholder="Enter your password" /><x-input-error :messages="$errors->get('password')" class="mt-2" /></div>
        <button type="submit" class="btn-primary w-full">{{ __('Confirm') }} <span class="ml-2">→</span></button>
    </form>
</x-guest-layout>
