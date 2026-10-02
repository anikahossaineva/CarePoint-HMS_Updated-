<x-app-layout>
    <x-slot name="header">
        <h2 class="page-title">Doctor dashboard</h2>
    </x-slot>

    <div class="page-content animate-rise-in">
        <div class="mx-auto max-w-7xl space-y-6 px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="rounded-xl border border-emerald-100 bg-emerald-50 p-4 text-emerald-800">{{ session('success') }}</div>
            @endif
            <div class="panel p-6 sm:p-7">
                <h3 class="text-lg font-semibold text-slate-950">Approved Appointments</h3>
                <div class="mt-4 space-y-4">
                    @forelse ($appointments as $appointment)
                        <div class="rounded-2xl border border-blue-100 p-5">
                            <div class="flex flex-wrap items-start justify-between gap-4">
                                <div>
                                    <p class="font-semibold text-slate-950">{{ $appointment->patient->name }}</p>
                                    <p class="text-sm text-slate-500">{{ $appointment->department->name }} - {{ $appointment->date->format('M d, Y') }} at {{ substr($appointment->time, 0, 5) }}</p>
                                    <p class="mt-2 text-sm text-slate-700">{{ $appointment->reason }}</p>
                                </div>
                                <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-800">Approved</span>
                            </div>
                            <form method="POST" action="{{ route('doctor.prescriptions.store', $appointment) }}" class="mt-5 grid gap-4 md:grid-cols-2">
                                @csrf
                                <div>
                                    <label class="form-label">Medicine Details</label>
                                    <textarea name="medicine_details" rows="3" required class="field-control mt-1">{{ old('medicine_details', $appointment->prescription?->medicine_details) }}</textarea>
                                </div>
                                <div>
                                    <label class="form-label">Notes</label>
                                    <textarea name="notes" rows="3" class="field-control mt-1">{{ old('notes', $appointment->prescription?->notes) }}</textarea>
                                </div>
                                <div class="md:col-span-2">
                                    <button class="rounded-xl bg-blue-700 px-5 py-2.5 font-semibold text-white hover:bg-blue-800">Save Prescription</button>
                                </div>
                            </form>
                        </div>
                    @empty
                        <p class="rounded-2xl border border-blue-100 p-6 text-center text-slate-500">No approved appointments assigned yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
