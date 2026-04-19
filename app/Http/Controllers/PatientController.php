<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use App\Models\MedicalRecord;
use App\Models\LabTest;
use App\Models\User;

class PatientController extends Controller
{
    public function chat()
    {
        $userId = Auth::id();
        $messages = Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        $doctors = User::where('role', 'doctor')->get();

        return view('patient.chat', compact('messages', 'doctors'));
    }

    public function sendMessage(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'subject' => $request->subject,
            'body' => $request->body,
            'is_read' => false,
        ]);

        return redirect()->route('patient.chat')->with('success', 'Message sent successfully!');
    }

    public function records()
    {
        $records = MedicalRecord::where('user_id', Auth::id())
            ->orderBy('record_date', 'desc')
            ->get();

        return view('patient.records', compact('records'));
    }

    public function labTestForm()
    {
        $labTests = LabTest::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('patient.lab-test', compact('labTests'));
    }

    public function bookLabTest(Request $request)
    {
        $request->validate([
            'test_name' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'test_date' => 'required|date|after_or_equal:today',
            'notes' => 'nullable|string',
        ]);

        LabTest::create([
            'user_id' => Auth::id(),
            'test_name' => $request->test_name,
            'department' => $request->department,
            'test_date' => $request->test_date,
            'notes' => $request->notes,
        ]);

        return redirect()->route('patient.lab-test')->with('success', 'Lab test booked successfully!');
    }

    public function labResults()
    {
        $results = LabTest::where('user_id', Auth::id())
            ->where('status', 'completed')
            ->orderBy('test_date', 'desc')
            ->get();

        $pending = LabTest::where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'in_progress'])
            ->orderBy('test_date', 'desc')
            ->get();

        return view('patient.lab-results', compact('results', 'pending'));
    }
}

