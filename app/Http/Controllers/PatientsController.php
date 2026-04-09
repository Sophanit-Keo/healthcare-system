<?php

namespace App\Http\Controllers;

use App\Models\Patients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PatientsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Patients::with('user');

        // ✅ Filter by status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // ✅ Search
        // if ($request->search) {
        //     $query->where(function ($q) use ($request) {
        //         $q->where('name', 'like', '%' . $request->search . '%')
        //           ->orWhere('email', 'like', '%' . $request->search . '%');
        //     });
        // }

        // ✅ Pagination + latest
        $patients = $query->latest()->paginate(10)->withQueryString();

        return view('admin.patients.index', compact('patients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.patients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
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

    /**
     * Display the specified resource.
     */
    public function show(Patients $patients)
    {
        return view('admin.patients.index', compact('patients'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patients $patients)
    {
        return view('admin.patients.create', compact('patients'));
    }

    /**
     * Update the specified resource in storage.
     */


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

        // ✅ update data
        $patients->update($validatedData);

        // ✅ optional: update user_id
        // $patients->user_id = Auth::id();
        // $patients->save();

        return redirect()
            ->route('admin.patients.index')
            ->with('success', 'Patient updated successfully.');
    }
    /**
     * Remove the specified resource from storage.
     */
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
