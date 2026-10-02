<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Bill;
use App\Models\Department;
use App\Models\Prescription;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $departments = collect([
            'Cardiology',
            'Neurology',
            'Orthopedics',
            'Pediatrics',
            'Dermatology',
        ])->mapWithKeys(fn (string $name) => [
            $name => Department::firstOrCreate(['name' => $name]),
        ]);

        User::updateOrCreate(['email' => 'admin@hospital.test'], [
            'name' => 'Hospital Admin',
            'role' => 'admin',
            'password' => Hash::make('password'),
        ]);

        $doctorOne = User::updateOrCreate(['email' => 'doctor@hospital.test'], [
            'name' => 'Dr. Sarah Ahmed',
            'role' => 'doctor',
            'department_id' => $departments['Cardiology']->id,
            'password' => Hash::make('password'),
        ]);

        $doctorTwo = User::updateOrCreate(['email' => 'neuro@hospital.test'], [
            'name' => 'Dr. Michael Chen',
            'role' => 'doctor',
            'department_id' => $departments['Neurology']->id,
            'password' => Hash::make('password'),
        ]);

        $patient = User::updateOrCreate(['email' => 'patient@hospital.test'], [
            'name' => 'Amina Rahman',
            'role' => 'patient',
            'password' => Hash::make('password'),
        ]);

        $approvedAppointment = Appointment::updateOrCreate([
            'patient_id' => $patient->id,
            'doctor_id' => $doctorOne->id,
            'date' => now()->addDays(2)->toDateString(),
            'time' => '10:30',
        ], [
            'department_id' => $doctorOne->department_id,
            'reason' => 'Routine cardiac follow-up and medication review.',
            'status' => 'approved',
        ]);

        Appointment::updateOrCreate([
            'patient_id' => $patient->id,
            'doctor_id' => $doctorTwo->id,
            'date' => now()->addDays(5)->toDateString(),
            'time' => '14:00',
        ], [
            'department_id' => $doctorTwo->department_id,
            'reason' => 'Recurring migraine consultation.',
            'status' => 'pending',
        ]);

        Prescription::updateOrCreate([
            'appointment_id' => $approvedAppointment->id,
        ], [
            'medicine_details' => 'Atorvastatin 10mg once daily after dinner.',
            'notes' => 'Continue light exercise and return with lipid profile report.',
        ]);

        Bill::updateOrCreate([
            'appointment_id' => $approvedAppointment->id,
        ], [
            'patient_id' => $patient->id,
            'amount' => 125.00,
            'status' => 'unpaid',
        ]);
    }
}
