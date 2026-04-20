<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;

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
        $request->validate([
            'first_name'   => 'required|string|max:255',
            'last_name'    => 'required|string|max:255',
            'email'        => 'required|email|unique:doctors,email',
            'phone'        => 'nullable|string|max:50',
            'department'   => 'required|string|max:255',
            'status'       => 'nullable|string|in:available,unavailable,onleave',
            'experience'   => 'nullable|integer|min:0|max:50',
            'fee'          => 'nullable|numeric|min:0',
            'bio'          => 'nullable|string',
        ]);

        Doctor::create([
            'first_name'          => $request->first_name,
            'last_name'           => $request->last_name,
            'email'               => $request->email,
            'phone'               => $request->phone ?? '',
            'specialization'      => $request->department,
            'status'              => strtolower($request->status ?? 'onleave'),
            'years_of_experience' => $request->experience ?? 0,
            'consultation_fee'    => $request->fee ?? 0,
            'schedule_load'       => 0,
            'biography_note'      => $request->bio,
        ]);

        return redirect()->route('admin.doctors.index')->with('success', 'Doctor added successfully.');
    }

    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        return redirect()->route('admin.doctors.index')->with('success', 'Doctor deleted.');
    }

    public function edit(Doctor $doctor)
    {
        return view('admin.doctors.edit', compact('doctor'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        $request->validate([
            'first_name'   => 'required|string|max:255',
            'last_name'    => 'required|string|max:255',
            'email'        => 'required|email|unique:doctors,email,' . $doctor->DoctorID . ',DoctorID',
            'phone'        => 'nullable|string|max:50',
            'department'   => 'required|string|max:255',
            'status'       => 'nullable|string|in:available,unavailable,onleave',
            'experience'   => 'nullable|integer|min:0|max:50',
            'fee'          => 'nullable|numeric|min:0',
            'bio'          => 'nullable|string',
        ]);

        $doctor->update([
            'first_name'          => $request->first_name,
            'last_name'           => $request->last_name,
            'email'               => $request->email,
            'phone'               => $request->phone ?? '',
            'specialization'      => $request->department,
            'status'              => strtolower($request->status ?? 'onleave'),
            'years_of_experience' => $request->experience ?? 0,
            'consultation_fee'    => $request->fee ?? 0,
            'biography_note'      => $request->bio,
        ]);

        return redirect()->route('admin.doctors.index')->with('success', 'Doctor updated successfully.');
    }
}
