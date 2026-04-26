<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Http\Resources\PatientResource;
use App\Models\Patient;

class PatientController extends Controller
{
    public function index()
    {
        abort_unless(request()->user()->can('patients.view'), 403);

        $patients = Patient::query()
            ->with('user')
            ->latest()
            ->paginate(10);

        return PatientResource::collection($patients);
    }

    public function store(StorePatientRequest $request)
    {
        abort_unless($request->user()->can('patients.create'), 403);

        $patient = Patient::create($request->validated());

        return (new PatientResource($patient->load('user')))
            ->response()
            ->setStatusCode(201);

    }

    public function show(Patient $patient)
    {
        abort_unless(request()->user()->can('patients.view'), 403);

        return new PatientResource($patient->load('user'));
    }

    public function update(UpdatePatientRequest $request, Patient $patient)
    {
        abort_unless($request->user()->can('patients.update'), 403);

        $patient->update($request->validated());

        return new PatientResource($patient->load('user'));
    }

    public function destroy(Patient $patient)
    {
        abort_unless(request()->user()->can('patients.delete'), 403);

        $patient->delete();

        return response()->json(['message' => 'Patient deleted']);
    }
}
