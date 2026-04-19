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

    public function show(Patients $patients)
    {
        return view('admin.patients.index', compact('patients'));
    }

    public function edit(Patients $patients)
    {
        return view('admin.patients.create', compact('patients'));
    }

    public function update(Request $request, Patients $patients)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:patients,email',
            'phone' => 'required|string|max:20',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'department' => 'nullable|string|max:255',
            'status' => 'nullable|in:active,inactive',
            'notes' => 'nullable|string'
        ]);

        $patients->update($validatedData);

        return redirect()
            ->route('admin.patients.index')
            ->with('success', 'Patient updated successfully.');
    }
    
    public function destroy(Patients $patients)
    {
        //
    }
    public function search(Request $request)
    {
        $query = $request->input('search');
        $patients = Patients::where('email', 'like', "%$query%");
        return view('admin.patients.index', [
            'patients' => $patients->get(),
            'query' => $query
        ]);
    }
}

