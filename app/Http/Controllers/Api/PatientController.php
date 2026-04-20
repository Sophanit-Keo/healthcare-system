<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Http\Resources\PatientResource;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        abort_unless(request()->user()->can('patients.view'), 403);

        $patients = Patient::query()
            ->with('user')
            ->latest()
            ->paginate(10);

        return PatientResource::collection($patients);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePatientRequest $request)
    {
        abort_unless($request->user()->can('patients.create'), 403);

        $patient = Patient::create($request->validated());

        return (new PatientResource($patient->load('user')))
            ->response()
            ->setStatusCode(201);

    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        abort_unless(request()->user()->can('patients.view'), 403);

        return new PatientResource($patient->load('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePatientRequest $request, Patient $patient)
    {
        abort_unless($request->user()->can('patients.update'), 403);

        $patient->update($request->validated());

        return new PatientResource($patient->load('user'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        abort_unless(request()->user()->can('patients.delete'), 403);

        $patient->delete();
        return response()->json(['message' => 'Patient deleted']);
    }
}
