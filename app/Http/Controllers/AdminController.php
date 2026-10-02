<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Bill;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        return view('admin.dashboard', [
            'doctorCount' => User::where('role', 'doctor')->count(),
            'patientCount' => User::where('role', 'patient')->count(),
            'pendingCount' => Appointment::where('status', 'pending')->count(),
            'unpaidTotal' => Bill::where('status', 'unpaid')->sum('amount'),
            'appointments' => Appointment::with(['patient', 'doctor', 'department'])->latest()->take(8)->get(),
        ]);
    }

    public function doctors(): View
    {
        return view('admin.doctors', [
            'doctors' => User::with('department')->where('role', 'doctor')->latest()->get(),
            'departments' => Department::orderBy('name')->get(),
        ]);
    }

    public function storeDoctor(Request $request): RedirectResponse
    {
        $data = $this->validateUser($request, true);
        $data['role'] = 'doctor';
        User::create($data);

        return back()->with('success', 'Doctor profile created.');
    }

    public function updateDoctor(Request $request, User $doctor): RedirectResponse
    {
        $this->ensureRole($doctor, 'doctor');
        $data = $this->validateUser($request, false, $doctor);
        $doctor->update($data);

        return back()->with('success', 'Doctor profile updated.');
    }

    public function destroyDoctor(User $doctor): RedirectResponse
    {
        $this->ensureRole($doctor, 'doctor');
        $doctor->delete();

        return back()->with('success', 'Doctor profile deleted.');
    }

    public function patients(): View
    {
        return view('admin.patients', [
            'patients' => User::where('role', 'patient')->latest()->get(),
        ]);
    }

    public function storePatient(Request $request): RedirectResponse
    {
        $data = $this->validateUser($request, true);
        $data['role'] = 'patient';
        $data['department_id'] = null;
        User::create($data);

        return back()->with('success', 'Patient profile created.');
    }

    public function updatePatient(Request $request, User $patient): RedirectResponse
    {
        $this->ensureRole($patient, 'patient');
        $data = $this->validateUser($request, false, $patient);
        $data['department_id'] = null;
        $patient->update($data);

        return back()->with('success', 'Patient profile updated.');
    }

    public function destroyPatient(User $patient): RedirectResponse
    {
        $this->ensureRole($patient, 'patient');
        $patient->delete();

        return back()->with('success', 'Patient profile deleted.');
    }

    public function departments(): View
    {
        return view('admin.departments', [
            'departments' => Department::withCount('doctors')->orderBy('name')->get(),
        ]);
    }

    public function storeDepartment(Request $request): RedirectResponse
    {
        $request->validate(['name' => ['required', 'string', 'max:255', 'unique:departments,name']]);
        Department::create($request->only('name'));

        return back()->with('success', 'Department created.');
    }

    public function updateDepartment(Request $request, Department $department): RedirectResponse
    {
        $request->validate(['name' => ['required', 'string', 'max:255', Rule::unique('departments', 'name')->ignore($department)]]);
        $department->update($request->only('name'));

        return back()->with('success', 'Department updated.');
    }

    public function destroyDepartment(Department $department): RedirectResponse
    {
        $department->delete();

        return back()->with('success', 'Department deleted.');
    }

    public function appointments(): View
    {
        return view('admin.appointments', [
            'appointments' => Appointment::with(['patient', 'doctor', 'department', 'bill'])->latest()->get(),
        ]);
    }

    public function updateAppointmentStatus(Request $request, Appointment $appointment): RedirectResponse
    {
        $request->validate(['status' => ['required', Rule::in(['approved', 'rejected'])]]);
        $appointment->update(['status' => $request->status]);

        return back()->with('success', 'Appointment status updated.');
    }

    public function bills(): View
    {
        return view('admin.bills', [
            'bills' => Bill::with(['patient', 'appointment.doctor'])->latest()->get(),
            'appointments' => Appointment::with(['patient', 'doctor'])
                ->where('status', 'approved')
                ->doesntHave('bill')
                ->latest()
                ->get(),
        ]);
    }

    public function storeBill(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'appointment_id' => ['required', 'exists:appointments,id', 'unique:bills,appointment_id'],
            'amount' => ['required', 'numeric', 'min:0'],
            'status' => ['required', Rule::in(['unpaid', 'paid'])],
        ]);

        $appointment = Appointment::findOrFail($data['appointment_id']);
        Bill::create([
            'patient_id' => $appointment->patient_id,
            'appointment_id' => $appointment->id,
            'amount' => $data['amount'],
            'status' => $data['status'],
        ]);

        return back()->with('success', 'Bill generated.');
    }

    public function updateBill(Request $request, Bill $bill): RedirectResponse
    {
        $data = $request->validate([
            'amount' => ['required', 'numeric', 'min:0'],
            'status' => ['required', Rule::in(['unpaid', 'paid'])],
        ]);
        $bill->update($data);

        return back()->with('success', 'Bill updated.');
    }

    private function validateUser(Request $request, bool $passwordRequired, ?User $user = null): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user)],
            'department_id' => ['nullable', 'exists:departments,id'],
            'password' => [$passwordRequired ? 'required' : 'nullable', 'confirmed', 'min:8'],
        ];

        $data = $request->validate($rules);
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        return $data;
    }

    private function ensureRole(User $user, string $role): void
    {
        abort_if($user->role !== $role, 404);
    }
}
