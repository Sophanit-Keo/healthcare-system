<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PatientController extends Controller
{
    
    public function index(Request $request): View
    {
        abort_unless($request->user()->can('patients.view'), 403);

        $patients = Patient::query()
            ->with('user')
            ->when($request->filled('q'), function ($q) use ($request) {
                $term = '%' . $request->string('q')->toString() . '%';
                $q->whereHas('user', function ($uq) use ($term) {
                    $uq->where('name', 'like', $term)
                        ->orWhere('email', 'like', $term)
                        ->orWhere('username', 'like', $term);
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.patients.index', [
            'patients' => $patients,
        ]);
    }

    
    public function create()
    {
        abort(404);
    }

    
    public function store(Request $request)
    {
        abort(404);
    }

    
    public function show(Request $request, Patient $patient): View
    {
        abort_unless($request->user()->can('patients.view'), 403);

        return view('admin.patients.show', [
            'patient' => $patient->load('user'),
        ]);
    }

    
    public function edit(string $id)
    {
        abort(404);
    }

    
    public function update(Request $request, string $id)
    {
        abort(404);
    }

    
    public function destroy(string $id)
    {
        abort(404);
    }
}
