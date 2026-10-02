<x-app-layout>
    <x-slot name="header"><div><p class="eyebrow">Directory</p><h1 class="page-title">Patients</h1></div></x-slot>
    <div class="page-content space-y-6 animate-rise-in">
        @if (session('success'))<div role="status" class="rounded-xl border border-emerald-100 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">{{ session('success') }}</div>@endif
        @if ($errors->any())<div role="alert" class="rounded-xl border border-rose-100 bg-rose-50 px-4 py-3 text-sm font-medium text-rose-700">Please review the highlighted fields and try again.</div>@endif
        <form method="POST" action="{{ route('admin.patients.store') }}" class="panel p-5 sm:p-7">@csrf
            <div class="flex flex-wrap items-start justify-between gap-2"><div><p class="eyebrow">Patient records</p><h2 class="mt-1 text-lg font-extrabold text-slate-900">Add a patient</h2></div><span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-bold text-blue-700">New record</span></div>
            <div class="mt-5 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                <div><label for="patient-name" class="form-label">Full name</label><input id="patient-name" name="name" required value="{{ old('name') }}" placeholder="Patient name" class="field-control mt-1.5">@error('name')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror</div>
                <div><label for="patient-email" class="form-label">Email address</label><input id="patient-email" name="email" type="email" required value="{{ old('email') }}" placeholder="name@example.com" class="field-control mt-1.5">@error('email')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror</div>
                <div><label for="patient-password" class="form-label">Password</label><input id="patient-password" name="password" type="password" required autocomplete="new-password" placeholder="Create a password" class="field-control mt-1.5">@error('password')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror</div>
                <div><label for="patient-password-confirmation" class="form-label">Confirm password</label><input id="patient-password-confirmation" name="password_confirmation" type="password" required autocomplete="new-password" placeholder="Confirm password" class="field-control mt-1.5"></div>
            </div>
            <button class="btn-primary mt-5">Create patient</button>
        </form>
        <section class="panel overflow-hidden" x-data="{ query: '' }">
            <div class="flex flex-col justify-between gap-4 p-5 sm:flex-row sm:items-center sm:px-6"><div><p class="eyebrow">Patient directory</p><h2 class="mt-1 text-lg font-extrabold text-slate-900">Manage patients</h2></div><label class="relative block w-full sm:max-w-xs"><span class="sr-only">Search patients</span><span aria-hidden="true" class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">⌕</span><input x-model="query" type="search" placeholder="Search patients…" class="field-control pl-9"></label></div>
            <div class="table-wrap rounded-none border-x-0 border-b-0"><table class="data-table"><thead><tr><th>Patient</th><th>Email</th><th>Update password</th><th>Actions</th></tr></thead><tbody class="divide-y divide-slate-100">
                @forelse ($patients as $patient)
                    <tr x-show="($el.innerText + ' ' + Array.from($el.querySelectorAll('input,select')).map(field => field.value).join(' ')).toLowerCase().includes(query.toLowerCase())">
                        <td><div class="flex items-center gap-3"><span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-sm font-bold text-blue-700">{{ strtoupper(substr($patient->name, 0, 1)) }}</span><input form="patient-update-{{ $patient->id }}" name="name" value="{{ $patient->name }}" class="field-control min-w-[150px] font-semibold" aria-label="Name for {{ $patient->name }}"></div></td>
                        <td><input form="patient-update-{{ $patient->id }}" name="email" type="email" value="{{ $patient->email }}" class="field-control min-w-[190px]" aria-label="Email for {{ $patient->name }}"></td>
                        <td><div class="grid min-w-[240px] gap-2 sm:grid-cols-2"><input form="patient-update-{{ $patient->id }}" name="password" type="password" placeholder="New password" autocomplete="new-password" class="field-control" aria-label="New password for {{ $patient->name }}"><input form="patient-update-{{ $patient->id }}" name="password_confirmation" type="password" placeholder="Confirm" autocomplete="new-password" class="field-control" aria-label="Confirm password for {{ $patient->name }}"></div></td>
                        <td><div class="flex items-center gap-2"><form id="patient-update-{{ $patient->id }}" method="POST" action="{{ route('admin.patients.update', $patient) }}">@csrf @method('PUT')</form><button form="patient-update-{{ $patient->id }}" class="btn-primary min-h-9 px-3 py-1.5 text-xs">Save</button><form method="POST" action="{{ route('admin.patients.destroy', $patient) }}">@csrf @method('DELETE')<button class="btn-danger min-h-9 px-3 py-1.5 text-xs">Delete</button></form></div></td>
                    </tr>
                @empty<tr><td colspan="4"><div class="py-12 text-center"><span class="mx-auto flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-100 text-xl text-slate-400">＋</span><p class="mt-3 font-bold text-slate-700">No patients yet</p><p class="mt-1 text-sm text-slate-400">Add a patient to get started.</p></div></td></tr>@endforelse
            </tbody></table></div>
        </section>
    </div>
</x-app-layout>
