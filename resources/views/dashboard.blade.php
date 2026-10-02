<x-app-layout>
    <x-slot name="header">
        <h2 class="page-title">Patient dashboard</h2>
    </x-slot>

    <div class="page-content animate-rise-in">
        <div class="mx-auto max-w-7xl space-y-8 px-4 sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="rounded-2xl border border-emerald-100 bg-white p-4 text-blue-700">{{ session('success') }}</div>
            @endif

            <section class="panel p-6 sm:p-7">
                <h3 class="text-lg font-semibold text-slate-950">Book Appointment</h3>
                <form method="POST" action="{{ route('patient.appointments.store') }}" class="mt-6 grid gap-4 md:grid-cols-2">
                    @csrf
                    <div>
                        <label class="form-label" for="department_id">Department</label>
                        <select id="department_id" name="department_id" required class="field-control mt-1">
                            <option value="">Select department</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                        @error('department_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label" for="doctor_id">Doctor</label>
                        <select id="doctor_id" name="doctor_id" required class="field-control mt-1">
                            <option value="">Select doctor</option>
                            @foreach ($doctors as $doctor)
                                <option value="{{ $doctor->id }}" data-department="{{ $doctor->department_id }}">{{ $doctor->name }} - {{ $doctor->department?->name }}</option>
                            @endforeach
                        </select>
                        @error('doctor_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label" for="date">Date</label>
                        <input id="date" name="date" type="date" required class="field-control mt-1" value="{{ old('date') }}">
                        @error('date') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="form-label" for="time">Time</label>
                        <input id="time" name="time" type="time" required class="field-control mt-1" value="{{ old('time') }}">
                        @error('time') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="form-label" for="reason">Reason</label>
                        <textarea id="reason" name="reason" rows="3" required class="field-control mt-1">{{ old('reason') }}</textarea>
                        @error('reason') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div class="md:col-span-2">
                        <button class="rounded-xl bg-blue-600 px-5 py-2.5 font-semibold text-white hover:bg-blue-700">Submit Appointment</button>
                    </div>
                </form>
            </section>

            <section class="panel p-6 sm:p-7">
                <h3 class="text-lg font-semibold text-slate-950">Appointments, Prescriptions, and Bills</h3>
                <div class="mt-4 overflow-x-auto">
                    <table class="data-table">
                        <thead class="bg-slate-50 text-left text-slate-600">
                            <tr>
                                <th class="px-4 py-3">Doctor</th>
                                <th class="px-4 py-3">Department</th>
                                <th class="px-4 py-3">Schedule</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Prescription</th>
                                <th class="px-4 py-3">Bill</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($appointments as $appointment)
                                <tr>
                                    <td class="px-4 py-3">{{ $appointment->doctor->name }}</td>
                                    <td class="px-4 py-3">{{ $appointment->department->name }}</td>
                                    <td class="px-4 py-3">{{ $appointment->date->format('M d, Y') }} at {{ substr($appointment->time, 0, 5) }}</td>
                                    <td class="px-4 py-3"><span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">{{ ucfirst($appointment->status) }}</span></td>
                                    <td class="px-4 py-3">
                                        @if ($appointment->prescription)
                                            <div class="font-medium">{{ $appointment->prescription->medicine_details }}</div>
                                            <div class="text-slate-500">{{ $appointment->prescription->notes }}</div>
                                        @else
                                            <span class="text-slate-400">Not available</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        @if ($appointment->bill)
                                            ${{ number_format($appointment->bill->amount, 2) }} <span class="text-slate-500">({{ ucfirst($appointment->bill->status) }})</span>
                                        @else
                                            <span class="text-slate-400">No bill</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="px-4 py-6 text-center text-slate-500">No appointments yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>

    <script>
        const departmentSelect = document.getElementById('department_id');
        const doctorSelect = document.getElementById('doctor_id');
        const doctorOptions = Array.from(doctorSelect.options);
        departmentSelect.addEventListener('change', () => {
            const departmentId = departmentSelect.value;
            doctorSelect.innerHTML = '';
            doctorOptions.forEach(option => {
                if (!option.value || option.dataset.department === departmentId) {
                    doctorSelect.appendChild(option.cloneNode(true));
                }
            });
        });
    </script>
</x-app-layout>
