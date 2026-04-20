<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::query();

        if ($request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('patient_name', 'like', "%{$search}%")
                  ->orWhere('doctor', 'like', "%{$search}%")
                  ->orWhere('department', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->date) {
            $query->whereDate('date', $request->date);
        }

        $appointments = $query->latest()->paginate(10)->withQueryString();
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

