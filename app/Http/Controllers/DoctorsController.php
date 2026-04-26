<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Doctor;
use App\Models\Facility;
use App\Models\HealthStaff;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;

class DoctorsController extends Controller
{
    public function index(Request $request)
    {
        $query = Doctor::query();

        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('specialization', 'like', "%{$search}%");
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->department) {
            $query->where('specialization', $request->department);
        }

        $doctors = $query->latest('DoctorID')->paginate(10)->withQueryString();

        return view('admin.doctors.index', compact('doctors'));
    }

    public function create()
    {
        return view('admin.doctors.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:doctors,email',
            'phone' => 'nullable|string|max:50',
            'department' => 'required|string|max:255',
            'status' => 'nullable|string|in:available,unavailable,onleave',
            'experience' => 'nullable|integer|min:0|max:50',
            'fee' => 'nullable|numeric|min:0',
            'bio' => 'nullable|string',
        ]);

        $createdUser = false;

        DB::transaction(function () use ($data, &$createdUser) {
            $user = User::query()->where('email', $data['email'])->first();

            if ($user) {
                $isDoctor = ($user->role ?? null) === 'doctor' || (method_exists($user, 'hasRole') && $user->hasRole('doctor'));
                if (! $isDoctor) {
                    throw ValidationException::withMessages([
                        'email' => ['This email is already used by another account.'],
                    ]);
                }

                $user->update([
                    'name' => trim($data['first_name'].' '.$data['last_name']),
                    'phone' => $data['phone'] ?? $user->phone,
                    'role' => 'doctor',
                ]);
            } else {
                $user = User::create([
                    'name' => trim($data['first_name'].' '.$data['last_name']),
                    'email' => $data['email'],
                    'phone' => $data['phone'] ?? null,
                    'password' => Hash::make('password'),
                    'role' => 'doctor',
                    'status' => 'active',
                ]);

                $createdUser = true;
            }

            Role::firstOrCreate(['name' => 'doctor']);
            if (method_exists($user, 'assignRole') && ! $user->hasRole('doctor')) {
                $user->assignRole('doctor');
            }

            Doctor::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?? '',
                'specialization' => $data['department'],
                'status' => strtolower($data['status'] ?? 'onleave'),
                'years_of_experience' => $data['experience'] ?? 0,
                'consultation_fee' => $data['fee'] ?? 0,
                'schedule_load' => 0,
                'biography_note' => $data['bio'] ?? null,
            ]);

            $defaultFacility = Facility::query()->orderBy('id')->first();
            if ($defaultFacility) {
                $departmentId = Department::query()
                    ->where('facility_id', $defaultFacility->id)
                    ->where('name', $data['department'])
                    ->value('id');

                if (! $departmentId) {
                    $departmentId = Department::query()
                        ->where('facility_id', $defaultFacility->id)
                        ->orderBy('id')
                        ->value('id');
                }

                $staff = HealthStaff::query()
                    ->where('user_id', $user->id)
                    ->orWhere('email', $user->email)
                    ->first();

                if ($staff) {
                    $staff->update([
                        'user_id' => $user->id,
                        'first_name' => $data['first_name'],
                        'last_name' => $data['last_name'],
                        'phone' => $data['phone'] ?? $staff->phone,
                        'email' => $data['email'],
                        'role' => 'doctor',
                        'status' => 'active',
                    ]);
                } else {
                    $staffCodeBase = 'DOC-'.str_pad((string) $user->id, 5, '0', STR_PAD_LEFT);
                    $staffCode = $staffCodeBase;

                    while (HealthStaff::query()->where('staff_code', $staffCode)->exists()) {
                        $staffCode = $staffCodeBase.'-'.Str::upper(Str::random(4));
                    }

                    HealthStaff::create([
                        'user_id' => $user->id,
                        'staff_code' => $staffCode,
                        'facility_id' => $defaultFacility->id,
                        'department_id' => $departmentId,
                        'first_name' => $data['first_name'],
                        'last_name' => $data['last_name'],
                        'gender' => null,
                        'date_of_birth' => null,
                        'phone' => $data['phone'] ?? null,
                        'email' => $data['email'],
                        'role' => 'doctor',
                        'license_number' => null,
                        'hire_date' => null,
                        'status' => 'active',
                    ]);
                }
            }
        });

        $message = 'Doctor added successfully.';
        if ($createdUser) {
            $message .= ' A login account was created (default password: password).';
        }

        return redirect()->route('admin.doctors.index')->with('success', $message);
    }

    public function destroy(Doctor $doctor)
    {
        $user = User::query()->where('email', $doctor->email)->first();

        if ($user) {
            $isDoctor = ($user->role ?? null) === 'doctor' || (method_exists($user, 'hasRole') && $user->hasRole('doctor'));
            $isAdmin = ($user->role ?? null) === 'admin' || (method_exists($user, 'hasRole') && $user->hasRole('admin'));

            if ($isDoctor && ! $isAdmin) {
                $user->delete();
            }
        }

        $doctor->delete();

        return redirect()->route('admin.doctors.index')->with('success', 'Doctor deleted.');
    }

    public function edit(Doctor $doctor)
    {
        return view('admin.doctors.edit', compact('doctor'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:doctors,email,'.$doctor->DoctorID.',DoctorID',
            'phone' => 'nullable|string|max:50',
            'department' => 'required|string|max:255',
            'status' => 'nullable|string|in:available,unavailable,onleave',
            'experience' => 'nullable|integer|min:0|max:50',
            'fee' => 'nullable|numeric|min:0',
            'bio' => 'nullable|string',
        ]);

        $createdUser = false;
        $oldEmail = $doctor->email;

        DB::transaction(function () use ($doctor, $data, $oldEmail, &$createdUser) {
            $user = User::query()->where('email', $oldEmail)->first();
            $userWithNewEmail = User::query()->where('email', $data['email'])->first();

            if ($userWithNewEmail && (! $user || $userWithNewEmail->id !== $user->id)) {
                throw ValidationException::withMessages([
                    'email' => ['This email is already used by another account.'],
                ]);
            }

            if (! $user) {
                $user = User::create([
                    'name' => trim($data['first_name'].' '.$data['last_name']),
                    'email' => $data['email'],
                    'phone' => $data['phone'] ?? null,
                    'password' => Hash::make('password'),
                    'role' => 'doctor',
                    'status' => 'active',
                ]);

                $createdUser = true;
            } else {
                $user->update([
                    'name' => trim($data['first_name'].' '.$data['last_name']),
                    'email' => $data['email'],
                    'phone' => $data['phone'] ?? $user->phone,
                    'role' => 'doctor',
                ]);
            }

            Role::firstOrCreate(['name' => 'doctor']);
            if (method_exists($user, 'assignRole') && ! $user->hasRole('doctor')) {
                $user->assignRole('doctor');
            }

            $doctor->update([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'phone' => $data['phone'] ?? '',
                'specialization' => $data['department'],
                'status' => strtolower($data['status'] ?? 'onleave'),
                'years_of_experience' => $data['experience'] ?? 0,
                'consultation_fee' => $data['fee'] ?? 0,
                'biography_note' => $data['bio'] ?? null,
            ]);

            $defaultFacility = Facility::query()->orderBy('id')->first();
            if ($defaultFacility) {
                $departmentId = Department::query()
                    ->where('facility_id', $defaultFacility->id)
                    ->where('name', $data['department'])
                    ->value('id');

                if (! $departmentId) {
                    $departmentId = Department::query()
                        ->where('facility_id', $defaultFacility->id)
                        ->orderBy('id')
                        ->value('id');
                }

                $staff = HealthStaff::query()
                    ->where('user_id', $user->id)
                    ->orWhere('email', $oldEmail)
                    ->orWhere('email', $data['email'])
                    ->first();

                if ($staff) {
                    $staff->update([
                        'user_id' => $user->id,
                        'first_name' => $data['first_name'],
                        'last_name' => $data['last_name'],
                        'phone' => $data['phone'] ?? $staff->phone,
                        'email' => $data['email'],
                        'role' => 'doctor',
                        'status' => 'active',
                    ]);
                } else {
                    $staffCodeBase = 'DOC-'.str_pad((string) $user->id, 5, '0', STR_PAD_LEFT);
                    $staffCode = $staffCodeBase;

                    while (HealthStaff::query()->where('staff_code', $staffCode)->exists()) {
                        $staffCode = $staffCodeBase.'-'.Str::upper(Str::random(4));
                    }

                    HealthStaff::create([
                        'user_id' => $user->id,
                        'staff_code' => $staffCode,
                        'facility_id' => $defaultFacility->id,
                        'department_id' => $departmentId,
                        'first_name' => $data['first_name'],
                        'last_name' => $data['last_name'],
                        'gender' => null,
                        'date_of_birth' => null,
                        'phone' => $data['phone'] ?? null,
                        'email' => $data['email'],
                        'role' => 'doctor',
                        'license_number' => null,
                        'hire_date' => null,
                        'status' => 'active',
                    ]);
                }
            }
        });

        $message = 'Doctor updated successfully.';
        if ($createdUser) {
            $message .= ' A login account was created (default password: password).';
        }

        return redirect()->route('admin.doctors.index')->with('success', $message);
    }
}
