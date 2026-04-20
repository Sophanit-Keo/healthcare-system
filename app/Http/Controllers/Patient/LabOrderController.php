<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\LabOrder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LabOrderController extends Controller
{
    
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

    
    public function create()
    {
        abort(404);
    }

    
    public function store(Request $request)
    {
        abort(404);
    }

    
    public function show(Request $request, LabOrder $labOrder): View
    {
        abort_unless($labOrder->patient_id === $request->user()->patient?->id, 403);

        return view('patient.lab-orders.show', [
            'order' => $labOrder->load('items'),
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
