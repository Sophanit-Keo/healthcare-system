<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Appointment;
use App\Models\Prescription;
use App\Models\MedicalRecord;
use App\Models\Message;

class HomeController extends Controller
{
    public function redirect()
    {
        $role = Auth::user()->role;

        if ($role == 'patient') {
            $userId = Auth::id();
            $appointments = Appointment::where('user_id', $userId)
                ->orderBy('date', 'asc')
                ->get();
            $prescriptions = Prescription::where('user_id', $userId)
                ->where('status', 'active')
                ->orderBy('start_date', 'desc')
                ->get();
            $medicalRecords = MedicalRecord::where('user_id', $userId)
                ->orderBy('record_date', 'desc')
                ->get();
            $unreadMessages = Message::where('receiver_id', $userId)
                ->where('is_read', false)
                ->orderBy('created_at', 'desc')
                ->get();
            return response()
                ->view('dashboard', compact('appointments', 'prescriptions', 'medicalRecords', 'unreadMessages'))
                ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
                ->header('Pragma', 'no-cache')
                ->header('Expires', '0');
        }

        if ($role == 'admin') {
            return view('admin.dashboard');
        }

        if ($role == 'doctor') {
            return view('Doctor.dashboard');
        }

        return redirect('/');
    }
}

