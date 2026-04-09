<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class HomeController extends Controller
{
    public function redirect()
    {
        $role = Auth::user()->role;

        if ($role == 'patient') {
            return view('dashboard'); // Points to resources/views/dashboard.blade.php
        }

        if ($role == 'admin') {
            // Make sure you have a view like resources/views/admin/home.blade.php
            // that @extends('admin.layout')
            return view('admin.layout'); // Points to resources/views/admin/layout.blade.php
        }
        if ($role == 'doctor') {
            return view('doctor.dashboard'); // Points to resources/views/doctor/dashboard.blade.php
        }

        return redirect('/');
    }
}
