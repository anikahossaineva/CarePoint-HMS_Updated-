@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full rounded-xl bg-blue-50 px-4 py-3 text-start text-sm font-semibold text-blue-700 transition duration-150 ease-in-out'
            : 'block w-full rounded-xl px-4 py-3 text-start text-sm font-semibold text-slate-600 transition duration-150 ease-in-out hover:bg-slate-50 hover:text-slate-900';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
