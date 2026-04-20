<?php

namespace App\Http\Controllers;

use App\Models\Patients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientsController extends Controller
{
    public function index(Request $request)
    {
        $query = Patients::with('user');

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $patients = $query->latest()->paginate(10)->withQueryString();

        return view('admin.patients.index', compact('patients'));
    }

    public function create()
    {
        return view('admin.patients.create');
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:patients',
            'phone' => 'required|string|max:20',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'department' => 'nullable|string|max:255',
            'status' => 'nullable|in:active,inactive',
            'notes' => 'nullable|string'
        ]);

        $validatedData['user_id'] = Auth::id();
        Patients::create($validatedData);

        return redirect()->route('admin.patients.index')->with('success', 'Patient created successfully.');
    }

    public function edit(Patients $patient)
    {
        return view('admin.patients.edit', compact('patient'));
    }

    public function update(Request $request, Patients $patient)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:patients,email,' . $patient->PatientID . ',PatientID',
            'phone' => 'required|string|max:20',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'department' => 'nullable|string|max:255',
            'status' => 'nullable|in:active,inactive',
            'notes' => 'nullable|string'
        ]);

        $patient->update($validatedData);

        return redirect()
            ->route('admin.patients.index')
            ->with('success', 'Patient updated successfully.');
    }

    public function destroy(Patients $patient)
    {
        $patient->delete();
        return redirect()->route('admin.patients.index')->with('success', 'Patient deleted.');
    }
}

