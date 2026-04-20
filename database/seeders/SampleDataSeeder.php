<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\Patients;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        $firstNames = ['James', 'Emily', 'Michael', 'Sarah', 'David', 'Jessica', 'Daniel', 'Laura', 'Chris', 'Amanda'];
        $lastNames  = ['Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Garcia', 'Miller', 'Davis', 'Wilson', 'Taylor'];
        $departments = ['General Health', 'Cardiology', 'Dental', 'Neurology', 'Orthopaedics'];
        $genders = ['male', 'female'];

        foreach ($firstNames as $i => $fn) {
            $ln   = $lastNames[$i];
            $user = User::create([
                'name'     => "$fn $ln",
                'email'    => strtolower("{$fn}.{$ln}{$i}@patient.com"),
                'password' => Hash::make('password'),
                'role'     => 'patient',
            ]);
            Patients::create([
                'user_id'       => $user->id,
                'first_name'    => $fn,
                'last_name'     => $ln,
                'email'         => $user->email,
                'phone'         => '+855 0' . rand(10, 99) . ' ' . rand(100, 999) . ' ' . rand(100, 999),
                'date_of_birth' => now()->subYears(rand(20, 60))->format('Y-m-d'),
                'gender'        => $genders[$i % 2],
                'department'    => $departments[$i % count($departments)],
                'status'        => 'active',
            ]);
        }

        $docFirst = ['Alex', 'Maria', 'Robert', 'Linda', 'Kevin', 'Susan', 'Mark', 'Patricia', 'Steven', 'Karen'];
        $docLast  = ['Clark', 'Lewis', 'Lee', 'Walker', 'Hall', 'Allen', 'Young', 'Hernandez', 'King', 'Wright'];
        $statuses = ['available', 'available', 'onleave', 'unavailable', 'available'];

        foreach ($docFirst as $i => $fn) {
            $ln   = $docLast[$i];
            $user = User::create([
                'name'     => "$fn $ln",
                'email'    => strtolower("{$fn}.{$ln}{$i}@doctor.com"),
                'password' => Hash::make('password'),
                'role'     => 'doctor',
            ]);
            Doctor::create([
                'first_name'         => $fn,
                'last_name'          => $ln,
                'email'              => $user->email,
                'phone'              => '+855 0' . rand(10, 99) . ' ' . rand(100, 999) . ' ' . rand(100, 999),
                'specialization'     => $departments[$i % count($departments)],
                'status'             => $statuses[$i % count($statuses)],
                'years_of_experience'=> rand(2, 25),
                'consultation_fee'   => rand(30, 200),
                'schedule_load'      => rand(20, 90),
                'biography_note'     => 'Experienced specialist with a strong background in patient care.',
            ]);
        }
    }
}
