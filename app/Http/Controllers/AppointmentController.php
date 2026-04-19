<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::latest()->paginate(10);
        return view('admin.appointments.index', compact('appointments'));
    }

    public function create()
    {
        return view('admin.appointments.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_name' => 'required|string|max:255',
            'email'        => 'nullable|email|max:255',
            'phone'        => 'required|digits_between:9,10',
            'doctor'       => 'nullable|string|max:255',
            'department'   => 'required|string|max:255',
            'date'         => 'required|date',
            'time'         => 'nullable',
            'status'       => 'nullable|string|in:pending,confirmed,cancelled,in_progress',
            'message'      => 'required|string|max:2000',
        ]);

        $validated['status'] = $validated['status'] ?? 'pending';

        if (auth()->check()) {
            $validated['user_id'] = auth()->id();
        }

        Appointment::create($validated);

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Appointment booked successfully.']);
        }

        if (auth()->check() && auth()->user()->role === 'admin') {
            return redirect()->route('admin.appointments.index')
                ->with('success', 'Appointment created successfully.');
        }

        if (auth()->check()) {
            return redirect()->route('dashboard')
                ->with('success', 'Your appointment has been booked successfully!');
        }

        return back()->with('success', 'Your appointment request has been submitted!');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->route('admin.appointments.index')
            ->with('success', 'Appointment deleted.');
    }
}

