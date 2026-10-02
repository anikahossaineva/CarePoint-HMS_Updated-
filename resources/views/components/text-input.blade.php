@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'w-full rounded-xl border-slate-200 bg-slate-50/70 text-sm text-slate-800 placeholder:text-slate-400 shadow-sm transition focus:border-blue-500 focus:bg-white focus:ring-4 focus:ring-blue-100']) }}>
