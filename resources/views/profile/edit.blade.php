<x-app-layout>
    <x-slot name="header"><div><p class="eyebrow">Account</p><h1 class="page-title">Profile & settings</h1></div></x-slot>
    <div class="page-content space-y-5 animate-rise-in">
        <section class="panel p-5 sm:p-8"><div class="max-w-3xl">@include('profile.partials.update-profile-information-form')</div></section>
        <section class="panel p-5 sm:p-8"><div class="max-w-3xl">@include('profile.partials.update-password-form')</div></section>
        <section class="panel border-rose-100 p-5 sm:p-8"><div class="max-w-3xl">@include('profile.partials.delete-user-form')</div></section>
    </div>
</x-app-layout>
