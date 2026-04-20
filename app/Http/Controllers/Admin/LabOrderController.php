<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Encounter;
use App\Models\Facility;
use App\Models\LabOrder;
use App\Models\LabOrderItem;
use App\Models\Patient;
use App\Services\ConsentService;
use App\Services\StaffScopeService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class LabOrderController extends Controller
{
    public function __construct(
        private readonly ConsentService $consentService,
        private readonly StaffScopeService $staffScopeService,
    )
    {
    }

    
    public function index(Request $request): View
    {
        abort_unless($request->user()->can('lab_orders.view'), 403);

        $orders = LabOrder::query()
            ->with(['patient.user', 'items'])
            ->latest()
            ->paginate(10);

        return view('admin.lab-orders.index', [
            'orders' => $orders,
        ]);
    }

    
    public function create(Request $request): View
    {
        abort_unless($request->user()->can('lab_orders.create'), 403);

        return view('admin.lab-orders.create', [
            'patients' => Patient::query()->with('user')->latest()->limit(200)->get(),
            'encounters' => Encounter::query()->latest()->limit(200)->get(),
            'facilities' => Facility::query()->orderBy('name')->get(),
        ]);
    }

    
    public function store(Request $request): RedirectResponse
    {
        abort_unless($request->user()->can('lab_orders.create'), 403);

        $data = $request->validate([
            'patient_id' => ['required', 'integer', 'exists:patients,id'],
            'encounter_id' => ['nullable', 'integer', 'exists:encounters,id'],
            'facility_id' => ['nullable', 'integer', 'exists:facilities,id'],
            'notes' => ['nullable', 'string'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.test_name' => ['required', 'string', 'max:150'],
            'items.*.test_code' => ['nullable', 'string', 'max:50'],
            'items.*.specimen' => ['nullable', 'string', 'max:100'],
        ]);

        $this->staffScopeService->enforceFacilityScope($request->user(), $data['facility_id'] ?? null);

        if (! empty($data['facility_id'])) {
            $patient = Patient::findOrFail($data['patient_id']);
            if (! $this->consentService->hasActiveFacilityConsent($patient, (int) $data['facility_id'])) {
                throw ValidationException::withMessages([
                    'facility_id' => ['Patient consent is not granted for this facility.'],
                ]);
            }
        }

        $items = $data['items'];
        unset($data['items']);

        DB::transaction(function () use ($data, $items) {
            $order = LabOrder::create([
                ...$data,
                'ordered_at' => now(),
                'status' => 'ordered',
            ]);

            foreach ($items as $item) {
                LabOrderItem::create([
                    'lab_order_id' => $order->id,
                    'test_code' => $item['test_code'] ?? null,
                    'test_name' => $item['test_name'],
                    'specimen' => $item['specimen'] ?? null,
                ]);
            }
        });

        return redirect()
            ->route('admin.lab-orders.index')
            ->with('status', 'lab-order-created');
    }

    
    public function show(Request $request, LabOrder $labOrder): View
    {
        abort_unless($request->user()->can('lab_orders.view'), 403);

        return view('admin.lab-orders.show', [
            'order' => $labOrder->load(['patient.user', 'items', 'encounter']),
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
