<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DoctorController extends Controller
{
    public function dashboard(Request $request): View
    {
        return view('doctor.dashboard', [
            'appointments' => Appointment::with(['patient', 'department', 'prescription'])
                ->where('doctor_id', $request->user()->id)
                ->where('status', 'approved')
                ->orderBy('date')
                ->orderBy('time')
                ->get(),
        ]);
    }

    public function storePrescription(Request $request, Appointment $appointment): RedirectResponse
    {
        abort_if($appointment->doctor_id !== $request->user()->id || $appointment->status !== 'approved', 403);

        $data = $request->validate([
            'medicine_details' => ['required', 'string'],
            'notes' => ['nullable', 'string'],
        ]);

        $appointment->prescription()->updateOrCreate(
            ['appointment_id' => $appointment->id],
            $data
        );

        return back()->with('success', 'Prescription saved.');
    }
}
