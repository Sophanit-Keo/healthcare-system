<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\LabOrder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LabOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $patientId = $request->user()->patient?->id;

        $orders = LabOrder::query()
            ->with('items')
            ->where('patient_id', $patientId)
            ->latest()
            ->paginate(10);

        return view('patient.lab-orders.index', [
            'orders' => $orders,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort(404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort(404);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, LabOrder $labOrder): View
    {
        abort_unless($labOrder->patient_id === $request->user()->patient?->id, 403);

        return view('patient.lab-orders.show', [
            'order' => $labOrder->load('items'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort(404);
    }
}
