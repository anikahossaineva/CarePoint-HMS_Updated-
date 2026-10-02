@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center rounded-xl bg-blue-50 px-4 py-2.5 text-sm font-semibold text-blue-700 transition duration-150 ease-in-out'
            : 'inline-flex items-center rounded-xl px-4 py-2.5 text-sm font-semibold text-slate-500 transition duration-150 ease-in-out hover:bg-slate-50 hover:text-slate-900';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
