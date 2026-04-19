<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreVitalSignRequest;
use App\Http\Requests\UpdateVitalSignRequest;
use App\Http\Resources\VitalSignResource;
use App\Models\VitalSign;
use Illuminate\Http\Request;

class VitalSignController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_unless($request->user()->can('encounters.view'), 403);

        $query = VitalSign::query();

        if ($request->filled('encounter_id')) {
            $query->where('encounter_id', $request->integer('encounter_id'));
        }

        return VitalSignResource::collection($query->latest()->paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVitalSignRequest $request)
    {
        abort_unless($request->user()->can('encounters.update'), 403);

        $vitalSign = VitalSign::create($request->validated());

        return (new VitalSignResource($vitalSign))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(VitalSign $vitalSign)
    {
        abort_unless(request()->user()->can('encounters.view'), 403);

        return new VitalSignResource($vitalSign);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVitalSignRequest $request, VitalSign $vitalSign)
    {
        abort_unless($request->user()->can('encounters.update'), 403);

        $vitalSign->update($request->validated());

        return new VitalSignResource($vitalSign);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(VitalSign $vitalSign)
    {
        abort_unless(request()->user()->can('encounters.update'), 403);

        $vitalSign->delete();

        return response()->json(['message' => 'Vital sign deleted']);
    }
}
