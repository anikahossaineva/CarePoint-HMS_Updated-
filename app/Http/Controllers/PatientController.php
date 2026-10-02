<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PatientController extends Controller
{
    public function dashboard(Request $request): View
    {
        return view('dashboard', [
            'departments' => Department::with('doctors')->orderBy('name')->get(),
            'doctors' => User::where('role', 'doctor')->whereNotNull('department_id')->orderBy('name')->get(),
            'appointments' => Appointment::with(['doctor.department', 'department', 'prescription', 'bill'])
                ->where('patient_id', $request->user()->id)
                ->latest()
                ->get(),
            'bills' => $request->user()->bills()->with('appointment.doctor')->latest()->get(),
        ]);
    }

    public function storeAppointment(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'department_id' => ['required', 'exists:departments,id'],
            'doctor_id' => ['required', 'exists:users,id'],
            'date' => ['required', 'date', 'after_or_equal:today'],
            'time' => ['required'],
            'reason' => ['required', 'string', 'max:2000'],
        ]);

        $doctor = User::where('role', 'doctor')
            ->where('department_id', $data['department_id'])
            ->findOrFail($data['doctor_id']);

        Appointment::create([
            'patient_id' => $request->user()->id,
            'doctor_id' => $doctor->id,
            'department_id' => $data['department_id'],
            'date' => $data['date'],
            'time' => $data['time'],
            'reason' => $data['reason'],
            'status' => 'pending',
        ]);

        return back()->with('success', 'Appointment request submitted.');
    }
}
